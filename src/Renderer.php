<?php

namespace JsonAPI;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

/**
 * JsonRenderer.
 *
 * Render JSON result into a PSR-7 Response object
 */
class Renderer
{
    public function __construct()
    {
        // Create the default top-level members
        $this->data = new \StdClass();
        $this->errors = [];
    }

    /**
     * @param Response $response
     * @param int      $status
     *
     * @return ResponseInterface
     */
    public function render(Response $response, $status = 200)
    {
        // Put the default top-level members into the $result object
        $result = new \StdClass();
        $result->data = $this->data;
        $result->errors = $this->errors;

        return $response->withJson($result, $status);
    }
}
