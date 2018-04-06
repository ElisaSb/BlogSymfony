<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array("required"=>"required","attr"=>array(
                "class"=>"form-nombre"
            )))
            //->add('description', TextareaType::class)
            ->add('description', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, array(
                "choices"=> array(
                    "pelicula" => "pelicula",
                    "libro" => "libro",
                    "videojuego" => "videojuego",
                    "movil" => "movil"
                )
            ))
            //->add('price', TextType::class)
            ->add('price', \Symfony\Component\Form\Extension\Core\Type\CheckboxType::class, array(
                "label" => "¿Desea mostrar el precio?",
                "required" => false
            ))
            ->add('Guardar', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Productos'
        ));
    }
}
