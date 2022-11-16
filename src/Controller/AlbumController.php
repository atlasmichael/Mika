<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Album;
use App\Form\AlbumType;

class AlbumController extends AbstractController
{
    #[Route('/album', name: 'album', methods : ['GET'])]
    
    public function index(AlbumRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $album = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('pages/album/index.html.twig',['album' => $album]);
    }

    #[Route('/album/nouveau',name:'album.new', methods : ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ):Response 
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $album = $form->getData();
            $manager->persist($album);
            $manager->flush();            

        }
        return $this->render('pages/album/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
