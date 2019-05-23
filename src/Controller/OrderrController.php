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
use App\Entity\Product;
use App\Form\OrderrType;
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

    /**
     * Función  para añadir productos al carrito
     * @Route("/pedido/add/{id}", name="add_product_to_basket")
     */
    public function addProductOrder(Request $request,$id)
    {
        $orderr = new Orderr();


        //obtengo el usuario que está haciendo el pedido
        $user=$this->getUser();

        //obtengo la hora en la que se ha empezado el pedido
        $orderCreate=$orderr->getDateeorderr();



        $detail = new Detail();
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(array('id' => $id));
        $prducttoaddtobasket = $product[0];

        //$prducttoaddtobasket=$this->getUnitprice();

        $detail->setQuantity(+1);

        $form = $this->createForm(OrderrType::class, $prducttoaddtobasket);

        $form->handleRequest($request);
        $error = $form->getErrors();

        $form->getData();


        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($detail);
        //$entityManager->flush(); //cuando lo ejecutemos si le ponemos el flush
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Product p
            SET p.stock = p.stock -'.$quanprod.',
            p.reservedstocks = p.reservedstocks-'.$quanprod.'WHERE p.id ='.$idproduct);

        $res = $query->getResult();

        return $this->render('fruit/index.html.twig', array(
            'res' => $res));

        /*return $this->render('fruit/index.html.twig',[
            'error'=>$error,
            'products'=>$product,
            'form'=>$form->createView()
        ]);*/

    }

    /**
     * Función para ver mis pedidos
     * @Route("/profile/my-orders/{id}", name="app_my_orders")
     */
    public function myOrders($id){
        $orders=$this->getDoctrine()->getRepository(Orderr::class)->findBy(array('user'=>$id));
        return $this->render('user/my_orders.html.twig',[
            'orderrs'=>$orders,
            'user'=>$id]);
    }


}