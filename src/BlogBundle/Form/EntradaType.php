<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntradaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('titulo', TextType::class, array(
                    "label" => "Titulo:",
                    "required" => "required",
                    "attr" => array(
                        "class" => "form-titulo form-control"
            )))
                ->add('contenido', TextareaType::class, array(
                    "label" => "Contenido:",
                    "attr" => array(
                        "class" => "form-contenido form-control"
            )))
                ->add('estado', ChoiceType::class, array(
                    "label" => "Estado:",
                    "choices"=> array(
                        "Público"=>"publico",
                        "Privado"=>"privado"
                    ),
                    "attr" => array(
                        "class" => "form-estado form-control"
            )))
                ->add('imagen', FileType::class, array(
                    "label" => "Imagen:",
                    "attr" => array(
                        "class" => "form-imagen form-control"
            )))
                ->add('categoria', EntityType::class, array(
                    "class" => "BlogBundle:Categoria",
                    "label" => "Categorías:",
                    "attr" => array(
                        "class" => "form-categoria form-control"
            )))
//                ->add('usuario', TextType::class, array(
//                    "label" => "Nombre:",
//                    "attr" => array(
//                        "class" => "form-nombre form-control"
//            )))
                ->add('etiquetas', TextType::class, array(
                    "mapped" => false,
                    "label" => "Etiquetas:",
                    "attr" => array(
                        "class" => "form-etiquetas form-control"
            )))
                ->add('Guardar', SubmitType::class, array(
                    "attr" => array(
                        "class" => "form-submit btn btn-success"
        )));
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Entrada'
        ));
    }

}
