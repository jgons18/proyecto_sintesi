<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 14/05/19
 * Time: 17:07
 */

namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductType;
use App\Form\ProductEditType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

    /**
     * Función para listar los productos que sean frutas
     * @Route("/frutas", name="app_fruits")
     */
    public function listfruit(){
            $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
            return $this->render('fruit/index.html.twig', [
                'products'=>$products]);

    }
    /**
     * Función para listar los productos que sean verduras
     * @Route("/verduras", name="app_vegetables")
     */
    public function listvegetable(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('vegetable/index.html.twig', [
            'products'=>$products]);

    }

    /**
     * Función para añadir un nuevo producto (que sea fruta)
     * @Route("/frutas/newproduct", name="new_product_fruit")
     */
    public function addProduct_Fruit(Request $request){
        //crear un nuevo objeto producto
        $product = new Product();

        //como este método lo utilizamos para añadir productos que son FRUTAS
        //le pondremos por defecto el campo isfruta en true
        $isfruit=true;
        $product->setIsfruit($isfruit);

        //creamos el formulario
        $form=$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //capturo los datos
            $product=$form->getData();

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success','Producto creado correctamente');
            return $this->redirectToRoute('app_fruits');
        }
        //renderizar formulario
        return $this->render('fruit/new_product.html.twig', [
            'error'=>$error,
            'form'=>$form->createView()
        ]);
    }
    /**
     * Función para añadir un nuevo producto (que sea verdura)
     * @Route("verduras/new_product", name="new_product_vegetable")
     */
    public function addProduct_Vegetable(Request $request){
        //crear un nuevo objeto producto
        $product = new Product();

        //como este método lo utilizamos para añadir productos que son VERDURAS
        //le pondremos por defecto el campo isfruta en false
        $isfruit=false;
        $product->setIsfruit($isfruit);

        //creamos el formulario
        $form=$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //capturo los datos
            $product=$form->getData();

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success','Producto creado correctamente');
            return $this->redirectToRoute('app_vegetables');
        }
        //renderizar formulario
        return $this->render('vegetable/new_product.html.twig', [
            'error'=>$error,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Función para editar productos - frutas
     * @Route("frutas/edit_product/{id}", name="edit_product_fruit")
     */
    public function editProduct_Fruit($id,Request $request){
        $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
        $prducttoedit=$product[0];

        $form=$this->createForm(ProductEditType::class,$prducttoedit);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Producto modificado correctamente');
            return $this->redirectToRoute('app_fruits');
        }

        return $this->render('fruit/edit_product.html.twig',[
            'error'=>$error,
            'products'=>$product,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Función para editar productos - verduras
     * @Route("verdura/edit_product/{id}", name="edit_product_vegetable")
     */
    public function editProduct_Vegetable($id,Request $request){
        $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
        $prducttoedit=$product[0];

        $form=$this->createForm(ProductEditType::class,$prducttoedit);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Producto modificado correctamente');
            return $this->redirectToRoute('app_vegetables');
        }

        return $this->render('vegetable/edit_product.html.twig',[
            'error'=>$error,
            'products'=>$product,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Función para eliminar producto - fruta
     * @Route("/fruta/delete/{id}", name="delete_product_fruit")
     */
    public function deleteProduct_Fruit($id, Request $request)
    {
        //buscamos por el id de la fruta que hemos seleccionado para eliminar
        $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
        $producttodelete=$product[0];

        $entityManager=$this->getDoctrine()->getManager();
        //comando en cuestión que borrará el producto
        $entityManager->remove($producttodelete);
        $entityManager->flush();

        $this->addFlash('success', 'Producto eliminado correctmanete');
        //una vez eliminado,volvemos a la página del resto de las frutas, para comprobar que se ha borrado correctamente
        return $this->redirectToRoute('app_fruits');

    }
    /**
     * Función para eliminar producto - verdura
     * @Route("/verdura/delete/{id}", name="delete_product_vegetable")
     */
    public function deleteProduct_Vegetable($id, Request $request)
    {
        //buscamos por el id de la verdura que hemos seleccionado para eliminar
        $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
        $producttodelete=$product[0];

        $entityManager=$this->getDoctrine()->getManager();
        //comando en cuestión que borrará el producto
        $entityManager->remove($producttodelete);
        $entityManager->flush();

        $this->addFlash('success', 'Producto eliminado correctmanete');
        //una vez eliminado,volvemos a la página del resto de las frutas, para comprobar que se ha borrado correctamente
        return $this->redirectToRoute('app_vegetable');

    }
    /**
     * Función para ver un producto seleccionado - fruta
     * @Route("fruta/view_product/{id}", name="view_product_fruit")
     */
    public function viewProduct_Fruit($id){
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render('fruit/view_product.html.twig', [
            'product' => $product

        ]);
    }
    /**
     * Función para ver un producto seleccionado - verdura
     * @Route("verdura/view_product/{id}", name="view_product_vegetable")
     */
    public function viewProduct_Vegetable($id){
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render('vegetable/view_product.html.twig', [
            'product' => $product

        ]);
    }

}