<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Form\ProductEditType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OffersController extends AbstractController
{
    /**
     * @Route("/ofertas", name="offers")
     */
    public function index()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('offers/index.html.twig', [
            'products'=>$products]);
    }

    /**
     * Función para listar los productos que sean frutas
     * @Route("/ofertas_old", name="app_fruits")
     */
    public function listfruitoffers(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('offers/productsoffer.html.twig', [
            'products'=>$products]);

    }




}
