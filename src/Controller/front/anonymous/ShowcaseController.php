<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 09/03/19
 * Time: 16:12
 */

namespace App\Controller\front\anonymous;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowcaseController extends AbstractController
{
    /**
     * @Route("/",name="home")
     */
    public function home()
    {
        return $this->render('front/anonymous/home.html.twig');
    }

    public function menu($active_page)
    {
        return $this->render('menu.html.twig', [
            'active_page' => $active_page
        ]);
    }
}