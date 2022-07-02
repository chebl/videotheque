<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Services\Mail;
use App\Entity\Category;
use App\Repository\FilmRepository;
use App\Repository\CategoryRepository;
use App\Services\FilmService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{

    #[Route('/films', name: 'vid_films')]
    public function index(FilmService $filmService): Response
    {

        $films = $filmService->getAll();

        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }

    #[Route('/add_film', name: 'vid_add_film')]
    public function add(Request $request, Mail $mail, FilmService $filmService): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
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

            $filmService->save($film);
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

    #[Route('/edit_film/{id}', name: 'vid_edit_film')]
    public function edit(Request $request, Film $film, FilmService $filmService): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $filmService->save($film);
            return $this->redirectToRoute('vid_films');
        }
        return $this->render('film/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete_film/{id}', name: 'vid_delete_film')]
    public function delete(Film $film, FilmService $filmService): Response
    {
        $filmService->delete($film);
        return $this->redirectToRoute('vid_films');
    }


}
