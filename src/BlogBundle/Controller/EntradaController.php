<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Entrada;
use BlogBundle\Form\EntradaType;
use Symfony\Component\HttpFoundation\Session\Session;

class EntradaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $entrada_repo = $em->getRepository("BlogBundle:Entrada");
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");

        $entradas = $entrada_repo->findAll();
        $categorias = $categoria_repo->findAll();

        return $this->render("BlogBundle:Entrada:index.html.twig", array(
                    "entradas" => $entradas,
                    "categorias" => $categorias
        ));
    }

    public function addAction(Request $request) {

        $entrada = new Entrada();
        $form = $this->createForm(EntradaType::class, $entrada);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $categoria_repo = $em->getRepository("BlogBundle:Categoria");
                $entrada_repo = $em->getRepository("BlogBundle:Entrada");

                $entrada = new Entrada();
                $entrada->setTitulo($form->get("titulo")->getData());
                $entrada->setContenido($form->get("contenido")->getData());
                $entrada->setEstado($form->get("estado")->getData());

                //Subir fichero
                $fichero = $form["imagen"]->getData();
                $ext = $fichero->guessExtension();
                $fichero_nombre = time() . "." . $ext;
                $fichero->move("uploads", $fichero_nombre);
                $entrada->setImagen($fichero_nombre);

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
                $status_error = "Error al crear la entrada, porque el formulario no es válido.";
            }

            $this->session->getFlashBag()->add('status_error', $status_error);
        }

        return $this->render("BlogBundle:Entrada:add.html.twig", array(
                    "form" => $form->createView()
        ));
    }

    public function deleteAction($id) {

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

}
