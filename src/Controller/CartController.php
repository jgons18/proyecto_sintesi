<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cart;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\ProductEditType;
use App\Form\SearchType;
use App\Form\ProductBoxType;
use App\Form\ProductBoxEditType;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function showcart()
    {
        $user = $this->getUser();
        $cart = $user->getCart();
        $cartproducts = $cart->getId();
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'user' => $user,
            'cartprod' => $cartproducts
        ]);
    }

    /**
     * Función  para añadir productos al carrito
     * @Route("/pedido/add/{id}", name="add_product_to_basket")
     */
    public function addTocart(Request $request,$id)
    {
        $user=$this->getUser();
        $cart = new Cart();
        $cart->setUser($user);

        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(array('id' => $id));
        $productcart = $product[0];


        $form = $this->createForm(OrderrType::class, $productcart);

        $form->handleRequest($request);
        $error = $form->getErrors();

        $form2=$this->createForm(Orderr2Type::class);
        $form2->handleRequest($request);

        $cart->setProduct($productcart);

        return $this->render('order/inprogress.html.twig', array(
            /*'res' => $res*/
            'orderrs'=>$product,
            'form'=>$form->createView(),
            'form2'=>$form2->createView()
        ));

    }

    /**
     * Función para generar un nombre único a las imágenes
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }



}
