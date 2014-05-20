<?php

namespace Nova\Apis;

use Nova\Models\Actor;
use Nova\Models\Movie;

class TmdbApiAdapter implements ITmdbApi
{
    const IMAGE_TYPE_BACKDROP = 'backdrop';
    const IMAGE_TYPE_PROFILE = 'profile';
    const IMAGE_TYPE_POSTER = 'poster';
    const IMAGE_SIZE_ORIGINAL = 'original';

    private $_tmdb;
    private $_movie;

    public function __construct($apiKey)
    {
        $this->_tmdb = new \TMDb($apiKey, 'en', true);
    }

    private function createMovie($data)
    {
        $movie = new Movie();

        // Array keys
        $nameKey = 'name';
        $titleKey = 'title';
        $originalTitleKey = 'original_title';
        $collectionKey = 'belongs_to_collection';
        $ratingKey = 'vote_average';
        $yearKey = 'release_date';
        $outlineKey = 'overview';
        $taglineKey = 'tagline';
        $runtimeKey = 'runtime';
        $imdbIdKey = 'imdb_id';
        $tmdbIdKey = 'id';
        $genresKey = 'genres';
        $studiosKey = 'production_companies';
        $countriesKey = 'production_countries';
        $backdropKey = 'backdrop_path';
        $posterKey = 'poster_path';

        if (array_key_exists($titleKey, $data)) {
            $movie->setTitle($data[$titleKey]);
        }

        if (array_key_exists($originalTitleKey, $data)) {
            $movie->setOriginalTitle($data[$originalTitleKey]);
        }

        if (array_key_exists($collectionKey, $data)) {
            $collection = null;
            $collectionData = $data[$collectionKey];

            if (isset($collectionData[$nameKey])) {
                $collection = $collectionData[$nameKey];
            }

            $movie->setCollection($collection);
        }

        if (array_key_exists($ratingKey, $data)) {
            $movie->setRating($data[$ratingKey]);
        }

        if (array_key_exists($yearKey, $data)) {
            $movie->setYear($data[$yearKey]);
        }

        if (array_key_exists($outlineKey, $data)) {
            $movie->setOutline($data[$outlineKey]);
        }

        if (array_key_exists($taglineKey, $data)) {
            $movie->setTagline($data[$taglineKey]);
        }

        if (array_key_exists($runtimeKey, $data)) {
            $movie->setRuntime($data[$runtimeKey]);
        }

        if (array_key_exists($imdbIdKey, $data)) {
            $movie->setImdbId($data[$imdbIdKey]);
        }

        if (array_key_exists($tmdbIdKey, $data)) {
            $movie->setTmdbId($data[$tmdbIdKey]);
        }

        if (array_key_exists($genresKey, $data)) {
            $genres = array();

            foreach ($data[$genresKey] as $genre) {
                if (isset($genre[$nameKey])) {
                    $genres[] = $genre[$nameKey];
                }
            }

            $movie->setGenres($genres);
        }

        if (array_key_exists($studiosKey, $data)) {
            $studios = array();

            foreach ($data[$studiosKey] as $studio) {
                if (isset($studio[$nameKey])) {
                    $studios[] = $studio[$nameKey];
                }
            }

            $movie->setStudios($studios);
        }

        if (array_key_exists($countriesKey, $data)) {
            $countries = array();

            foreach ($data[$countriesKey] as $country) {
                // TODO: Check if it's the name or the iso code of the country that should be used
                if (isset($country[$nameKey])) {
                    $countries[] = $country[$nameKey];
                }
            }

            $movie->setCountries($countries);
        }

        if (array_key_exists($backdropKey, $data)) {
            $backdrops = array();

            $backdrops[] = $this->getImagePath($data[$backdropKey], \TMDb::IMAGE_BACKDROP);

            $movie->setBackdrops($backdrops);
        }

        if (array_key_exists($posterKey, $data)) {
            $posters = array();

            $posters[] = $this->getImagePath($data[$posterKey], \TMDb::IMAGE_POSTER);

            $movie->setPosters($posters);
        }

        return $movie;
    }

    public function getMovieById($id, $full = false)
    {
        // TODO: Look over the possibilty to use &append_to_response=releases,trailers,casts,images on the api
        $data = $this->_tmdb->getMovie($id);
        $movie = $this->createMovie($data);

        if ($full) {
            $cast = $this->getMovieCast($id);
            $certification = $this->getMovieCertification($id);
            $images = $this->getMovieImages($id);
            $backdrops = $images['backdrops'];
            $posters = $images['posters'];
            $trailers = $this->getMovieTrailers($id);

            $movie->setActors($cast['actors']);
            $movie->setCredits($cast['credits']);
            $movie->setDirectors($cast['directors']);
            $movie->setCertification($certification);

            if (!empty($trailers))
                $movie->setTrailer(reset($trailers));

            if (!empty($backdrops)) {
                $movie->setBackdrops($backdrops);
            }

            if (!empty($posters)) {
                $movie->setPosters($posters);
            }
        }

        $this->_movie = $movie;

        return $this->_movie;
    }

    public function getMovieCast($id)
    {
        $actors = array();
        $credits = array();
        $directors = array();
        $data = null;

        // Array keys
        $castKey = 'cast';
        $crewKey = 'crew';
        $nameKey = 'name';
        $characterKey = 'character';
        $thumbKey = 'profile_path';
        $jobKey = 'job';

        $data = $this->_tmdb->getMovieCast($id);

        if (array_key_exists($castKey, $data)) {
            foreach ($data[$castKey] as $cast) {
                $actor = new Actor();

                if (array_key_exists($nameKey, $cast)) {
                    $actor->setName($cast[$nameKey]);
                }

                if (array_key_exists($characterKey, $cast)) {
                    $actor->setRole($cast[$characterKey]);
                }

                if (isset($thumbKey, $cast)) {
                    $thumb = $this->getImagePath($cast[$thumbKey], \TMDb::IMAGE_PROFILE);
                    $actor->setThumb($thumb);
                }

                $actors[] = $actor;
            }
        }

        if (array_key_exists($crewKey, $data)) {
            foreach ($data[$crewKey] as $crew) {
                if (array_key_exists($jobKey, $crew)) {
                    $job = $crew[$jobKey];

                    // TODO: Fix credits/writers recognizing
                    if ($job !== 'Writer' && $job !== 'Director') {
                        continue;
                    }

                    if (array_key_exists($nameKey, $cast)) {
                        $name = $crew[$nameKey];

                        if ($job === 'Director') {
                            $directors[] = $name;
                        } else if ($job === 'Writer') {
                            $credits[] = $name;
                        }
                    }
                }
            }
        }

        return array(
            'actors' => $actors,
            'credits' => $credits,
            'directors' => $directors,
        );
    }

    public function getMovieCertification($id)
    {
        $certification = null;

        $countriesKey = 'countries';
        $isoKey = 'iso_3166_1';
        $certificationKey = 'certification';
        $mpaaCountryCode = 'US';

        $info = $this->_tmdb->getMovieReleases($id);

        if (array_key_exists($countriesKey, $info)) {

            $countries = $info[$countriesKey];

            foreach ($countries as $country) {
                if (array_key_exists($isoKey, $country)) {
                    $countryCode = $country[$isoKey];

                    if ($countryCode === $mpaaCountryCode) {
                        if (array_key_exists($certificationKey, $country)) {
                            $certification = $country[$certificationKey];
                            break;
                        }
                    }
                }
            }
        }

        return $certification;
    }

    public function getMovieImages($id)
    {
        $backdrops = array();
        $posters = array();

        // Array keys
        $backdropsKey = 'backdrops';
        $postersKey = 'posters';
        $pathKey = 'file_path';

        $data = $this->_tmdb->getMovieImages($id);

        if (isset($data[$backdropsKey])) {
            foreach ($data[$backdropsKey] as $image) {
                if (isset($image[$pathKey])) {
                    $backdrops[] = $this->getImagePath($image[$pathKey], \TMDb::IMAGE_BACKDROP);
                }
            }
        }

        if (isset($data[$postersKey])) {
            foreach ($data[$postersKey] as $image) {
                if (isset($image[$pathKey])) {
                    $posters[] = $this->getImagePath($image[$pathKey], \TMDb::IMAGE_POSTER);
                }
            }
        }

        return array(
            'backdrops' => $backdrops,
            'posters' => $posters,
        );
    }

    public function getMovieTrailers($id)
    {
        $trailers = array();
        $data = $this->_tmdb->getMovieTrailers($id);

        // Array keys
        $youtubeKey = 'youtube';
        $sourceKey = 'source';

        if (isset($data[$youtubeKey])) {
            foreach ($data[$youtubeKey] as $video) {
                if (isset($video[$sourceKey])) {
                    $trailers[] = 'http://www.youtube.com/watch?v=' . $video[$sourceKey];
                }
            }
        }

        return $trailers;
    }

    public function search($query)
    {
        $movies = array();
        $results = $this->_tmdb->searchMovie($query);

        $results = $results['results'];

        foreach ($results as $result) {
            $movies[] = $this->createMovie($result);
        }

        return $movies;
    }

    private function getImagePath($path, $type, $size = self::IMAGE_SIZE_ORIGINAL)
    {
        return$this->_tmdb->getImageUrl($path, $type, $size);
    }
}
