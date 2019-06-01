<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 14/05/19
 * Time: 17:07
 */

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\ProductEditType;
use App\Form\SearchType;
use App\Form\ProductBoxType;
use App\Form\ProductBoxEditType;
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
     * Función para listar los productos que sean cajas
     * @Route("/cestas", name="app_boxes")
     */
    public function listboxes(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('boxes/index.html.twig', [
            'products'=>$products]);

    }

    /**
     * Función para añadir producto (que sea fruta)
     * @Route("/frutas/newproduct", name="new_product_fruit")
     */
    public function addProduct_Fruit(Request $request){
        return $this->addProduct($request, true,'fruit/new_product.html.twig', 'app_fruits');
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
     * Función para añadir un producto de tipo cajas de frutas
     * @Route("/cestas/new_product_fruit", name="new_product_box_fruit")
     */
    public function addProduct_Boxes_fruit(Request $request){
        return $this->addProduct_Box($request, true, 'boxes/new_product.html.twig');
    }
    /**
     * Función para añadir un producto de tipo cajas de verduras
     * @Route("/cestas/new_product_vegetable", name="new_product_box_vegetable")
     */
    public function addProduct_Boxes_vegetable(Request $request){
        return $this->addProduct_Box($request, false, 'boxes/new_product.html.twig');
    }
    /**
     * Función privada para añadir productos que sean cestas
     * @param Request $request
     * @param bool $isfruit
     * @param string $template
     * @param string $route
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function addProduct_Box(Request $request, bool $isfruit, string $template){
        //crear un nuevo objeto producto
        $product = new Product();

        //como este método lo utilizamos para añadir productos que son VERDURAS
        //le pondremos por defecto el campo isfruta en false
        $product->setIsfruit($isfruit);

        //creamos el formulario
        $form=$this->createForm(ProductBoxType::class,$product);
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
            return $this->redirectToRoute('app_boxes');
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
            //capturo los datos
            $prducttoedit=$form->getData();
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
                    $prducttoedit->setImage($fileName);
                }catch (FileException $e){
                    $this->addFlash('warning','Error uploading image');
                }
                $prducttoedit->setImage($fileName);
            }

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
     * Función para editar productos - cestas
     * @Route("cestas/edit_product/{id}", name="edit_box")
     */
    public function editProduct_Box($id,Request $request){
        $product=$this->getDoctrine()->getRepository(Product::class)->findBy(array('id'=>$id));
        $prducttoedit=$product[0];

        $form=$this->createForm(ProductBoxEditType::class,$prducttoedit);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Producto modificado correctamente');
            return $this->redirectToRoute('app_boxes');
        }

        return $this->render('boxes/edit_product.html.twig',[
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
     * Función para eliminar producto - cestas
     * @Route("/cestas/delete/{id}", name="delete_box")
     */
    public function deleteProduct_Box($id, Request $request)
    {
        return $this->deleteProduct($request, $id, 'app_boxes');
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
     * Función para ver un producto seleccionado - cestas
     * @Route("cestas/view_product/{id}", name="view_box")
     */
    public function viewProduct_Box($id){

        return $this->viewProduct($id, 'boxes/view_product.html.twig');
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
     * Función para buscar productos
     * @Route("/busqueda", name="app_search_product")
     */
    public function searchProduct(Request $request){
        //$request = $this->getRequest();
        $data = $request->request->get("search");

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Product p
            WHERE p.nameproduct LIKE :data')
            ->setParameter('data','%'.$data.'%');

        $res = $query->getResult();
        /*var_dump($res);
        die;*/
        return $this->render('search/results.html.twig', array(
            'res' => $res,
            'data' =>$data));
    }

    /**
     * Función para filtrar productos del precio más bajo al más alto(FRUTAS)
     * @Route("/frutas/filters/price-low", name="app_price_low_to_high_f")
     */
    public function filterProduct_Fruit_price_Low(){
        return $this->filterProduct_price('fruit/filters/price.html.twig','ASC');
    }

    /**
     * Función para filtrar productos del precio más bajo al más alto(VERDURAS)
     * @Route("/verduras/filters/price-low", name="app_price_low_to_high_v")
     */
    public function filterProduct_Vegetable_price_Low(){
        return $this->filterProduct_price('vegetable/filters/price.html.twig','ASC');
    }
    /**
     * Función para filtrar productos del precio más bajo al más alto(CESTAS)
     * @Route("/cestas/filters/price-low", name="app_price_low_to_high_b")
     */
    public function filterProduct_Box_price_Low(){
        return $this->filterProduct_price('boxes/filters/price.html.twig','ASC');
    }
    /**
     * Función para filtrar productos del precio más alto al más bajo(FRUTAS)
     * @Route("/frutas/filters/price-high", name="app_price_high_to_low_f")
     */
    public function filterProduct_Fruit_price_High(){

        return $this->filterProduct_price('fruit/filters/price.html.twig','DESC');
    }

    /**
     * Función para filtrar productos del precio más alto al más bajo(VERDURAR)
     * @Route("/verduras/filters/price-high", name="app_price_high_to_low_v")
     */
    public function filterProduct_Vegatable_price_High(){

        return $this->filterProduct_price('vegetable/filters/price.html.twig','DESC');
    }
    /**
     * Función para filtrar productos del precio más alto al más bajo(CESTAS)
     * @Route("/cestas/filters/price-high", name="app_price_high_to_low_b")
     */
    public function filterProduct_Box_price_High(){

        return $this->filterProduct_price('boxes/filters/price.html.twig','DESC');
    }

    /**
     * Función privada para filtrar los productos según el precio, de mayor a menor
     * @param string $template
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function filterProduct_price(string $template, string  $orden){
        $product = new Product();
        $product->getUnitprice();

        /*$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Product p 
            ORDER BY p.unitprice DESC');
        $res = $query->getResult();*/
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Product p 
            ORDER BY p.unitprice '.$orden);
        $res = $query->getResult();

        return $this->render($template, array(
            'res' => $res,
            'products'=>$product));
    }

    /**
     * Función filtros por categoria de platanos
     * @Route("frutas/filters/for-category-banana", name="app_category_filter_banana")
     */
    public function filterProduct_category_Banana(){

        return $this->filterProduct_category(1,'fruit/filters/category_banana.html.twig');
        //return $this->filterProduct_category(1,'fruit/index.html.twig');
    }
    /**
     * Función filtros por categoria de otras verduras
     * @Route("verduras/filters/for-category-others", name="app_category_filter_other_vegetables")
     */
    public function filterProduct_category_Others_Vegetables(){

        return $this->filterProduct_category(2,'vegetable/filters/category_others.html.twig');

    }
    /**
     * Función filtros por categoria de manzanas
     * @Route("frutas/filters/for-category-apple", name="app_category_filter_apple")
     */
    public function filterProduct_category_Apple(){

        return $this->filterProduct_category(3,'fruit/filters/category_apple.html.twig');

    }

    /**
     * Función privada para filtrar por categorias
     * @param int $numcategory
     * @param string $template
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function filterProduct_category(int $numcategory, string $template){
        $product = new Product();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Product p 
        WHERE p.category = '.$numcategory);
        $res = $query->getResult();

        return $this->render($template, array(
            'res' => $res,
            'products'=>$product));
    }


    /**
     * Función para filtrar productos del precio más bajo al más alto(FRUTA) y con la categoría plátanos
     * @Route("/frutas/filters/category-and-price-low-banana", name="app_price_low_to_high_f_bananas")
     */
    public function filterProduct_Fruit_price_and_Banana(){
        return $this->filterProduct_category_and_price('1','fruit/filters/category_banana.html.twig','ASC');
    }
    /**
     * Función para filtrar productos del precio  más alto al más bajo(FRUTA) y con la categoría plátanos
     * @Route("/frutas/filters/category-and-price-high-banana", name="app_price_high_to_low_f_bananas")
     */
    public function filterProduct_Fruit_price_and_Banana2(){
        return $this->filterProduct_category_and_price('1','fruit/filters/category_banana.html.twig','DESC');
    }
    /**
     * Función para filtrar productos del precio más bajo al más alto(FRUTA) y con la categoría manzanas
     * @Route("/frutas/filters/category-and-price-low-apple", name="app_price_low_to_high_f_apples")
     */
    public function filterProduct_Fruit_price_and_Apple(){
        return $this->filterProduct_category_and_price('3','fruit/filters/category_apple.html.twig','ASC');
    }
    /**
     * Función para filtrar productos del precio  más alto al más bajo(FRUTA) y con la categoría manzanas
     * @Route("/frutas/filters/category-and-price-high-apple", name="app_price_high_to_low_f_apples")
     */
    public function filterProduct_Fruit_price_and_Apple2(){
        return $this->filterProduct_category_and_price('3','fruit/filters/category_apple.html.twig','DESC');
    }
    /**
     * Función para filtrar productos del precio más bajo al más alto(VERDURAS) y con la categoría otras
     * @Route("/verduras/filters/category-and-price-low-others", name="app_price_low_to_high_v_others")
     */
    public function filterProduct_Vegetable_price_and_Others(){
        return $this->filterProduct_category_and_price('2','vegetable/filters/category_others.html.twig','ASC');
    }
    /**
     * Función para filtrar productos del precio más alto al más bajo(VERDURAS) y con la categoría otras
     * @Route("/verduras/filters/category-and-price-high-others", name="app_price_high_to_low_v_others")
     */
    public function filterProduct_Vegetable_price_and_Others2(){
        return $this->filterProduct_category_and_price('2','vegetable/filters/category_others.html.twig','DESC');
    }
    /**
     * Función privada para filtrar por categorias  y por precio(según se indique, de mayor a menor y viceversa)
     * @param string $template
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function filterProduct_category_and_price(int $numcategory, string $template, string $order){
        $product = new Product();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM App\Entity\Product p 
        WHERE p.category = '.$numcategory.' order by p.unitprice '.$order);
        $res = $query->getResult();

        return $this->render($template, array(
            'res' => $res,
            'products'=>$product));
    }








}