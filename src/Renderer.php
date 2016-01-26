<?php

namespace JsonAPI;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

/**
 * JsonRenderer.
 *
 * Render JSON view into a PSR-7 Response object
 */
class Renderer
{
    protected $result;

    public function __construct()
    {
        $this->result = new \StdClass();
        $this->result->data = new \StdClass();
        $this->result->errors = [];
    }

    /**
     * @param Response $response
     * @param int      $status
     *
     * @return ResponseInterface
     */
    public function render(Response $response, $status = 200)
    {
        return $response->withJson($this->result, $status);
    }
}
