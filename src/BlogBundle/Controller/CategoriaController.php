<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Categoria;
use BlogBundle\Form\CategoriaType;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoriaController extends Controller
{

    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categorias = $categoria_repo->findAll();

        return $this->render("BlogBundle:Categoria:index.html.twig", array(
            "categorias" => $categorias
        ));
    }

    public function addAction(Request $request)
    {

        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categorias = $categoria_repo->findAll();

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $categoria = new Categoria();
                $categoria->setNombre($form->get("nombre")->getData());
                $categoria->setDescripcion($form->get("descripcion")->getData());

                $em->persist($categoria);
                $flush = $em->flush();

                if ($flush == null) {
                    $status_success = "Categoria creada correctamente.";
                    $status_error = "";
                } else {
                    $status_success = "";
                    $status_error = "Error al crear la categoria.";
                }

                $this->session->getFlashBag()->add('status_success', $status_success);
                return $this->redirectToRoute("blog_index_categoria");
            } else {
                $status_success = "";
                $status_error = "Error: La categoria no se ha creado por fallos de validación.";
            }

            $this->session->getFlashBag()->add('status_error', $status_error);
        }

        return $this->render("BlogBundle:Categoria:add.html.twig", array(
            "form" => $form->createView(),
            "categorias" => $categorias
        ));
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categoria = $categoria_repo->find($id);

        if (count($categoria->getEntradas()) == 0) {
            $em->remove($categoria);
            $em->flush();
        }

        return $this->redirectToRoute("blog_index_categoria");
    }

    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categoria = $categoria_repo->find($id);
        $categorias = $categoria_repo->findAll();

        $form = $this->createForm(CategoriaType::class, $categoria);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $categoria->setNombre($form->get("nombre")->getData());
                $categoria->setDescripcion($form->get("descripcion")->getData());

                $em->persist($categoria);
                $flush = $em->flush();

                if ($flush == null) {
                    $status_success = "La categoria se ha editado correctamente.";
                    $status_error = "";
                } else {
                    $status_success = "";
                    $status_error = "Error al editar la categoria.";
                }

                $this->session->getFlashBag()->add('status_success', $status_success);
                return $this->redirectToRoute("blog_index_categoria");
            } else {
                $status_success = "";
                $status_error = "Error: La categoria no se ha editado por fallos de validación.";
            }

            $this->session->getFlashBag()->add('status_error', $status_error);
        }

        return $this->render("BlogBundle:Categoria:edit.html.twig", array(
            "form" => $form->createView(),
            "categorias" => $categorias
        ));
    }

    public function categoriaAction($id, $pagina)
    {

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categoria = $categoria_repo->find($id);

        $entrada_repo = $em->getRepository("BlogBundle:Entrada");
        $entradas = $entrada_repo->getCategoriaEntradas($categoria, 3, $pagina);

        $totalItems = count($entradas);
        $pagesCount = ceil($totalItems/3);

        return $this->render("BlogBundle:Categoria:categoria.html.twig", [
            "categoria" => $categoria,
            "categorias" => $categoria_repo->findAll(),
            "entradas" => $entradas,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "pagina" => $pagina,
            "pagina_m" => $pagina
        ]);
    }

}
