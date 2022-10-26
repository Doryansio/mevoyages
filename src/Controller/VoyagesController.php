<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Description of VoyagesController
 *
 * @author Doryan
 */
class VoyagesController extends AbstractController {
    /**
     * @Route("/voyages", name="voyages")
     * @return Response
     */
    public function index (): Response{
        $visite = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("pages/voyages.html.twig",  ['visites' => $visite
                ]);
    }

    /**
     * 
     * @var VisiteRepository
     */
    private $repository; 

    /**
     * 
     * @param VisiteRepository $repository
     */
     public function __construct(VisiteRepository $repository){
        $this->repository = $repository;
    }

}