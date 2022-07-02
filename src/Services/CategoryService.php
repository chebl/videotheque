<?php

namespace App\Services;

use App\Repository\CategoryRepository;


class CategoryService
{
    private $categoryRepository;
    
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        return $this->categoryRepository->findAll();
    }
    public function getCategoryById($id)
    {
        return $this->categoryRepository->findOneById($id);
    }
    
}
