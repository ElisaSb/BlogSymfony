<?php

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entrada
 */
class Entrada
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $contenido;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $imagen;

    /**
     * @var \BlogBundle\Entity\Categorias
     */
    private $categoria;

    /**
     * @var \BlogBundle\Entity\Usuarios
     */
    private $usuario;

    protected $entradaEtiqueta;
    
    public function __construct(){
        $this->entradaEtiqueta = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Entrada
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Entrada
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Entrada
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Entrada
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set categoria
     *
     * @param \BlogBundle\Entity\Categorias $categoria
     *
     * @return Entrada
     */
    public function setCategoria(\BlogBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \BlogBundle\Entity\Categorias
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set usuario
     *
     * @param \BlogBundle\Entity\Usuarios $usuario
     *
     * @return Entrada
     */
    public function setUsuario(\BlogBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \BlogBundle\Entity\Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    public function addEntradaEtiqueta(\BlogBundle\Entity\Etiqueta $etiqueta){
        $this->entradaEtiqueta[] = $etiqueta;
        return $this;
        
    }
    
    public function getEntradaEtiqueta(){
        
        return $this->entradaEtiqueta;
        
    }
}

