<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 09/05/19
 * Time: 17:41
 */

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Season;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends AbstractController
{

    /**
     * @Route("/",name="app_homepage")
     */

    public function homepage(){
        $session = new Session();
       // $session->set('token', 'a6c1e0b6');
       // $session->start();
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('home/home.html.twig', [
            'products'=>$products]);
    }


}