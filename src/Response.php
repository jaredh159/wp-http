<?php

namespace NetRivet\WordPress\Http;


class Response
{

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @param string  $body
     * @param integer $statusCode
     * @param array   $headers
     * @throws \InvalidArgumentException
     */
    public function __construct($body = '', $statusCode = 200, array $headers = [])
    {
        if (! $this->statusCodeValid($statusCode)) {
            throw new \InvalidArgumentException('Invalid status code');
        }

        $this->body = $body;
        $this->statusCode = $statusCode;
    }

    /**
     * Gets the response status code.
     *
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Gets the body of the response
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get json-decoded body
     *
     * @return array
     */
    public function json()
    {
        $json = json_decode(strval($this->getBody()), true);

        if (!is_array($json)) {
            throw new \UnexpectedValueException('Body not json-encoded');
        }

        return $json;
    }

    /**
     * Determine validity of input status code
     *
     * @param  mixed $statusCode
     * @return bool
     */
    protected function statusCodeValid($statusCode)
    {
        if (!is_int($statusCode)) {
            return false;
        }

        return $statusCode >= 100 && $statusCode < 600;
    }
}
