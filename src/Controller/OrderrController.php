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
use App\Controller\HomeController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Exception\ConflictingHeadersException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;

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

    public function addProduct(Request $request,$id)
    {
        //$session->start();
        $detail = new Detail();
       // $session = new Session();

        $user=$this->getUser();
        //obtengo la hora en la que se ha empezado el pedido
       //$orderCreate=$orderr->getDateeorderr();
       // Debug::enable();
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(array('id' => $id));
        $prducttoaddtobasket = $product[0];
        $form = $this->createForm(OrderrType::class, $prducttoaddtobasket);
        $form->handleRequest($request);
        $error = $form->getErrors();


        $form2=$this->createForm(Orderr2Type::class, $detail);
        $form2->handleRequest($request);
       //$detail->setProduct($prducttoaddtobasket);

        if ($form2->isSubmitted() && $form2->isValid()) {
          //  $session->set('Detail', 'prueba');
            // $detail->get('Detail',$form2);
          //  $cart = $session->get('Detail');
            $contenido = $request->getContent();
            var_dump($contenido );
            die;
       }
        return $this->render('order/inprogress.html.twig', array(
            /*'res' => $res*/
            'orderrs'=>$product,
            'form'=>$form->createView(),
            'form2'=>$form2->createView()
        ));
        /*return $this->render('fruit/index.html.twig',[
            'error'=>$error,
            'products'=>$product,
            'form'=>$form->createView()
        ]);*/
    }





    /**
     * Función  para añadir productos al carrito
     * @Route("/pedido_old/add/{id}", name="add_product_to_basket_old")
     */
    public function addProductOrder_old(Request $request,$id)
    {
        $session = $request->getSession();
        $orderr = new Orderr();
        $user=$this->getUser();

       // Debug::enable();
        $detail = new Detail();
        $product = $this->getDoctrine()->getRepository(Product::class)->findBy(array('id' => $id));
        $prducttoaddtobasket = $product[0];


        $form = $this->createForm(OrderrType::class, $prducttoaddtobasket);

        $form->handleRequest($request);
        $error = $form->getErrors();
        //$contenido = $request->getContent();

        $form2=$this->createForm(Orderr2Type::class, $detail);
        $form2->handleRequest($request);


        if ($form2->isSubmitted() && $form2->isValid()) {
            $session = $this->session;
            $session = $this->getSession();
            //$session->clear();
            $ideitoSE=$session->get('id');
            $ideitoRE=$request->get('id');
           $canti23=$session->get('quantity');
           // $remember=$request->get('remember');
           // $session = $request->getSession();

         //  $pi = $request->query->get('quantity');
         $contenido = $request->getContent();
         $session123 = $this->getContent();

        //  $canti= $request->get("quantity");
            $con2 = $request->getPathInfo();
          //  return $this->storage->start();
            var_dump($canti23);
            die;
            return $this->redirectToRoute('app_homepage');

        }

       // $detail->setProduct($prducttoaddtobasket);

        /*$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'UPDATE p FROM App\Entity\Product p
            SET p.stock = p.stock - 1,
            p.reservedstocks = p.reservedstocks - 1 WHERE p.id ='.$detail);

        $res = $query->getResult();*/
        //$total=$detail

        return $this->render('order/inprogress.html.twig', array(
            /*'res' => $res*/
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



}