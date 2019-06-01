<?php

namespace App\Controller;

use App\Entity\Detail;
use App\Entity\Product;
use App\Entity\Offer;
use App\Entity\Category;
use App\Form\NewofferType;
use App\Form\ProductType;
use App\Form\ProductEditType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OffersController extends AbstractController
{
    /**
     * @Route("/ofertas", name="offers")
     */
    public function index()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        $ofertas = $this->getDoctrine()->getRepository(Offer::class)->findAll();
        return $this->render('offers/index.html.twig', [
            'products'=>$products,
            'ofertas'=>$ofertas]);
    }

    /**
     * Función para listar los productos que sean frutas
     * @Route("/ofertas_old", name="app_fruits")
     */
    public function listfruitoffers(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('offers/productsoffer.html.twig', [
            'products'=>$products]);

    }

    /**
     * Función para añadir producto (que sea fruta)
     * @Route("/ofertas/newoffer", name="new_offer")
     */

    public function newOffer(Request $request){
        return $this->addOffer($request, 'offers/new_offer.html.twig', 'offers');
    }
    private function addOffer(Request $request, string $template, string $route)
    {
        //crear un nuevo objeto producto
        $offer = new Offer();

        //creamos el formulario
        $form = $this->createForm(NewofferType::class, $offer);
        $form->handleRequest($request);

        $error = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            //capturo los datos
            $offer = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();
            $this->addFlash('success', 'Oferta creada');
            return $this->redirectToRoute($route);
        }
        return $this->render($template, [
            'error' => $error,
            'form' => $form->createView()
        ]);

    }

    /**
     * Función para editar productos
     * @param int $id
     * @param Request $request
     * @param string $template
     * @param string $route
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    private function deleteOffer(Request $request, int $id, string $route){
      //  $em = $this->getDoctrine()->getManager();
       // $purchase = $em->getRepository(Offer::class)->find(231);
        //buscamos por el id del producto que hemos seleccionado para eliminar
       // $detail = new Product($id);
       // $offer=$em->getDoctrine()->getRepository(Offer::class)->findBy(array('id'=>$id));
       // $oferdelete=$offer[0];
       // $offer->setOffer('null')
       // $detail->setOffer('null');
       // $detail->setUnitprice('null');
       // $entityManager=$this->getDoctrine()->getManager();
       // $offer->
       // $entityManager->remove($oferdelete);
       // $entityManager->flush();

       // $this->addFlash('success', 'Producto eliminado correctmanete');
        //una vez eliminado,volvemos a la página que indicamos por parámetros, para comprobar que se ha borrado correctamente
     //   return $this->redirectToRoute($route);
    }




}
