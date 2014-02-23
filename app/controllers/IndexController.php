<?php

namespace Controllers
{
    use Models\Movie;

    class IndexController extends ControllerBase
    {

        public function indexAction()
        {
            $movies = Movie::find();
            $this->view->setVar("movies", $movies);
        }
    }
}
