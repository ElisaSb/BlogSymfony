<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Etiqueta;
use BlogBundle\Form\EtiquetaType;
use Symfony\Component\HttpFoundation\Session\Session;

class EtiquetaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $etiqueta_repo = $em->getRepository("BlogBundle:Etiqueta");
        $etiquetas = $etiqueta_repo->findAll();

        return $this->render("BlogBundle:Etiqueta:index.html.twig", array(
                    "etiquetas" => $etiquetas
        ));
    }

    public function addAction(Request $request) {

        $etiqueta = new Etiqueta();
        $form = $this->createForm(EtiquetaType::class, $etiqueta);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $etiqueta = new Etiqueta();
                $etiqueta->setNombre($form->get("nombre")->getData());
                $etiqueta->setDescripcion($form->get("descripcion")->getData());

                $em->persist($etiqueta);
                $flush = $em->flush();

                if ($flush == null) {
                    $status_success = "Etiqueta creada correctamente.";
                    $status_error = "";
                } else {
                    $status_success = "";
                    $status_error = "Error al crear la etiqueta.";
                }

                $this->session->getFlashBag()->add('status_success', $status_success);
                return $this->redirectToRoute("blog_index_etiqueta");
            } else {
                $status_success = "";
                $status_error = "Error: La etiqueta no se ha creado por fallos de validación.";
            }

            $this->session->getFlashBag()->add('status_error', $status_error);
        }

        return $this->render("BlogBundle:Etiqueta:add.html.twig", array(
                    "form" => $form->createView()
        ));
    }

    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $etiqueta_repo = $em->getRepository("BlogBundle:Etiqueta");
        $etiqueta = $etiqueta_repo->find($id);
        
        if(count($etiqueta->getEntradaEtiqueta()) == 0) {
            $em->remove($etiqueta);
            $em->flush();
        }

        return $this->redirectToRoute("blog_index_etiqueta");
    }

}