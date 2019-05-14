<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 14/05/19
 * Time: 17:07
 */

namespace App\Controller;


use App\Entity\Product;
//use http\Env\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

    /**
     * Función para listar los productos que sean frutas
     * @Route("/frutas", name="app_frutas")
     */
    public function listfruit(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('fruit/index.html.twig', [
            'products'=>$products]);
    }

    /**
     * Función para añadir un nuevo producto
     * @Route("/frutas/newproduct", name="new_product")
     */
    public function addProduct(Request $request){
        //crear un nuevo objeto producto
        $product = new Product();

        //como este método lo utilizamos para añadir productos que son FRUTAS
        //le pondremos por defecto el campo isfruta en true
        $isfruit=true;
        $product->setIsfruit($isfruit);

        //creamos el formulario
        $form=$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //capturo los datos
            $product=$form->getData();

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success','Producto creado correctamente');
            return $this->redirectToRoute('frutas');
        }
        //renderizar formulario
        return $this->render('fruit/new_product.html.twig', [
            'error'=>$error,
            'form'=>$form->createView()
        ]);
    }
}