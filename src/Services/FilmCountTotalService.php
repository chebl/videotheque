<?php

namespace App\Services;
use App\Services\FilmService;
use Symfony\Component\HttpFoundation\RequestStack;

class FilmCountTotalService {

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function setTotalFilms(FilmService $filmService)
    {
        $session = $this->requestStack->getSession();

        // stores an attribute in the session for later reuse
        $count=$filmService->getNbreOfFilms();

        $session->set('NombreofFilms', $count);

    }
}