<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 20/05/19
 * Time: 16:17
 */

namespace App\Controller;

use App\Entity\Carrier;
use App\Entity\Orderr;
use App\Entity\Detail;
use App\Entity\Product;
use App\Form\CarrierType;
use App\Form\Orderr2Type;
use App\Form\OrderrType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\Session;

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
        //creo la sessión, indicando el estado del pedido, que posteriomente modificaremos
        $session = new Session();
        $session->set('Pedido', 'created');
        $estado = $session->get('Pedido');

        $pedido = new Orderr();

        $detalle = new Detail();

        $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
        $prducttoedit=$product[0];

        $form=$this->createForm(OrderrType::class,$prducttoedit);
        $form->handleRequest($request);
        $error=$form->getErrors();

        $form2=$this->createForm(Orderr2Type::class);
        $form2->handleRequest($request);
        $error=$form2->getErrors();
        $session->set('Pedido', 'in progress');


        if($form2->isSubmitted() && $form2->isValid()){

            $pedido->setPaymentconfirmed(false);
            $pedido->setMainaddress('calle de prueba');
            $pedido->setSecondarydirection('-');
            $pedido->setNameofowner('yo');
            $pedido->setCardnumber('0123456789012345');
            $user = $this->getUser();
            $pedido->setUser($user);

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($pedido);
            $entityManager->flush();

            $idpedido = $pedido->getId();

            if(($pedido->getPaymentconfirmed() == false) && ($session->get('Pedido') == 'in progress')){
                //$prducttoedit=$form->getData();
                $precio = $form->get('unitprice')->getData();
                $cantidad = $form2->get('quantity')->getData();
                $trans = $form2->get('carrier')->getData();
                $metododepago=$form2->get('paymentmethod')->getData();

                $detalle->setProduct($prducttoedit);
                $detalle->setQuantity($cantidad);
                $detalle->setPrice($precio);
                $detalle->setCarrier($trans);
                $detalle->setTotal($precio*$cantidad);
                $detalle->setPaymentmethod($metododepago);
                $detalle->setForder($pedido);


                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($detalle);
                $entityManager->flush();
            }



            $this->addFlash('success', 'Producto modificado correctamente');
            return $this->redirectToRoute('app_homepage');
        }



        return $this->render('order/inprogress.html.twig', array(
            //'res' => $res
            'estado'=>$session,
            'orderrs'=>$product,
            'form'=>$form->createView(),
            'form2'=>$form2->createView()
        ));


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

    /**
     * Función para añadir transportistas
     * @IsGranted("ROLE_ADMIN")
     * @Route("/carriers/add/", name="app_add_carrier")
     */
    public function addCarrier(Request $request){
        $carrier = new Carrier();

        //creamos el formulario
        $form=$this->createForm(CarrierType::class,$carrier);
        $form->handleRequest($request);

        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //capturo los datos
            $carrier=$form->getData();
            //para obtener la imagen
            $file = $form->get('image')->getData();
            if($file){
                //genero una serie de letras y números únicos + su extensión para la imagen
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                // moves the file to the directory where brochures are stored
                try{
                    $file->move(
                        $this->getParameter('pictures_directory'),
                        $fileName
                    );
                    //actualizar propiedad de image
                    $carrier->setImage($fileName);
                }catch (FileException $e){
                    $this->addFlash('warning','Error uploading image');
                }
                $carrier->setImage($fileName);
            }


            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($carrier);
            $entityManager->flush();
            $this->addFlash('success','Transportistas creado correctamente');
            return $this->redirectToRoute('app_homepage');
        }
        //renderizar formulario
        return $this->render('order/add_carrier.html.twig', [
            'error'=>$error,
            'form'=>$form->createView()
        ]);

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