<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Entrada;
use BlogBundle\Form\EntradaType;
use Symfony\Component\HttpFoundation\Session\Session;

class EntradaController extends Controller
{

    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function indexAction(Request $request, $pagina)
    {
        $em = $this->getDoctrine()->getManager();
        $entrada_repo = $em->getRepository("BlogBundle:Entrada");
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");

        $categorias = $categoria_repo->findAll();

        $numeroPagina = 5;
        $entradas = $entrada_repo->getPaginaEntradas($numeroPagina, $pagina);
        $totalItems = count($entradas);
        $pagesCount = ceil($totalItems/$numeroPagina);

        return $this->render("BlogBundle:Entrada:index.html.twig", array(
            "entradas" => $entradas,
            "categorias" => $categorias,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "pagina" => $pagina,
            "pagina_m" => $pagina
        ));
    }

    public function addAction(Request $request)
    {

        $entrada = new Entrada();
        $form = $this->createForm(EntradaType::class, $entrada);

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categorias = $categoria_repo->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $categoria_repo = $em->getRepository("BlogBundle:Categoria");
                $entrada_repo = $em->getRepository("BlogBundle:Entrada");
                $categorias = $categoria_repo->findAll();

                $entrada = new Entrada();
                $entrada->setTitulo($form->get("titulo")->getData());
                $entrada->setContenido($form->get("contenido")->getData());
                $entrada->setEstado($form->get("estado")->getData());

                //Subir fichero
                $fichero = $form["imagen"]->getData();
                if( !empty($fichero) && $fichero!=null ) {
                    $ext = $fichero->guessExtension();
                    $fichero_nombre = time() . "." . $ext;
                    $fichero->move("uploads", $fichero_nombre);
                    $entrada->setImagen($fichero_nombre);
                }else{
                    $entrada->setImagen(null);
                }

                $categoria = $categoria_repo->find($form->get("categoria")->getData());
                $entrada->setCategoria($categoria);

                $usuario = $this->getUser();
                $entrada->setUsuario($usuario);

                $em->persist($entrada);
                $flush = $em->flush();

                $entrada_repo->guardarEntradaEtiquetas(
                    $form->get("etiquetas")->getData(), $form->get("titulo")->getData(), $categoria, $usuario
                );

                if ($flush == null) {
                    $status_success = "Entrada creada correctamente.";
                    $status_error = "";
                } else {
                    $status_success = "";
                    $status_error = "Error al crear la entrada.";
                }

                $this->session->getFlashBag()->add('status_success', $status_success);
                return $this->redirectToRoute("blog_homepage");
            } else {
                $status_success = "";
                $status_error = "El formulario de crear entrada no es válido.";
            }

            $this->session->getFlashBag()->add('status_error', $status_error);
        }

        return $this->render("BlogBundle:Entrada:add.html.twig", array(
            "form" => $form->createView(),
            "categorias" => $categorias
        ));
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $entrada_repo = $em->getRepository("BlogBundle:Entrada");
        $entrada_etiqueta_repo = $em->getRepository("BlogBundle:EntradaEtiqueta");

        $entrada = $entrada_repo->find($id);
        $entrada_etiquetas = $entrada_etiqueta_repo->findBy(array("entrada" => $entrada));
        foreach ($entrada_etiquetas as $et) {
            if (is_object($et)) {
                $em->remove($et);
                $em->flush();
            }
        }

        if (is_object($entrada)) {
            $em->remove($entrada);
            $em->flush();
        }
        return $this->redirectToRoute("blog_homepage");
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entrada_repo = $em->getRepository("BlogBundle:Entrada");
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categorias = $categoria_repo->findAll();

        $entrada = $entrada_repo->find($id);
        $entrada_imagen = $entrada->getImagen();

        $etiquetas="";
        foreach ($entrada->getEntradaEtiqueta() as $entradaEtiqueta){
            $etiquetas.=$entradaEtiqueta->getEtiqueta()->getNombre().",";
        }

        $form = $this->createForm(EntradaType::class, $entrada);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                /*
                $entrada->setTitulo($form->get("titulo")->getData());
                $entrada->setContenido($form->get("contenido")->getData());
                $entrada->setEstado($form->get("estado")->getData());
                */

                //Subir fichero
                $fichero = $form["imagen"]->getData();
                if( !empty($fichero) && $fichero!=null ) {
                    $ext = $fichero->guessExtension();
                    $fichero_nombre = time() . "." . $ext;
                    $fichero->move("uploads", $fichero_nombre);

                    $entrada->setImagen($fichero_nombre);
                } else{
                    $entrada->setImagen($entrada_imagen);
                }

                $categoria = $categoria_repo->find($form->get("categoria")->getData());
                $entrada->setCategoria($categoria);

                $usuario = $this->getUser();
                $entrada->setUsuario($usuario);

                $em->persist($entrada);
                $flush = $em->flush();

                $entrada_etiqueta_repo = $em->getRepository("BlogBundle:EntradaEtiqueta");

                $entrada_etiquetas = $entrada_etiqueta_repo->findBy(array("entrada" => $entrada));
                foreach ($entrada_etiquetas as $et) {
                    if (is_object($et)) {
                        $em->remove($et);
                        $em->flush();
                    }
                }

                $entrada_repo->guardarEntradaEtiquetas(
                    $form->get("etiquetas")->getData(), $form->get("titulo")->getData(), $categoria, $usuario
                );

                if($flush == null){
                    $status_success = "La entrada se ha editado correctamente.";
                    $status_error = "";
                } else {
                    $status_success = "";
                    $status_error = "Error al editar la entrada.";
                }

                $this->session->getFlashBag()->add('status_success', $status_success);
                return $this->redirectToRoute("blog_homepage");

            } else {
                $status_success = "";
                $status_error = "El formulario de edición de entrada no es válido";
            }

            $this->session->getFlashBag()->add('status_error', $status_error);
        }

        return $this->render("BlogBundle:Entrada:edit.html.twig", array(
            "form" => $form->createView(),
            "entrada" => $entrada,
            "etiquetas" => $etiquetas,
            "categorias" => $categorias
        ));
    }

    public function detallarAction($id){

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categorias = $categoria_repo->findAll();
        $entrada_repo = $em->getRepository("BlogBundle:Entrada");
        $entrada = $entrada_repo->find($id);

        return $this->render("BlogBundle:Entrada:detalle.html.twig", array(
            "entrada" => $entrada,
            "categorias" => $categorias
        ));
    }

}
