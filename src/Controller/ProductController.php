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
use App\Form\SearchType;
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
     * Función para añadir producto (que sea fruta)
     * @Route("/frutas/newproduct", name="new_product_fruit")
     */
    public function addProduct_Fruit(Request $request){
        return $this->addProduct($request, true, 'fruit/new_product.html.twig', 'app_fruits');
    }
    /**
     * Función para añadir producto (que sea verdura)
     * @Route("verduras/new_product", name="new_product_vegetable")
     */
    public function addProduct_Vegetable(Request $request){
        return $this->addProduct($request, false, 'vegetable/new_product.html.twig', 'app_vegetables');
    }

    /**
     * Función privada para añadir productos
     * @param Request $request
     * @param bool $isfruit
     * @param string $template
     * @param string $route
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function addProduct(Request $request, bool $isfruit, string $template, string $route){
        //crear un nuevo objeto producto
        $product = new Product();

        //como este método lo utilizamos para añadir productos que son VERDURAS
        //le pondremos por defecto el campo isfruta en false
        $product->setIsfruit($isfruit);

        //creamos el formulario
        $form=$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //capturo los datos
            $product=$form->getData();
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
                    $product->setImage($fileName);
                }catch (FileException $e){
                    $this->addFlash('warning','Error uploading image');
                }
                $product->setImage($fileName);
            }


            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success','Producto creado correctamente');
            return $this->redirectToRoute($route);
        }
        //renderizar formulario
        return $this->render($template, [
            'error'=>$error,
            'form'=>$form->createView()
        ]);
    }

    /**
     * Función para editar productos - frutas
     * @Route("frutas/edit_product/{id}", name="edit_product_fruit")
     */
    public function editProduct_Fruit($id,Request $request){

        return $this->editProduct($id, $request, 'fruit/edit_product.html.twig', 'app_fruits');

    }

    /**
     * Función para editar productos - verduras
     * @Route("verdura/edit_product/{id}", name="edit_product_vegetable")
     */
    public function editProduct_Vegetable($id,Request $request){

        return $this->editProduct($id, $request, 'vegetable/edit_product.html.twig', 'app_vegetables');

    }

    /**
     * Función para editar productos
     * @param int $id
     * @param Request $request
     * @param string $template
     * @param string $route
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function editProduct(int $id, Request $request, string $template, string $route){
        $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
        $prducttoedit=$product[0];

        $form=$this->createForm(ProductEditType::class,$prducttoedit);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Producto modificado correctamente');
            return $this->redirectToRoute($route);
        }

        return $this->render($template,[
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
        return $this->deleteProduct($request, $id, 'app_fruits');
    }

    /**
     * Función para eliminar producto - verdura
     * @Route("/verdura/delete/{id}", name="delete_product_vegetable")
     */
    public function deleteProduct_Vegetable($id, Request $request)
    {
        return $this->deleteProduct($request, $id, 'app_vegetables');
    }

    /**
     * Función para eliminar producto
     * @param Request $request
     * @param int $id
     * @param string $route
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function deleteProduct(Request $request, int $id, string $route){
        //buscamos por el id del producto que hemos seleccionado para eliminar
        $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
        $producttodelete=$product[0];

        $entityManager=$this->getDoctrine()->getManager();
        //comando en cuestión que borrará el producto
        $entityManager->remove($producttodelete);
        $entityManager->flush();

        $this->addFlash('success', 'Producto eliminado correctmanete');
        //una vez eliminado,volvemos a la página que indicamos por parámetros, para comprobar que se ha borrado correctamente
        return $this->redirectToRoute($route);
    }

    /**
     * Función para ver un producto seleccionado - fruta
     * @Route("fruta/view_product/{id}", name="view_product_fruit")
     */
    public function viewProduct_Fruit($id){

        return $this->viewProduct($id, 'fruit/view_product.html.twig');
    }
    /**
     * Función para ver un producto seleccionado - verdura
     * @Route("verdura/view_product/{id}", name="view_product_vegetable")
     */
    public function viewProduct_Vegetable($id){

        return $this->viewProduct($id, 'vegetable/view_product.html.twig');
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
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/buscar", name="app_search")
     */
    public function searchForm(Request $request) {
        $search_file = new Product();
        $form = $this->createForm(SearchType::class, $search_file, [
            'action' => '/buscar'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search_file = $form->getData();
            return $this->redirectToRoute('search', [
                'keywords' => $search_file->getNameproduct()
            ]);
        }
        return $this->render('search/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    

    /**
     * función buscar
     * @Route("/busqueda", name="app_search_product")
     */

    public function searchProduct(Request $request){
        //$request = $this->getRequest();
        $data = $request->request->get("search");


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Product p
            WHERE p.nameproduct LIKE :data')
            ->setParameter('data',$data);


        $res = $query->getResult();
        /*var_dump($res);
        die;*/

        return $this->render('search/results.html.twig', array(
            'res' => $res));
    }



}