<?php

namespace App\Controller;

use App\Services\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'vid_list_category')]
    public function index(CategoryService $categoryService): Response
    {
        $categories = $categoryService->getAll();
 
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/films/{id}', name: 'vid_get_films')]
    public function show($id,CategoryService $categoryService): Response
    {
        $filmcategory = $categoryService->getCategoryById($id);
 
        return $this->render('category/show.html.twig', [
            'films' => $filmcategory
        ]);
    }


}
