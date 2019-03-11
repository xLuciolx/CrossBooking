<?php

namespace App\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;

use App\Entity\Book;

class BookManager
{
    /**
     * @var Registry $doctrine
     */
    private $doctrine;

    public function __construct(
        Registry $doctrine
    ) {
        $this->doctrine = $doctrine;
    }

    /**
     * Capture a book
     * @method capture
     * @param $form, $book
     * @return
     */
    public function capture($form, Book $book)
    {
        
        return true;
    }
}