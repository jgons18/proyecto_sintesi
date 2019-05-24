<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 10/05/19
 * Time: 18:48
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\EditUserProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{

    /**
     * @Route("/perfil", name="profile_user")
     */
    public function index(){
      //  $user = $this->getUser();
        return $this->render('user/perfil.html.twig');
    }


    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        //marca el usuario activo o inactivo
        //$user->setIsActive(true);
        $form=$this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
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

}