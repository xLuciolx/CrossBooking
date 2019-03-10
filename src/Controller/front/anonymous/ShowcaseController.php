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

use App\Entity\Member;
use App\Form\MemberType;
use App\Utils\Traits\Shortcut;

class ShowcaseController extends AbstractController
{
    use Shortcut;

    /**
     * Render Home View
     * @Route("/",name="home")
     * @method home
     * @return Response
     */
    public function home() : Response
    {
        return $this->render('front/anonymous/home.html.twig');
    }

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
     * Render Inscription View
     * @Route("/inscription",name="inscription")
     * @method  inscription
     * @return  Response
     * @param   Request $request
     */
    public function inscription(Request $request)
    {
        $member = new Member();
        /**
         * Create Form
         */
        $form = $this->createForm(MemberType::class, $member);
        dump($request);        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            /**
             * @var Symfony\Component\HttpFoundation\File\UploadedFile $file
             */
            $file = $form->get('avatar')->getData();
            /**
             * @var string $filename
             */
            $filename;

            if($file) {
                $filename = $this->generateSlug($member->getPseudo()) . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('avatar_path'),
                        $filename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            else {
                $filename = "default.png";
                dump('no image');
            }
            $member->setAvatar($filename);

            // if($image)
            // {
            //     $chemin = $this->getParameter('avatar_path');
            //     $extension = $image->guessExtension();
            //     if (!$extension) {
            //         // extension cannot be guessed
            //         $extension = 'jpg';
            //     }
            //     $image->move($chemin, $this->generateSlug($member['pseudo']).'.'.$extension);
            //     $member->avatar = $this->generateSlug($member['pseudo']) . '.' . $extension ;
            // }
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($member);
            // $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('front/anonymous/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}