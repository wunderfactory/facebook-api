<?php
/**
 * Created by PhpStorm.
 * User: muck
 * Date: 31/08/15
 * Time: 18:20
 */

namespace Wunderfactory\Facebook\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidFacebookAccessTokenException extends \RuntimeException implements HttpExceptionInterface
{
    private $statusCode;
    private $headers;

    public function __construct($statusCode, $message = null, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}