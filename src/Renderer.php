<?php
namespace JsonHelpers;

use \Psr\Http\Message\ResponseInterface;

/**
 * JsonRenderer
 *
 * Render JSON view into a PSR-7 Response object
 */
class Renderer
{
  /**
   *
   * @param ResponseInterface $response
   * @param int $statusCode
   * @param array $data
   *
   * @return ResponseInterface
   *
   * @throws \InvalidArgumentException
   * @throws \RuntimeException
   */
  public function render(ResponseInterface $response, $statusCode = 200, array $data = [])
  {
    $newResponse = $response->withHeader('Content-Type', 'application/json');
    $newResponse = $newResponse->withStatus($statusCode);
    $newResponse->getBody()->write(json_encode($data));

    return $newResponse;
  }
}