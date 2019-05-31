<?php


namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LegalController extends AbstractController
{

    /**
     * Función para mostrar aviso legal
     * @Route("/aviso-legal", name="app_legal_notice")
     */
    public function viewLegalNotice()
    {
        return $this->render('footer/legal_notice.html.twig');
    }


    /**
     * function mostrar politicas cookies
     * @Route("/política-cookies", name="app_políticas_cookies")
     */

    public function viewCookiesPolicies()
    {
        return $this->render('footer/cookies.html.twig');
    }

    /**
     * function mostrar politicas cookies
     * @Route("/terminos-venta", name="app_sale_terms")
     */

    public function viewSaleTerms()
    {
        return $this->render('footer/sale_terms.html.twig');
    }

    /**
     * function mostrar politicas privacidad
     * @Route("/politica-privacidad", name="app_privacy_policy")
     */

    public function viewPrivacyPolicy()
    {
        return $this->render('footer/privacy_policy.html.twig');
    }

    /**
     * Renderizado de la página de contacto
     * @Route("/contacto", name="app_contact")
     */
    public function contact()
    {

        return $this->render('home/contact.html.twig');
        /**
         * @Route("/faq",name="app_privacity")
         */
    }

    public function privacidad()
        {
            return $this->render('footer/faq.html.twig');
        }
    }