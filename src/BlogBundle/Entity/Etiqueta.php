<?php

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Etiqueta
 */
class Etiqueta {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;
    
    protected $entradaEtiqueta;

    public function __construct() {
        $this->entradaEtiqueta = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Etiqueta
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Etiqueta
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function addEntradaEtiqueta(\BlogBundle\Entity\Etiqueta $etiqueta) {
        $this->entradaEtiqueta[] = $etiqueta;
        return $this;
    }

    public function getEntradaEtiqueta() {

        return $this->entradaEtiqueta;
    }

}
