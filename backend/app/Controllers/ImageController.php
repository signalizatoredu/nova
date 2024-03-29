<?php

namespace Nova\Controllers;

use Nova\Models\ImageHandler;
use Nova\Models\Movie;

class ImageController extends ControllerBase
{
    public function posterAction($id, $width, $height)
    {
        $width = $this->filter->sanitize($width, "int");
        $width = (int)$width;

        $height = $this->filter->sanitize($height, "int");
        $height = (int)$height;

        $movie = Movie::findFirst($id);

        if (!$movie) {
            return $this->forward("error/notFound");
        }

        $image = new \Phalcon\Image\Adapter\GD($movie->poster);
        $image->resize($width, $height);

        return $this->imageResponse($image);
    }
}
