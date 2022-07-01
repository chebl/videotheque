<?php

namespace App\Controller;

use App\Lib\Mail;
use App\Entity\Film;
use App\Form\FilmType;
use App\Entity\Category;
use App\Repository\FilmRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{
    private $filmRepository;
    private $categoryRepository;
    private $entityManager;

    public function __construct(FilmRepository $filmRepository, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $this->filmRepository = $filmRepository;
        $this->categoryRepository = $categoryRepository;

        $this->entityManager = $entityManager;
    }

    #[Route('/films', name: 'vid_films')]
    public function index(): Response
    {

        $films = $this->entityManager->getRepository(Film::class)->findAll();


        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }

    #[Route('/add-film', name: 'vid_add_film')]
    public function add(Request $request, Mail $mail): Response
    {
        $form = $this->createForm(FilmType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Save the Film 
            $film = $form->getData();
            /* 
            $cat=new Category();
            $cat->setName('Action');
            $this->categoryRepository->add($cat,true);
            $cat=new Category();
            $cat->setName('Comedy');
              $this->categoryRepository->add($cat,true);
             die;*/
            $this->filmRepository->add($film, true);
            $this->addFlash('success', 'Film ajouté avec Success');
            //send Email to ADMIN
            $from = 'chebl.mahmoud@gmail.com';
            $to = $this->getParameter('app.admin_email');
            $subject = "VideoTheque Update";
            $content = 'New film added !';
            $mail->sendEmail($to, $from, $subject, $content);
            $this->redirectToRoute('vid_films');
        }
        return $this->render('film/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
