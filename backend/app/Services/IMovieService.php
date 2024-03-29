<?php

namespace Nova\Services;

use Nova\Models\Directory;
use Nova\Models\Movie;

interface IMovieService
{
    /**
     * Get all movies
     *
     * @return array
     */
    public function getMovies();

    /**
     * Get a movie by it's ID
     *
     * @param int $id The ID of the movie
     *
     * @return Movie|null
     */
    public function getMovieById($id);

    /**
     * Clear all missing movies from the store
     *
     * Checks if the related video-file still exists and when it doesn't,
     * removes it from the store.
     *
     * @return void
     */
    public function clearMissingMovies();

    /**
     * Scan for new movies in all movie directories
     *
     * Finds all new movies in the movie directories, adds them to the store
     * and then returns them.
     *
     * @return array
     */
    public function scanMovieDirectories();

    /**
     * Scan for new movies in a directory
     *
     * Finds all new movies in a directory, adds them to the store
     * and then returns them.
     *
     * @param Directory $directory
     * @param array $movies
     *
     * @return array
     */
    public function scanMovieDirectory(Directory $directory, array $movies);

    /**
     * Scrape information for a movie
     *
     * @param Movie $movie The movie to be scraped
     * @param array $options Options of which to use when scraping
     *
     * @return Movie
     */
    public function scrapeMovie(Movie $movie, array $options);
}
