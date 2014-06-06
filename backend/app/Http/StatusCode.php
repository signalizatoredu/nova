<?php

namespace Nova\Http;

final class StatusCode
{
    private static $messages = array(
        self::OK => "OK",
        self::CREATED => "Created",
        self::ACCEPTED => "Accepted",
        self::MOVED_PERMANENTLY => "Moved Permanently",
        self::FOUND => "Found",
        self::SEE_OTHER => "See Other",
        self::NOT_MODIFIED => "Not Modified",
        self::BAD_REQUEST => "Bad Request",
        self::UNAUTHORIZED => "Unauthorized",
        self::FORBIDDEN => "Forbidden",
        self::NOT_FOUND => "Not Found",
        self::CONFLICT => "Conflict",
        self::UNPROCESSABLE_ENTITY => "Unprocessable Entity",
        self::INTERNAL_SERVER_ERROR => "Internal Server Error",
        self::NOT_IMPLEMENTED => "Not Implemented",
        self::SERVICE_UNAVAILABLE => "Service Unavailable",
    );

    const OK = 200,
          CREATED = 201,
          ACCEPTED = 202,
          MOVED_PERMANENTLY = 301,
          FOUND = 302,
          SEE_OTHER = 303,
          NOT_MODIFIED = 304,
          BAD_REQUEST = 400,
          UNAUTHORIZED = 401,
          FORBIDDEN = 403,
          NOT_FOUND = 404,
          CONFLICT = 409,
          UNPROCESSABLE_ENTITY = 422,
          INTERNAL_SERVER_ERROR = 500,
          NOT_IMPLEMENTED = 501,
          SERVICE_UNAVAILABLE = 503;

    private function __construct()
    {

    }

    public static function getMessage($code)
    {
        return self::$messages[$code];
    }
}
