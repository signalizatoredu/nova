<?php

namespace Nova\Controllers;

use Nova\Object;
use Nova\Models\Directory;
use Nova\Models\DirectoryType;
use Nova\Models\Movie;

class MovieController extends ControllerBase
{
    public function indexAction()
    {
        $model = new Object();
        $model->movies = array();

        $movies = Movie::find();

        foreach ($movies as $movie) {
            $movie->afterFetch();
            $model->movies[] = $movie;
        }

        return $this->jsonResponse($model);
    }

    public function findAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $movie = Movie::findFirst($id);

        if (!$movie) {
            return $this->forward("error/not_found");
        }

        $model = new Object();
        $model->movie = $movie;

        return $this->jsonResponse($model);
    }

    public function scanAction()
    {
        $directoryType = DirectoryType::findFirstByType("Movie");

        $movies = array();

        foreach ($directoryType->directory as $directory) {
            $movieFiles = array();

            $directoryInfo = new \Nova\IO\FileInfo($directory->path);
            $movieFiles = $this->recursiveDirectoryWalk($directoryInfo, $movieFiles);

            foreach ($movieFiles as $file) {
                // TODO: Check path and directory_id
                $path = str_replace($directory->path, "", $file);

                $dbMovie = Movie::findFirst(array(
                    "conditions" => "path = ?1 AND directory_id = ?2",
                    "bind" => array(1 => $path, 2 => $directory->id)
                ));

                if (!$dbMovie) {
                    $movie = new Movie();
                    $movie->setPath($path);
                    $movie->directory = $directory;
                    $movie->afterFetch();
                    $movie->save();
                    $movies[] = $movie;
                }

            }

        }


        return $this->jsonResponse($movies);
    }

    public function scrapeAction($id)
    {
        $id = $this->filter->sanitize($id, array("int"));

        $movie = Movie::findFirst($id);

        $scraper = new \Nova\Scrapers\FileMovieScraper();
        $scraper->scrape($movie, $this->request->getPost("options"));

        return $this->jsonResponse($movie);
    }

    private function recursiveDirectoryWalk(\Nova\IO\FileInfo $directory, $dataArray)
    {
        $children = $directory->getChildren();

        foreach ($children as $child) {
            if ($child->isDir()) {
                $dataArray = $this->recursiveDirectoryWalk($child, $dataArray);
            } else {
                $extension = strtolower($child->getExtension());
                switch ($extension) {
                    case "avi":
                    case "mkv":
                    case "mp4":
                        $dataArray[] = $child->getRealPath();
                        break;
                    default:
                        break;
                }
            }
        }

        return $dataArray;
    }
}
