<?php

namespace Nova\Models;

use Nova\IO\FileInfo;

class Movie extends Model
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

    private function getRealPath()
    {
        $path = $this->directory->path;
        $path .= $this->getPath();

        return $path;
    }

    protected function getDirectory()
    {
        $info = new FileInfo($this->getRealPath());

        return $info->getParentPath();
    }

    protected function getFilename()
    {
        $info = new FileInfo($this->getRealPath());

        return $info->getFilenameWithoutExtension();
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function afterFetch()
    {
        if ($this->hasNfo()) {
            $scraper = new \Nova\Scrapers\FileMovieScraper();
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

    public function beforeSave()
    {
    }

    public function getNfoPath()
    {
        return sprintf("%s/%s.nfo", $this->getDirectory(), $this->getFilename());
    }

    public function hasNfo()
    {
        $file = new FileInfo($this->getNfoPath());

        return $file->exists();
    }

    public function hasBackdrop()
    {
        $file = new FileInfo(sprintf(
            "%s/%s-fanart.jpg",
            $this->getDirectory(),
            $this->getFilename()
        ));

        return $file->exists();
    }

    public function hasPoster()
    {
        $file = new FileInfo(sprintf(
            "%s/%s-poster.jpg",
            $this->getDirectory(),
            $this->getFilename()
        ));

        return $file->exists();
    }
}
