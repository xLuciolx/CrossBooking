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

use App\Entity\Book;
use App\Entity\Capture;
use App\Service\BookManager;
use App\Form\CaptureType;

class BookController extends AbstractController
{
    /**
     * Render Search View
     * @Route("/recherche",name="search")
     * @method search
     * @return Response
     */
    public function search() : Response
    {
        return $this->render('front/anonymous/book/search.html.twig');
    }

    // public function searchPost(Application $app, Request $request) {
        
    //     if($request->isMethod('POST')) :
            
    //         # Check if book exist in DB
    //         $isBookInDb = $app['idiorm.db']->for_table('books')
    //             ->where('ISBN_book', $request->get('ISBN_book'))
    //             ->count();
        
    //         if($isBookInDb) :
                
    //             # Get books infos from DB
    //             $books = $app['idiorm.db']->for_table('books')
    //             ->where('ISBN_book', $request->get('ISBN_book'))
    //             ->find_many();
    //             $tableBooks = array();
    //             $rowBooks = array();
    //             $tableBooks['cols'] = array(
    //                 array('label' => 'ID Book', 'type' => 'string'),
    //                 array('label' => 'Title Book', 'type' => 'string')
    //                 );
    //             for ($i=0; $i < count($books); $i++) {
    //                 $ligneBooks = $books[$i];
    //                 $temp = array();
    //                 $temp[] = array ('v' => $ligneBooks['id_book']);
    //                 $temp[] = array('v' => $ligneBooks['title_book']);
    //                 $rowBooks[] = array('c' => $temp);
    //                 }
    //             $tableBooks['rows'] = $rowBooks;
        
                
    //             # Response : true
    //             $result['ok'] = $isBookInDb;
                
    //         else :
            
    //             # There is no book, response: false
    //             $result['nok'] = 'not in DB';
            
    //         endif;
            
    //         return $app->json($result);            
        
    //     endif;
    // }

    /**
     * Render History View
     * @Route("/histoire",name="history")
     * @method history
     * @param Request $request
     * @return Response
     */
    public function history(Request $request) : Response
    {
        /**
         * @var integer $id_book
         */
        $id_book = $request->query->get('id_book');

        /**
         * @var object $stories
         */
        $stories = $this    ->getDoctrine()
                            ->getRepository(Book::class)
                            ->findBy(['id' => $id_book]);

        # Render Registration View
        return $this->render('front/anonymous/book/history.html.twig', [
            'id_book' => $id_book,
            'stories'   => $stories
        ]);
    }

        /**
     * Render BookList View
     * @Route("/liste-des-livres",name="book-list")
     * @method bookList
     * @param Request $request
     * @return Response
     */
    public function bookList(Request $request) : Response
    {
        $bookList = $this  ->getDoctrine()
                            ->getRepository(Book::class)
                            ->findAll();

        # Render BookList View
        return $this->render('front/anonymous/book/book_list.html.twig', [
            'bookList'  => $bookList,
            'addFriend' => $request->query->get('addFriend'),
            'friend'    => $request->query->get('friend'),
        ]);
    }

    /**
     * Render Capture View
     * @Route("/capture",name="capture")
     * @method capture
     * @param Request $request, BookManager $bookManager
     * @return Response
     */
    public function capture(Request $request, BookManager $bookManager) : Response
    {
        /**
         * Create a Capture Instance
         * @var Capture $capture
         */
        $capture = new Capture();
        # Create Form
        $form = $this->createForm(CaptureType::class, $capture);

        # Handle request 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $bookManager->capture($form, $capture);
            if($result) return $this->redirect('?captureResult=success');
            else return $this->redirect('?captureResult=fail');
        }

        # Render Registration View
        return $this->render('front/anonymous/book/capture.html.twig', [
            'formCapture' => $form->createView(),
            'captureResult' => $request->query->get('inscription')
        ]);
    }

}