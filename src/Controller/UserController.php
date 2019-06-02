<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 10/05/19
 * Time: 18:48
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\DeleteUserType;
use App\Form\UserType;
use App\Form\EditUserProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\SwiftmailerBundle;

/**
 * Class UserController
 * @package App\Controller
 *
 */
class UserController extends AbstractController
{


    /**
     * @Route("/perfil", name="profile_user")
     */
    public function index(Request $request){
        $user = $this->getUser();
        // $user = $security->getUser();
        $form=$this->createForm(DeleteUserType::class);
        $form->handleRequest($request);
        $error=$form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('app_homepage');

        }
        return $this->render('user/perfil.html.twig',[
            'error'=>$error,
            //'form' es el nombre para construir el formulario en la plantilla
            'form3'=>$form->createView()
        ]);
       // return $this->render('user/perfil.html.twig');
    }


    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $session = $request->getSession();
        $user->setRoles(['ROLE_USER']);
        //marca el usuario activo o inactivo
        //$user->setIsActive(true);
        $form=$this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //extraigo el string que va antes de @gmail.com(por ej.) y lo pongo como nombre de usuario(gestión interna)
                //if($posibilite="@gmail.com" || $posibilite="@yahoo.com" || $posibilite="@hotmail.com"){
            $emailfraccionado = explode("@",$user->getEmail());
            //var_dump($emailfraccionado[0]);
            //die;
            $user->setUsername($emailfraccionado[0]);
                //}

            //encriptamos el password y lo guardamos como campo
            $password=$passwordEncoder->encodePassword($user,$user->getPlainPassword());
            $user->setPassword($password);//si modifica el campo $user, el que irá a la bd
            //para manejo de las entidades
            $entityManager=$this->getDoctrine()->getManager();
            //entidad-orm-bd
            //persistimso la información del formulario
            $entityManager->persist($user);
            $entityManager->flush();
           // $this->test_mail($user);
            $this->addFlash(
                'success','User created'
            );
            return $this->redirectToRoute('app_homepage');

        }
        //renderizar formulario
        return $this->render('user/registro.html.twig',[
            'error'=>$error,
            //'form' es el nombre para construir el formulario en la plantilla
            'form'=>$form->createView()
        ]);

    }

    /**
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @Route("/login",name="app_login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils){

        $error=$authUtils->getLastAuthenticationError();//guardaremos el último errore de la autentificación
        //last username
        $lastUsername=$authUtils->getLastUsername();

        $session = $this->get('session');
        $session->set('filter', array(
            'accounts' => 'value',
        ));

        return $this->render('user/login.html.twig',[
            'error'=>$error,
            'last_username'=>$lastUsername
        ]);
    }
    /**
     * @Route("/logout",name="app_logout")
     */
    public function logout(){
        $this->redirectToRoute('/');
    }

    /**
     * Perfil de user en proceso
     * @Route("/perfil", name="view_profoile")
     */

    public function user_profile(){
       // $user = $this->getDoctrine()->getRepository(User::class)->find(2);
        //return $this->render('user/perfil.html.twig');

        return $this->render('user/perfil.html.twig');

    }

    /**
     * @Route("/edit_prof", name="app_prof")
     */

   // public function edit_user_prof(Request $request, Security $security) : Response{
    public function edit_user_prof(Request $request){
        $user = $this->getUser();
       // $user = $security->getUser();
        $form=$this->createForm(EditUserProfileType::class,$user);
        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            $user=$form->getData();
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //$this->test_mail($user);
            $this->addFlash(
                'success','Datos modificados correctamente'
            );
          return $this->redirectToRoute('view_profoile');

        }
        //renderizar formulario
        return $this->render('user/edit_prof.html.twig',[
            'error'=>$error,
            //'form' es el nombre para construir el formulario en la plantilla
            'form'=>$form->createView()
        ]);

    }

    /**
     * Perfil de user en proceso
     * @Route("/perfil", name="view_profoile")
     */

    public function edit_user_profile(Request $request){
       // $user = $this->getDoctrine()->getRepository(User::class)->find(2);
        return $this->render('user/perfil.html.twig');

    }

    /**
     * Esta funcion envia mails
     * @Route("/perfi_test", name="view_prfoile")
     */

    public function test_mail($user, \Swift_Mailer $mailer)
    {
        $em=$this->getDoctrine()->getManager();
        $us = $em->getRepository('JperdiorShopBundle:Purchase')->find($user);
        $message = (new \Swift_Message('Activacion de cuenta | Fruitable'))
            ->setFrom('noreplyfruitable@gmail.com')
            ->setTo($us->getEmail())
            ->setBody(
                $this->renderView('mail/confirmation.html.twig'), 'text/html');

        $mailer->send($message);

        return $this->render('mail/confirmation.html.twig');
    }

    public function deleteProduct_Vegetable($id, Request $request)
    {
        return $this->delete_user($request, $id, 'app_vegetables');
    }

    private function delete_user(Request $request){
        $user = $this->getUser();
        // $user = $security->getUser();
        $form=$this->createForm(EditUserProfileType::class);
        $form->handleRequest($request);
        $error=$form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('app_homepage');

        }
        //renderizar formulario
        return $this->render('user/edit_prof.html.twig',[
            'error'=>$error,
            //'form' es el nombre para construir el formulario en la plantilla
            'form3'=>$form->createView()
        ]);

    }

    /**
     * Función para eliminar producto - cestas
     * @Route("/perfil/delete/{id}", name="delete_box")
     */
    public function deleteProduct_Box($id, Request $request)
    {
        return $this->deleteProduct($request, $id, 'app_homepage');
    }

    /**
     * Función para eliminar producto
     * @param Request $request
     * @param int $id
     * @param string $route
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    private function deleteUser2(Request $request, int $id, string $route){
        $user = $this->getUser();
        $producttodelete=$user[0];
        $entityManager=$this->getDoctrine()->getManager();
        //comando en cuestión que borrará el producto
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Usuario eliminado correctmanete');
        //una vez eliminado,volvemos a la página que indicamos por parámetros, para comprobar que se ha borrado correctamente
        return $this->redirectToRoute($route);
    }

}