<?php

namespace Nova\Controllers;

use Nova\Object;
use Nova\Models\Movie;
use Nova\Services\IMovieService;
use Nova\Services\MovieService;

class MovieController extends ControllerBase
{
    private $movieService;

    public function initialize()
    {
        $this->movieService = new MovieService();
    }

    public function indexAction()
    {
        $model = new Object();
        $model->movies = $this->movieService->getMovies();

        return $this->jsonResponse($model);
    }

    public function findAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $movie = $this->movieService->getMovieById($id);

        if (!$movie) {
            return $this->forward("error/notFound");
        }

        $model = new Object();
        $model->movie = $movie;

        return $this->jsonResponse($model);
    }

    public function scanAction()
    {
        $movies = array();

        $this->movieService->clearMissingMovies();
        $movies = $this->movieService->scanMovieDirectories();

        return $this->jsonResponse($movies);
    }

    public function scrapeAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $movie = $this->movieService->getMovieById($id);
        $movie = $this->movieService->scrapeMovie($movie);

        return $this->jsonResponse($movie);
    }
}
