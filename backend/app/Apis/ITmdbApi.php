<?php

namespace Nova\Apis;

interface ITmdbApi
{
    public function __construct($apiKey);
    public function getMovieById($id, $full);
    public function getMovieCast($id);
    public function getMovieCertification($id);
    public function getMovieImages($id);
    public function getMovieTrailers($id);
    public function search($query);
}
