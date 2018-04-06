<?php

namespace BlogBundle\Entity;

/**
 * EntradaEtiqueta
 */
class EntradaEtiqueta
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BlogBundle\Entity\Entrada
     */
    private $entrada;

    /**
     * @var \BlogBundle\Entity\Etiqueta
     */
    private $etiqueta;


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
     * Set entrada
     *
     * @param \BlogBundle\Entity\Entrada $entrada
     *
     * @return EntradaEtiqueta
     */
    public function setEntrada(\BlogBundle\Entity\Entrada $entrada = null)
    {
        $this->entrada = $entrada;

        return $this;
    }

    /**
     * Get entrada
     *
     * @return \BlogBundle\Entity\Entrada
     */
    public function getEntrada()
    {
        return $this->entrada;
    }

    /**
     * Set etiqueta
     *
     * @param \BlogBundle\Entity\Etiqueta $etiqueta
     *
     * @return EntradaEtiqueta
     */
    public function setEtiqueta(\BlogBundle\Entity\Etiqueta $etiqueta = null)
    {
        $this->etiqueta = $etiqueta;

        return $this;
    }

    /**
     * Get etiqueta
     *
     * @return \BlogBundle\Entity\Etiqueta
     */
    public function getEtiqueta()
    {
        return $this->etiqueta;
    }
}

