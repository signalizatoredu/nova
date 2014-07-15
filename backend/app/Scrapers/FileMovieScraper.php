<?php

namespace Nova\Scrapers;

use SplFileInfo as FileInfo;

use Nova\Encoders\IEncoder;
use Nova\Encoders\XmlMovieEncoder;
use Nova\Models\Movie;
use Nova\IO\FileStorage;

class FileMovieScraper extends MovieScraper
{
    private $encoder;

    public function __construct(IEncoder $encoder = null)
    {
        if (!$encoder) {
            $encoder = new XmlMovieEncoder();
        }

        $this->encoder = $encoder;
    }

    public function initialize(Movie $movie)
    {
        $file = new FileInfo($movie->getNfoPath());
        $fileStorage = new FileStorage($this->encoder, $file);
        $this->movie = $fileStorage->read();
    }

    public function getTitle()
    {
        if (isset($this->movie->title)) {
            return $this->movie->title;
        }
    }

    public function getOriginalTitle()
    {
        if (isset($this->movie->original_title)) {
            return $this->movie->original_title;
        }
    }

    public function getSortTitle()
    {
        if (isset($this->movie->sort_title)) {
            return $this->movie->sort_title;
        }
    }

    public function getCollection()
    {
        if (isset($this->movie->collection)) {
            return $this->movie->collection;
        }
    }

    public function getRating()
    {
        if (isset($this->movie->rating)) {
            return $this->movie->rating;
        }
    }

    public function getYear()
    {
        if (isset($this->movie->year)) {
            return $this->movie->year;
        }
    }

    public function getOutline()
    {
        if (isset($this->movie->outline)) {
            return $this->movie->outline;
        }
    }

    public function getPlot()
    {
        if (isset($this->movie->plot)) {
            return $this->movie->plot;
        }
    }

    public function getTagline()
    {
        if (isset($this->movie->tagline)) {
            return $this->movie->tagline;
        }
    }

    public function getRuntime()
    {
        if (isset($this->movie->runtime)) {
            return $this->movie->runtime;
        }
    }

    public function getCertification()
    {
        if (isset($this->movie->certification)) {
            return $this->movie->certification;
        }
    }

    public function getImdbId()
    {
        if (isset($this->movie->imdb_id)) {
            return $this->movie->imdb_id;
        }
    }

    public function getTmdbId()
    {
        if (isset($this->movie->tmdb_id)) {
            return $this->movie->tmdb_id;
        }
    }

    public function getTrailer()
    {
        if (isset($this->movie->trailer)) {
            return $this->movie->trailer;
        }
    }

    public function getGenres()
    {
        if (isset($this->movie->genres)) {
            return $this->movie->genres;
        }
    }

    public function getStudios()
    {
        if (isset($this->movie->studios)) {
            return $this->movie->studios;
        }
    }

    public function getCountries()
    {
        if (isset($this->movie->countries)) {
            return $this->movie->countries;
        }
    }

    public function getCredits()
    {
        if (isset($this->movie->credits)) {
            return $this->movie->credits;
        }
    }

    public function getDirectors()
    {
        if (isset($this->movie->directors)) {
            return $this->movie->directors;
        }
    }

    public function getActors()
    {
        if (isset($this->movie->actors)) {
            return $this->movie->actors;
        }
    }

    public function getBackdrop()
    {

    }

    public function getPoster()
    {

    }
}
