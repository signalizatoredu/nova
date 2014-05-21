<?php

namespace Nova\Scrapers;

use Nova\Encoders\IEncoder;
use Nova\Encoders\XmlMovieEncoder;
use Nova\Models\Movie;
use Nova\IO\FileStorage;

class FileMovieScraper extends MovieScraper
{
    private $_encoder;
    private $_movie;

    public function __construct(IEncoder $encoder = null)
    {
        if (!$encoder) {
            $encoder = new XmlMovieEncoder();
        }

        $this->_encoder = $encoder;
    }

    public function initialize(Movie $movie)
    {
        $fileStorage = new FileStorage($this->_encoder, $movie->getNfoPath());
        $this->_movie = $fileStorage->read();
    }

    public function getTitle()
    {
        if (isset($this->_movie->title)) {
            return $this->_movie->title;
        }
    }

    public function getOriginalTitle()
    {
        if (isset($this->_movie->original_title)) {
            return $this->_movie->original_title;
        }
    }

    public function getSortTitle()
    {
        if (isset($this->_movie->sort_title)) {
            return $this->_movie->sort_title;
        }
    }

    public function getCollection()
    {
        if (isset($this->_movie->collection)) {
            return $this->_movie->collection;
        }
    }

    public function getRating()
    {
        if (isset($this->_movie->rating)) {
            return $this->_movie->rating;
        }
    }

    public function getYear()
    {
        if (isset($this->_movie->year)) {
            return $this->_movie->year;
        }
    }

    public function getOutline()
    {
        if (isset($this->_movie->outline)) {
            return $this->_movie->outline;
        }
    }

    public function getPlot()
    {
        if (isset($this->_movie->plot)) {
            return $this->_movie->plot;
        }
    }

    public function getTagline()
    {
        if (isset($this->_movie->tagline)) {
            return $this->_movie->tagline;
        }
    }

    public function getRuntime()
    {
        if (isset($this->_movie->runtime)) {
            return $this->_movie->runtime;
        }
    }

    public function getCertification()
    {
        if (isset($this->_movie->certification)) {
            return $this->_movie->certification;
        }
    }

    public function getImdbId()
    {
        if (isset($this->_movie->imdb_id)) {
            return $this->_movie->imdb_id;
        }
    }

    public function getTmdbId()
    {
        if (isset($this->_movie->tmdb_id)) {
            return $this->_movie->tmdb_id;
        }
    }

    public function getTrailer()
    {
        if (isset($this->_movie->trailer)) {
            return $this->_movie->trailer;
        }
    }

    public function getGenres()
    {
        if (isset($this->_movie->genres)) {
            return $this->_movie->genres;
        }
    }

    public function getStudios()
    {
        if (isset($this->_movie->studios)) {
            return $this->_movie->studios;
        }
    }

    public function getCountries()
    {
        if (isset($this->_movie->countries)) {
            return $this->_movie->countries;
        }
    }

    public function getCredits()
    {
        if (isset($this->_movie->credits)) {
            return $this->_movie->credits;
        }
    }

    public function getDirectors()
    {
        if (isset($this->_movie->directors)) {
            return $this->_movie->directors;
        }
    }

    public function getActors()
    {
        if (isset($this->_movie->actors)) {
            return $this->_movie->actors;
        }
    }

    public function getBackdrop()
    {

    }

    public function getPoster()
    {

    }
}
