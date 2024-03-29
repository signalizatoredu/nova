<?php

namespace Nova\Encoders;

use InvalidArgumentException;
use RuntimeException;
use XMLWriter;

use Nova\Encoders\IEncoder;
use Nova\Models\Model;
use Nova\Models\Actor;
use Nova\Models\Movie;

class XmlMovieEncoder implements IEncoder
{
    public function encode($data)
    {
        if (!($data instanceof Movie)) {
            throw new InvalidArgumentException("Input data should be of object type Movie");
        }

        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument("1.0", "UTF-8", "yes");
        $writer->setIndent(true);

        $writer->startElement("movie");
        $writer->writeElement("title", $data->title);
        $writer->writeElement("originaltitle", $data->original_title);
        $writer->writeElement("sorttitle", $data->sort_title);
        $writer->writeElement("set", $data->Collection);
        $writer->writeElement("rating", $data->rating);
        $writer->writeElement("year", $data->year);
        $writer->writeElement("outline", $data->outline);
        $writer->writeElement("plot", $data->plot);
        $writer->writeElement("tagline", $data->tagline);
        $writer->writeElement("runtime", $data->runtime);
        $writer->writeElement("mpaa", $data->certification);
        $writer->writeElement("id", $data->imdb_id);
        $writer->writeElement("tmdbid", $data->tmdb_id);
        $writer->writeElement("trailer", $data->tailer);

        foreach ($data->genres as $genre) {
            $writer->writeElement("genre", $genre);
        }

        foreach ($data->studios as $studio) {
            $writer->writeElement("studio", $studio);
        }

        foreach ($data->countries as $country) {
            $writer->writeElement("country", $country);
        }

        foreach ($data->credits as $credit) {
            $writer->writeElement("credits", $credit);
        }

        foreach ($data->directors as $director) {
            $writer->writeElement("director", $director);
        }

        foreach ($data->actors as $actor) {
            $writer->startElement("actor");
            $writer->writeElement("name", $actor->name);
            $writer->writeElement("role", $actor->role);
            $writer->writeElement("thumb", $actor->thumb);
            $writer->endElement();
        }

        $writer->endElement();
        $xml = $writer->outPutMemory();

        return $xml;
    }

    public function decode($data)
    {
        // TODO: Using Model won"t work
        $movie = new Movie();
        $xml = simplexml_load_string($data);

        if ($xml === false) {
            throw new RuntimeException("Could not parse input as valid XML");
        }

        if ($xml->title) {
            $movie->title =(string)$xml->title;
        }
        if ($xml->originaltitle) {
            $movie->original_title = (string)$xml->originaltitle;
        }
        if ($xml->sorttitle) {
            $movie->sort_title = (string)$xml->sorttitle;
        }
        if ($xml->set) {
            $movie->collection = (string)$xml->set;
        }
        if ($xml->rating) {
            $movie->rating = (float)$xml->rating;
        }
        if ($xml->year) {
            $movie->year = (int)$xml->year;
        }
        if ($xml->outline) {
            $movie->outline = (string)$xml->outline;
        }
        if ($xml->plot) {
            $movie->plot = (string)$xml->plot;
        }
        if ($xml->tagline) {
            $movie->tagline = (string)$xml->tagline;
        }
        if ($xml->runtime) {
            $movie->runtime = (int)$xml->runtime;
        }
        if ($xml->mpaa) {
            $movie->certification = (string)$xml->mpaa;
        }
        if ($xml->id) {
            $movie->imdb_id = (string)$xml->id;
        }
        if ($xml->tmdbid) {
            $movie->tmdb_id = (int)$xml->tmdbid;
        }
        if ($xml->trailer) {
            $movie->trailer = (string)$xml->trailer;
        }

        if ($xml->genre) {
            $movie->genres = array();

            foreach ($xml->genre as $genre) {
                $movie->genres[] = (string)$genre;
            }
        }

        if ($xml->studio) {
            $movie->studios = array();

            foreach ($xml->studio as $studio) {
                $movie->studios[] = (string)$studio;
            }
        }

        if ($xml->country) {
            $movie->countries = array();

            foreach ($xml->country as $country) {
                $movie->countries[] = (string)$country;
            }
        }

        if ($xml->credits) {
            $movie->credits = array();

            foreach ($xml->credits as $credit) {
                $movie->credits[] = (string)$credit;
            }
        }

        if ($xml->director) {
            $movie->directors = array();

            foreach ($xml->director as $director) {
                $movie->directors[] = (string)$director;
            }
        }

        if ($xml->actor) {
            $movie->actors = array();

            foreach ($xml->actor as $xmlActor) {
                $actor = new Actor();
                $actor->name = (string)$xmlActor->name;
                $actor->role = (string)$xmlActor->role;
                $actor->thumb = (string)$xmlActor->thumb;
                $movie->actors[] = $actor;
            }
        }

        return $movie;
    }
}
