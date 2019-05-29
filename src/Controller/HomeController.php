<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 09/05/19
 * Time: 17:41
 */

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{

    /**
     * @Route("/",name="app_homepage")
     */
    public function homepage(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('home/home.html.twig', [
            'products'=>$products]);
    }



}