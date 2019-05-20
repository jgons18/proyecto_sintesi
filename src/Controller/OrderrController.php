<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 20/05/19
 * Time: 16:17
 */

namespace App\Controller;

use App\Entity\Orderr;
use App\Entity\Detail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OrderrController extends AbstractController
{
    /**
     * Función para listar los pedidos
     * @Route("/pedidos", name="app_pedidos")
     */
    public function listorders(){
        $orderr = $this->getDoctrine()->getRepository(Orderr::class)->findAll();
        $detail = $this->getDoctrine()->getRepository(Detail::class)->findAll();
        return $this->render('order/index.html.twig', [
            'orderrs'=>$orderr,
            'details' => $detail]);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('dateeorderr' => 'ASC'));
    }

}