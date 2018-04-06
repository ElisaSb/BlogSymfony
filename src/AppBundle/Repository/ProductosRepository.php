<?php
namespace AppBundle\Repository;

class ProductosRepository extends \Doctrine\ORM\EntityRepository {
    
    public function getProductos(){
        $em = $this->getEntityManager();
        $query = $this->createQueryBuilder("p")
                ->where("p.price > :price")
                ->setParameter("price", "20")
                ->getQuery();
        $productos = $query->getResult();
        return $productos;
    }
}

