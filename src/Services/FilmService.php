<?php

namespace App\Services;

use App\Entity\Film;
use App\Repository\FilmRepository;

class FilmService
{

    private $filmRepository;

    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    public function getAll()
    {
        return $this->filmRepository->findAll();
    }
   
    public function save(Film $film)
    {
        $this->filmRepository->add($film, true);
    }
     public function delete(Film $film)
    {
        $this->filmRepository->remove($film, true);
    }
}
