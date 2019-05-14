<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 14/05/19
 * Time: 17:07
 */

namespace App\Controller;


use App\Entity\Product;
use http\Env\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    
}