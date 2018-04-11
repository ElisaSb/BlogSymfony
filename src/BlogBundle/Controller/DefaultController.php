<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    
    public function indexAction(){
        return $this->render('BlogBundle:Default:index.html.twig');
    }

    /*public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entrada_repo = $em->getRepository("BlogBundle:Entrada");
        $entradas = $entrada_repo->findAll();

        foreach ($entradas as $entrada){
            echo "<strong>Entrada:</strong> ";
            echo $entrada->getTitulo().",<br/><strong>categoría: </strong>";
            echo $entrada->getCategoria()->getNombre().",<br/><strong>usuario: </strong>";
            echo $entrada->getUsuario()->getNombre().".<br/><hr/>";
        }

        die();
        return $this->render('BlogBundle:Default:index.html.twig');
    }*/
}
