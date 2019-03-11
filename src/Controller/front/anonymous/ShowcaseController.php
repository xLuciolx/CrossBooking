<?php

/**
 * Created by PhpStorm.
 * User: loic
 * Date: 09/03/19
 * Time: 16:12
 */

namespace App\Controller\front\anonymous;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\Mailer;
use App\Form\ContactForm;

use Dompdf\Dompdf;
use Dompdf\Options;

class ShowcaseController extends AbstractController
{

    /**
     * Render Menu
     * @method menu
     * @return Response
     * @param $active_page: string
     */
    public function menu($active_page) : Response
    {
        return $this->render('menu.html.twig', [
            'active_page' => $active_page
        ]);
    }

    /**
     * Render Home View
     * @Route("/",name="home")
     * @method home
     * @return Response
     */
    public function home() : Response
    {
        return $this->render('front/anonymous/showcase/home.html.twig');
    }

    /**
     * Render Terms and Conditions View
     * @Route("/mentions-legales",name="terms")
     * @method termsAndConditions
     * @return Response
     */
    public function termsAndConditions() : Response
    {
        return $this->render('front/anonymous/showcase/terms.html.twig');
    }

    /**
     * Render Contact View
     * @Route("/contact",name="contact")
     * @method contact
     * @return Response
     */
    public function contact(Request $request, Mailer $mailer) : Response
    {
        # Create Form
        $form = $this->createForm(ContactForm::class);

        # Handle request 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sendMessage = $mailer->contact($form);
            return $this->render('front/anonymous/showcase/contact.html.twig', [
                'form' => $form->createView(),
                'sendMessage' => $sendMessage
            ]);
        }

        # Render Registration View
        return $this->render('front/anonymous/showcase/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Render Sticker View
     * @Route("/sticker",name="sticker")
     * @method sticker
     * @param Request $request
     * @return Response
     */
    public function sticker(Request $request) : Response
    {
        $uniqueId = $request->query->get('uniqueId');
        $title = $request->query->get('title');

        # Instanciate a new Dompdf object
        $sticker = new Dompdf();
        # Set path to assets folder
        $sticker->setBasePath($this->getParameter('assets_path'));
        # Load HTML file using Twig
        $sticker->loadHtml($this->render('front/anonymous/showcase/sticker.html.twig', [
            'uniqueId' => $uniqueId,
            'title'    => $title
        ]));
        # Render pdf
        $sticker->render();
        # Attach the file to the browser (Attachement: option to display the pdf)
        $sticker->stream('sticker.pdf',array('Attachment'=>0));
    }

}
