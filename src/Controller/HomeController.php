<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 09/05/19
 * Time: 17:41
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/",name="app_homepage")
     */
    public function homepage(){

        return $this->render('home/home.html.twig');
    }
}