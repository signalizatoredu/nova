<?php

namespace Nova\Scrapers
{
    use Nova\Models\Movie;

    abstract class MovieScraper
    {
        const IDENTIFIER_TYPE_IMDB = 0;
        const IDENTIFIER_TYPE_NFO  = 1;
        const IDENTIFIER_TYPE_TMDB = 2;

        public function scrape(Movie $movie, $options = null)
        {
            $this->movie = $movie;
            $this->initialize($movie);

            if (is_array($options) || $options == null) {

                if ($options == null || in_array("title", $options))
                    $movie->title = $this->getTitle();

                if ($options == null || in_array("original_title", $options))
                    $movie->original_title = $this->getOriginalTitle();

                if ($options == null || in_array("sort_title", $options))
                    $movie->sort_title = $this->getSortTitle();

                if ($options == null || in_array("collection", $options))
                    $movie->collection = $this->getCollection();

                if ($options == null || in_array("rating", $options))
                    $movie->rating = $this->getRating();

                if ($options == null || in_array("year", $options))
                    $movie->year = $this->getYear();

                if ($options == null || in_array("outline", $options))
                    $movie->outline = $this->getOutline();

                if ($options == null || in_array("plot", $options))
                    $movie->plot = $this->getPlot();

                if ($options == null || in_array("tagline", $options))
                    $movie->tagline = $this->getTagline();

                if ($options == null || in_array("runtime", $options))
                    $movie->runtime = $this->getRuntime();

                if ($options == null || in_array("certification", $options))
                    $movie->certification = $this->getCertification();

                if ($options == null || in_array("imdb_id", $options))
                    $movie->imdb_id = $this->getImdbId();

                if ($options == null || in_array("tmdb_id", $options))
                    $movie->tmdb_id = $this->getTmdbId();

                if ($options == null || in_array("trailer", $options))
                    $movie->trailer = $this->getTrailer();

                if ($options == null || in_array("genres", $options))
                    $movie->genres = $this->getGenres();

                if ($options == null || in_array("studios", $options))
                    $movie->studios = $this->getStudios();

                if ($options == null || in_array("countries", $options))
                    $movie->countries = $this->getCountries();

                if ($options == null || in_array("credits", $options))
                    $movie->credits = $this->getCredits();

                if ($options == null || in_array("directors", $options))
                    $movie->directors = $this->getDirectors();

                if ($options == null || in_array("actors", $options))
                    $movie->actors = $this->getActors();

                if ($options == null || in_array("backdrop", $options))
                    $movie->backdrop = $this->getBackdrop();

                if ($options == null || in_array("poster", $options))
                    $movie->poster = $this->getPoster();
            }
        }

        // Scraper related getters
        abstract public function initialize(Movie $movie);

        // Movie-related getters
        abstract public function getTitle();
        abstract public function getOriginalTitle();
        abstract public function getSortTitle();
        abstract public function getCollection();
        abstract public function getRating();
        abstract public function getYear();
        abstract public function getOutline();
        abstract public function getPlot();
        abstract public function getTagline();
        abstract public function getRuntime();
        abstract public function getCertification();
        abstract public function getImdbId();
        abstract public function getTmdbId();
        abstract public function getTrailer();
        abstract public function getGenres();
        abstract public function getStudios();
        abstract public function getCountries();
        abstract public function getCredits();
        abstract public function getDirectors();
        abstract public function getActors();
        abstract public function getBackdrop();
        abstract public function getPoster();
    }
}
