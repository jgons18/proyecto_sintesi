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
     * Función para ver un producto seleccionado - cestas
     * @Route("ofertas/view_product/{id}", name="view_ofert_pro")
     */
    public function viewProduct_Box($id){

        return $this->viewProduct($id, 'offers/view_product.html.twig');
    }
    /**
     * Función para ver un producto en concreto
     * @param $id
     * @param string $template
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function viewProduct($id, string $template){

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render($template, [
            'product' => $product

        ]);
    }


}
