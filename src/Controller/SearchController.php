<?php

namespace App\Controller;

use App\Services\FilmService;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'vid_search')]
    public function index(Request $request, FilmService $filmService): Response
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);
        $films=[];
        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère le Titre de film tapé dans le formulaire
            $title = $propertySearch->getTitle();
            //on récupère la categorie de film tapé dans le formulaire   
            $category = $propertySearch->getCategory();

            if ($title != "")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $films = $filmService->getFilmsByTitle($title);
            elseif ($category != "")
                $films = $filmService->getFilmsByCategory($category);
                
            else
                //si si aucun nom n'est fourni on affiche tous les articles
                $films = $filmService->getAll();
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'films' => $films
        ]);  
    }
}
