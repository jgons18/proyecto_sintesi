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
use App\Entity\Paymentmethod;
use App\Entity\Product;
use App\Form\CarrierType;
use App\Form\Orderr2Type;
use App\Form\OrderrType;
use App\Form\OrderrUnitsType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class OrderrController extends AbstractController
{
//$session = new Session();


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
        /*$session = new Session();
        $session->set('Pedido', 'inactive');*/
        $estado = $request->getSession('Pedido');
        //$session->get('Pedido');

        //creación de la cookie para saber si el usuario las ha aceptado
        $response = new Response();
        try{
            //obtenemos el id del producto a añadir al pedido
            $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
            $prducttoedit=$product[0];

            //creamos el primer formulario en que recogemos todos los detalles del producto que posteriormente mostraremos en el pedido
            $form=$this->createForm(OrderrType::class,$prducttoedit);
            $form->handleRequest($request);
            $error=$form->getErrors();

            //crearemos otro formulario en que determinados las unidades de cada producto,transportista y método de pago
            $form2=$this->createForm(Orderr2Type::class);
            $form2->handleRequest($request);
            $error=$form2->getErrors();
            //falta poner un try catch por si el usuario no esta logueado

            //si el pedido está en estado inactivo, es decir, que no se ha creado aún, crearemos un pedido y cambiaremos el estado
            //puesto que si está en proceso utilizaremos ese pedido para ir añadiendo productos

            $pedido = new Orderr();
            $user = $this->getUser();
            $userid=$user->getId();

            //$estado->set('Pedido','order in progress');

            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT p FROM App\Entity\Orderr p
                WHERE p.user = '.$userid.' AND p.dateeorderr <= :today order by p.id DESC')
                ->setParameter('today', new \DateTime())
                ->setMaxResults(1);
            $res = $query->getResult();

            //si en la consulta anterior encuentro algún registro, solo añadiré del detalle a ese registro encontrado, de lo contrario crearé un nuevo pedido y añadiré el detalle
            if(count($res) == 1){
                //creamos un detalle de pedido
                $detalle = new Detail();

                //if($form2->isSubmitted()){

                $trans = $form2->get('carrier')->getData();
                $metododepago=$form2->get('paymentmethod')->getData();

                $pedido->setPaymentconfirmed(false);
                $pedido->setMainaddress('-');
                $pedido->setSecondarydirection('-');
                $pedido->setNameofowner('-');
                $pedido->setCardnumber('0123456789012345');
                $pedido->setCarrier($trans);
                $pedido->setPaymentmethod($metododepago);
                $user = $this->getUser();
                $pedido->setUser($user);

                /*$entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($pedido);
                $entityManager->flush();*/

                $idpedido = $pedido->getId();

                if($pedido->getPaymentconfirmed() == false){
                    //$prducttoedit=$form->getData();
                    $precio = $form->get('unitprice')->getData();
                    //$cantidad = $form3->get('quantity')->getData();
                    //$cantidad = $request->request->get("unidades");
                    $cantidad=1;
                    //$cantidad=$request->request->get('unidades');

                    $detalle->setProduct($prducttoedit);
                    $detalle->setQuantity($cantidad);
                    $detalle->setPrice($precio);
                    $detalle->setTotal($precio*$cantidad);
                    $detalle->setForder($res[0]);


                    $entityManager=$this->getDoctrine()->getManager();
                    $entityManager->persist($detalle);
                    $entityManager->flush();
                }

                $this->addFlash('success', 'Producto añadido correctamente');
                return $this->redirectToRoute('app_homepage');

            }else{
                //creamos un detalle de pedido
                $detalle = new Detail();

                $pedido->setPaymentconfirmed(false);
                $pedido->setMainaddress('-');
                $pedido->setSecondarydirection('-');
                $pedido->setNameofowner('-');
                $pedido->setCardnumber('0123456789012345');

                $user = $this->getUser();
                $pedido->setUser($user);

                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($pedido);
                $entityManager->flush();

                $idpedido = $pedido->getId();

                if($pedido->getPaymentconfirmed() == false){
                    //$prducttoedit=$form->getData();
                    $precio = $form->get('unitprice')->getData();
                    //$cantidad = $form3->get('quantity')->getData();
                    //$cantidad = $request->request->get("unidades");
                    $cantidad=1;
                    //$cantidad=$request->request->get('unidades');

                    $detalle->setProduct($prducttoedit);
                    $detalle->setQuantity($cantidad);
                    $detalle->setPrice($precio);
                    $detalle->setTotal($precio*$cantidad);
                    $detalle->setForder($pedido);


                    $entityManager=$this->getDoctrine()->getManager();
                    $entityManager->persist($detalle);
                    $entityManager->flush();
                }

                $this->addFlash('success', 'Producto añadido correctamente');
                return $this->redirectToRoute('app_homepage');
            }
        }catch (\Error $exception){
            echo 'NO TE HAS LOGUEADO: '.$exception->getMessage();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('order/inprogress.html.twig', array(
            'res' => $res,
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
        $detail = new Detail();
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

    /**
     * Función para ver el pedido
     * @Route("/pedido/view", name="app_view_order")
     */
    public function viewOrder(Request $request){
        $user = $this->getUser();
        $userid=$user->getId();

        /*$orderr = $this->getDoctrine()->getRepository(Orderr::class)->findAll();
        $detail = $this->getDoctrine()->getRepository(Detail::class)->findAll();*/


        //crearemos otro formulario en que determinados las unidades de cada producto,transportista y método de pago
        $form2=$this->createForm(Orderr2Type::class);
        $form2->handleRequest($request);
        $error=$form2->getErrors();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Orderr p
                WHERE p.user = '.$userid.' AND p.dateeorderr <= :today order by p.id DESC')
            ->setParameter('today', new \DateTime())
            ->setMaxResults(1);
        $res = $query->getResult();

        $res[0]->getId();
        $detail = $this->getDoctrine()->getRepository(Detail::class)->findBy(array('forder'=>$res));


        $detalletotales=count($detail);
        for($i=1;$i<=$detalletotales;$i++){
            $detailprice=$detail[0]->getPrice();
            $detailquantity=$detail[0]->getQuantity();
            $totalfactura=$res[0]->setTotalfactura($detailprice*$detailquantity);
        }
        if($form2->isSubmitted() && $form2->isValid()){
            $useraddress=$user->getAddress();
            $secondaddress=$form2->get('secondarydirection')->getData();
            $trans = $form2->get('carrier')->getData();
            $metododepago=$form2->get('paymentmethod')->getData();
            $nameowner= $form2->get('nameofowner')->getData();
            $cardnumber= $form2->get('cardnumber')->getData();

            $res[0]->setPaymentconfirmed(true);
            $res[0]->setMainaddress($useraddress);
            $res[0]->setSecondarydirection($secondaddress);
            $res[0]->setNameofowner($nameowner);
            $res[0]->setCardnumber($cardnumber);
            $res[0]->setCarrier($trans);
            $res[0]->setPaymentmethod($metododepago);

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($res[0]);
            $entityManager->flush();
            $this->addFlash('success','Pedido pagado correctamente correctamente');
            return $this->redirectToRoute('app_buy_confirmed');
            //return $this->render('order/finished.html.twig');

        }

        return $this->render('order/inprogress.html.twig', [
            'res'=>$res,
            'details'=>$detail,
            'form2'=>$form2->createView()
        ]);
    }

    /**
     * Función para indicar que se ha pagado el pedido
     * @Route("/pedido/finished", name="app_buy_confirmed")
     */
    public function orderConfirmed(){
        return $this->render('order/finished.html.twig');
    }

}