<?php

namespace Nova\Services;

use DirectoryIterator;
use InvalidArgumentException;
use SplFileInfo as FileInfo;

use Nova\Models\Directory;
use Nova\Models\DirectoryType;
use Nova\Models\Movie;
use Nova\Object;
use Nova\Scrapers\FileMovieScraper;
use Nova\Services\IMovieService;

class MovieService implements IMovieService
{
    public function getMovies()
    {
        $movies = array();

        foreach (Movie::find() as $movie) {
            $movie->afterFetch();
            $movies[] = $movie;
        }

        return $movies;
    }

    public function getMovieById($id)
    {
        $movie = Movie::findFirst($id);

        if (!$movie) {
            return null;
        }

        return $movie;
    }

    public function clearMissingMovies()
    {
        $movies = Movie::find();

        foreach ($movies as $movie) {
            $file = new FileInfo($movie->getPath());

            if (!$file->getRealPath()) {
                $movie->delete();
            }
        }
    }

    public function scanMovieDirectories()
    {
        $directoryType = DirectoryType::findFirstByType("Movie");

        $movies = array();

        foreach ($directoryType->directory as $directory) {
            $movies = $this->scanMovieDirectory($directory, $movies);
        }

        return $movies;
    }

    public function scanMovieDirectory(Directory $directory, array $movies = array())
    {
        $directoryInfo = new FileInfo($directory->path);

        $movieFiles = $this->recursiveDirectoryWalk($directoryInfo, $movieFiles);

        foreach ($movieFiles as $file) {
            // TODO: Check path and directory_id
            $path = str_replace($directory->path, "", $file);

            $dbMovie = Movie::findFirst(array(
                "conditions" => "path = ?1 AND directory_id = ?2",
                "bind" => array(1 => $path, 2 => $directory->id)
            ));

            // If the movie weren't found in the store it's new. We
            // then save it and adds it to the new movie list.
            if (!$dbMovie) {
                $movie = new Movie();

                $movie->setPath($path);
                $movie->directory = $directory;
                $movie->afterFetch();
                $movie->save();

                $movies[] = $movie;
            }
        }

        return $movies;
    }

    public function scrapeMovie(Movie $movie, array $options)
    {
        $scraper = new FileMovieScraper();
        $scraper->scrape($movie, $options);

        return $movie;
    }

    /**
     * Search for media files in a directory.
     *
     * @throws Exception
     *
     * @param FileInfo $directory
     * @param array $fileList
     * @param boolean $recursive Optional: Do a recursive scan. Defaults to true.
     *
     * @return array
     */
    private function findDirectoryMediaFiles(FileInfo $directory, array $videoFiles, $recursive = true)
    {
        if (!$directory->isDir()) {
            throw new InvalidArgumentException("FileInfo instance was exptected to be a directory.");
        }

        $directoryIterator = new DirectoryIterator($directory->getPathname());

        foreach ($directoryIterator as $child) {
            if ($child->isDir() && $recursive) {
                $videoFiles = $this->recursiveDirectoryWalk($child, $fileList);
            } else {
                $extension = strtolower($child->getExtension());

                switch ($extension) {
                    case "avi":
                    case "mkv":
                    case "mp4":
                        $videoFiles[] = $child->getRealPath();
                        break;
                    default:
                        break;
                }
            }
        }

        return $videoFiles;
    }
}
