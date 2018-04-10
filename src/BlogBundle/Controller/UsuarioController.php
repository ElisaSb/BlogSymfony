<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Usuario;
use BlogBundle\Form\UsuarioType;
use Symfony\Component\HttpFoundation\Session\Session;

class UsuarioController extends Controller
{

    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categorias = $categoria_repo->findAll();

        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        //$email = "ana@correo.com";

        /*if($form->isSubmitted()){
            $email = $form->get("email")->getData();
        }*/

        return $this->render("BlogBundle:Usuario:login.html.twig", array(
            "error" => $error,
            "last_username" => $lastUsername,
            "form" => $form->CreateView(),
            "categorias" => $categorias
            //"email" => $email
        ));
    }

    /*public function validarAction($email)
    {

        $em = $this->getDoctrine()->getManager();

        //$email = "ana@correo.com";

        $usuario_repo = $em->getRepository("BlogBundle:Usuario");
        $usuario_buscado = $usuario_repo->findBy(["email" => $email]);

        if (count($usuario_buscado) == 0) {
            $status_success = "";
            $status_error = "El email es incorrecto o no está registrado";
        } else {
            $status_success = "Encontrado";
            $status_error = "";

            $this->session->getFlashBag()->add('status_success', $status_success);
        }

        $this->session->getFlashBag()->add('status_error', $status_error);

        return $this->redirectToRoute("login");
    }*/

    public function logoutAction(Request $request)
    {
        return $this->redirectToRoute("blog_homepage");
    }

    public function registroAction(Request $request)
    {

        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        $em = $this->getDoctrine()->getManager();
        $categoria_repo = $em->getRepository("BlogBundle:Categoria");
        $categorias = $categoria_repo->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $usuario = new Usuario;
                $usuario->setNombre($form->get("nombre")->getData());
                $usuario->setApellido($form->get("apellido")->getData());
                $usuario->setEmail($form->get("email")->getData());

                $factory = $this->get("security.encoder_factory");
                $encoder = $factory->getEncoder($usuario);
                $pass = $encoder->encodePassword($form->get("pass")->getData(), $usuario->getSalt());

                $usuario->setPass($pass);
                $usuario->setRol("ROLE_USER");
                $usuario->setImagen(null);

                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $flush = $em->flush();

                if ($flush == null) {
                    $status_success = "El usuario se ha creado correctamente";
                    $status_error = "";
                } else {
                    $status_success = "";
                    $status_error = "No te has registrado correctamente";
                }
            } else {
                $status_success = "";
                $status_error = "El formulario de registro de usuario no es válido";
            }

            $this->session->getFlashBag()->add("status_success", $status_success);
            $this->session->getFlashBag()->add("status_error", $status_error);
        }

        return $this->render("BlogBundle:Usuario:registro.html.twig", array(
            "form" => $form->CreateView(),
            "categorias" => $categorias
        ));
    }

}
