<?php

namespace Nova\Models;

use SplFileInfo as FileInfo;

use Nova\Scrapers\FileMovieScraper;

class Movie extends ModelBase
{
    protected $path;

    public $id;
    public $title;
    public $original_title;
    public $sort_title;
    public $collection;
    public $rating;
    public $year;
    public $outline;
    public $plot;
    public $tagline;
    public $runtime;
    public $certification;
    public $imdb_id;
    public $tmdb_id;
    public $trailer;
    public $genres;
    public $studios;
    public $countries;
    public $credits;
    public $directors;
    public $actors;
    public $backdrop;
    public $poster;

    public function initialize()
    {
        $this->belongsTo("directory_id", "Nova\Models\Directory", "id", array(
            "alias" => "directory"
        ));
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function afterFetch()
    {
        if ($this->hasNfo()) {
            $scraper = new FileMovieScraper();
            $scraper->scrape($this);
        } else {
            $this->title = $this->getFilename();
        }

        if ($this->hasBackdrop()) {
            $this->backdrop = sprintf(
                "%s/%s-fanart.jpg",
                $this->getDirectory(),
                $this->getFilename()
            );
        }

        if ($this->hasPoster()) {
            $this->poster = sprintf(
                "%s/%s-poster.jpg",
                $this->getDirectory(),
                $this->getFilename()
            );
        }
    }

    public function getNfoPath()
    {
        return sprintf("%s/%s.nfo", $this->getDirectory(), $this->getFilename());
    }

    public function hasNfo()
    {
        $file = new FileInfo($this->getNfoPath());

        return $file->getRealPath() !== false;
    }

    public function hasBackdrop()
    {
        $file = new FileInfo(sprintf(
            "%s/%s-fanart.jpg",
            $this->getDirectory(),
            $this->getFilename()
        ));

        return $file->getRealPath() !== false;
    }

    public function hasPoster()
    {
        $file = new FileInfo(sprintf(
            "%s/%s-poster.jpg",
            $this->getDirectory(),
            $this->getFilename()
        ));

        return $file->getRealPath() !== false;
    }

    private function getFullPath()
    {
        $path = $this->directory->path;
        $path .= $this->getPath();

        return $path;
    }

    private function getDirectory()
    {
        $info = new FileInfo($this->getFullPath());

        return $info->getPath();
    }

    private function getFilename()
    {
        $info = new FileInfo($this->getFullPath());

        return $info->getBasename("." . $info->getExtension());
    }
}
