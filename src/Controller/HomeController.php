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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{

    /**
     * @Route("/",name="app_homepage")
     */
    public function homepage(){
        /*//creación de la cookie para saber si el usuario las ha aceptado
        $response = new Response();
        //indico el tiempo que durará la cookie
        $time = time() + (3600 * 24 * 7);
        //le indico los valores
        $response->headers->setCookie(new Cookie("aceptarcookies", 0,$time));
        $response->sendHeaders();*/

        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('home/home.html.twig', [
            'products'=>$products]);
    }



}