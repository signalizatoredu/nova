<?php

namespace Scrapers
{
    class TmdbMovieScraper extends MovieScraper
    {
        public function getIdentifierType()
        {
            return MovieScraper::IDENTIFIER_TYPE_TMDB;
        }
    }
}
