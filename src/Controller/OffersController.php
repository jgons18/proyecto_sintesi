<?php

namespace App\Controller;

use App\Entity\Detail;
use App\Entity\Product;
use App\Entity\Offer;
use App\Entity\Category;
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
    private function addProduct(Request $request, string $template, string $route)
    {
        //crear un nuevo objeto producto
        $product = new Product();

        //como este método lo utilizamos para añadir productos que son VERDURAS
        //le pondremos por defecto el campo isfruta en false
        $product->setIsfruit($isfruit);

        //creamos el formulario
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        $error = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            //capturo los datos
            $product = $form->getData();
            //para obtener la imagen
            $file = $form->get('image')->getData();
            if ($file) {
                //genero una serie de letras y números únicos + su extensión para la imagen
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                // moves the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('pictures_directory'),
                        $fileName
                    );
                    //actualizar propiedad de image
                    $product->setImage($fileName);
                } catch (FileException $e) {
                    $this->addFlash('warning', 'Error uploading image');
                }
                $product->setImage($fileName);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Producto creado correctamente');
            return $this->redirectToRoute($route);
        }
        //renderizar formulario
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
