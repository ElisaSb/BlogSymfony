<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Productos;
use AppBundle\Form\ProductosType;
use Symfony\Component\Validator\Constraints as Assert;

class PruebasController  extends Controller
{
    /**
     * @Route("/pruebas/index", name="pruebasIndex")
     */
    public function indexAction(Request $request, $nombre, $apellido, $pagina)
    {
        /*return $this->redirect($this->generateUrl("holaMundo"));
        var_dump($request->query->get("hola"));
        var_dump($request->get("holapost"));
        die();*/
        
        $productos = array(array("producto"=>"Consola","precio"=>2),
                     array("producto"=>"Consola 2","precio"=>3),
                     array("producto"=>"Consola 3","precio"=>4),
                     array("producto"=>"Consola 4","precio"=>5),
                     array("producto"=>"Consola 5","precio"=>6)
            );
        
        $fruta=array("manzana"=>"golden","pera"=>"rica");
        
        return $this->render('AppBundle:pruebas:index.html.twig', array(
            'saludo' => "Hola ".$nombre.", bienvenido ^^",
            'texto' => $nombre." ".$apellido ." se encuenta en la página --> ".$pagina,
            'productos' => $productos,
            'fruta' => $fruta
        ));
    }
    
    public function createAction(){
        
        $productos = new Productos();
        $productos->setName("The Witcher 3: Wild Hunt");
        $productos->setDescription("Videojuego basado en las aventuras de Geralt de Rivia");
        $productos->setPrice(59);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($productos);
        $flush=$em->flush();
        
        if($flush != null){
            echo "El producto NO se ha creado.";
        }else{
            echo "El producto se ha creado correctamente.";
        }
        
        die();
    }
    
    public function readAction(){
        
        $em = $this->getDoctrine()->getManager();
        $productos_repo = $em->getRepository("AppBundle:Productos");
        
        $productos = $productos_repo->findAll();
        
        foreach($productos as $producto){
            echo $producto->getId()."<br/>";
            echo $producto->getName()."<br/>";
            echo $producto->getDescription()."<br/>";
            echo $producto->getPrice()."<br/><hr/>";
        }
        
//      El findOneBy[...]() sirve para buscar por alguna propiedad del objeto que cumpla cierto valor.        
//        $productos_20 = $productos_repo->findOneByPrice(140);
//        echo $productos_20->getName()."<br/>";
        
//      De la siguiente forma obtenemos los registros que cumplen la norma en este caso que su precio sea 20.
//      Sirve para buscar los datos según unos parámetros y condiciones. 
//        $productos_20 = $productos_repo->findBy(array("price"=>20));
//        
//        foreach($productos_20 as $producto){
//            echo $producto->getName()."<br/>";
//        }
        
        die();
    }
    
    public function updateAction($id, $name, $description, $price){
        
        $em = $this->getDoctrine()->getManager();
        $productos_repo = $em->getRepository("AppBundle:Productos");
        $producto = $productos_repo->find($id);
        $producto->setName($name);
        $producto->setDescription($description);
        $producto->setPrice($price);
        
        $em->persist($producto);
        $flush=$em->flush();
        
        if($flush != null){
            echo "El producto NO se ha actualizado.";
        }else{
            echo "El producto se ha actualizado correctamente.";
        }
        
        die();
    }
    
    public function deleteAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $productos_repo = $em->getRepository("AppBundle:Productos");
        
        $producto = $productos_repo->find($id);
        $em->remove($producto);
        
        $flush=$em->flush();
        
        if($flush != null){
            echo "El producto NO se ha borrado.";
        }else{
            echo "El producto se ha borrado correctamente.";
        }
        
        die();
    }
   
    public function nativeSQLAction(){
        $em = $this->getDoctrine()->getManager();
        
//        Método 1 -----
//        Consultas directamente con la base de datos (requiere conexion)
//        $db = $em->getConnection();
//       
//        $query = "SELECT * from productos where price>20";
//        $stmt = $db->prepare($query);
//        $params = array();
//        $stmt->execute($params);
//        
//        $productos = $stmt->fetchAll();
//        
//        foreach($productos as $producto){
//            echo $producto["id"].".- ".$producto["name"]."<br/><hr/>";
//        }
        
//        Método 2 -----
//        Otra forma de hacer consulta es la siguiente, 
//        haciendo posible hacer por ejemplo joins, consulta complejas
//        $query = $em->createQuery("
//            SELECT p FROM AppBundle:Productos p
//            WHERE p.price > :price
//            ")->setParameter("price", "20");
//        $productos = $query->getResult();
//        
//        foreach($productos as $producto){
//            echo $producto->getId()."<br/>";
//            echo $producto->getName()."<br/><hr/>";
//        }
        
        
//        Método 3 -----
//        Usando Query Builder
//        $productos_repo = $em->getRepository("AppBundle:Productos");
//        $query = $productos_repo->createQueryBuilder("p")
//                ->where("p.price > :price")
//                ->setParameter("price", "20")
//                ->getQuery();
//        $productos = $query->getResult();
//        foreach($productos as $producto){
//            echo $producto->getId()."<br/>";
//            echo $producto->getName()."<br/><hr/>";
//        }
        
//        class ProductosRepository extends \Doctrine\ORM\EntityRepository {
//    
//    public function getProductos(){
//        $em = $this->getManager();
//        $query = $this->createQueryBuilder("p")
//                ->where("p.price > :price")
//                ->setParameter("price", "20")
//                ->getQuery();
//        $productos = $query->getResult();
//        return $productos;
//    }
//}
        
        $productos_repo = $em->getRepository("AppBundle:Productos");
        $productos = $productos_repo->getProductos();
        
        foreach($productos as $producto){
            echo $producto->getId()."<br/>";
            echo $producto->getName()."<br/><hr/>";
        }
        
        die();
    }
    
    public function formAction(Request $request){
        
        $producto = new Productos();
        $form = $this->createForm(ProductosType::class,$producto);
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            $status = "Formulaio válido";
            $data = array(
                "name" => $form->get("name")->getData(),
                "description" => $form->get("description")->getData(),
                "price" => $form->get("price")->getData()
            );
        }else{
            $status = null;
            $data = null;
        }
        
        
        return $this->render('AppBundle:pruebas:form.html.twig', array(
            'form' => $form->createView(),
            'status' => $status,
            'data' => $data
        ));
    }
    
    public function validarEmailAction($email){
        $emailContraint = new Assert\Email();
        $emailContraint->message = "Pasame un correo correcto";
        
        $error = $this->get("validator")->validate(
                $email,
                $emailContraint
                );
        if(count($error)==0){
            echo "El correo es válido.";
        }else{
            echo $error[0]->getMessage();
        }
        
        die();
    }
}
