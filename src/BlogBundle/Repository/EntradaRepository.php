<?php

namespace BlogBundle\Repository;

use BlogBundle\Entity\Etiqueta;
use \BlogBundle\Entity\EntradaEtiqueta;
use Doctrine\ORM\Tools\Pagination\Paginator;

class EntradaRepository extends \Doctrine\ORM\EntityRepository {

    public function guardarEntradaEtiquetas($etiquetas = null, $titulo = null, $categoria = null, $usuario = null, $entrada = null) {
        $em = $this->getEntityManager();

        $etiqueta_repo = $em->getRepository("BlogBundle:Etiqueta");

        if ($entrada == null) {
            $entrada = $this->findOneBy(array(
                "titulo" => $titulo,
                "categoria" => $categoria,
                "usuario" => $usuario
            ));
        } else {
            
        }

        //$etiquetas -= ",";

        $etiquetas = explode(", ", $etiquetas);

        foreach ($etiquetas as $etiqueta) {
            $isset_etiqueta = $etiqueta_repo->findOneBy(array(
                "nombre" => $etiqueta
            ));

            if (count($isset_etiqueta) == 0) {
                $etiqueta_obj = new Etiqueta();
                $etiqueta_obj->setNombre($etiqueta);
                $etiqueta_obj->setDescripcion($etiqueta);

                //if(!empty(trim($etiqueta))) {
                $em->persist($etiqueta_obj);
                $em->flush();
                //}
            }

            $etiqueta = $etiqueta_repo->findOneBy(array(
                "nombre" => $etiqueta
            ));

            $entradaEtiqueta = new EntradaEtiqueta();
            $entradaEtiqueta->setEntrada($entrada);
            $entradaEtiqueta->setEtiqueta($etiqueta);

            $em->persist($entradaEtiqueta);
        }

        $flush = $em->flush();

        return $flush;
    }

    public function getPaginaEntradas($numeroPagina=5, $currentPagina=1){
        $em = $this->getEntityManager();

        $dql = "SELECT e FROM BlogBundle\Entity\Entrada e ORDER BY e.id DESC";

        $query = $em->createQuery($dql)
            ->setFirstResult($numeroPagina*($currentPagina-1))
            ->setMaxResults($numeroPagina);

        $paginador = new Paginator($query, $fetchJoinCollection = true);
        return $paginador;
    }

}
