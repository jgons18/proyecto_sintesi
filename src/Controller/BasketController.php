<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Form\ProductEditType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BasketController extends AbstractController
{
    /**
     * @Route("/cestas", name="basket")
     */
    public function listbaskets()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('basket/index.html.twig', [
            'products' => $products]);
    }

}
