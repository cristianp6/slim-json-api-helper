<?php

namespace JsonRendererTest;

use JsonAPI\Renderer as Renderer;
use Slim\Http\Response;

class JsonRendererTest extends \PHPUnit_Framework_TestCase
{
    public function testValidConstuctor()
    {
        $jsonRenderer = new Renderer();

        $this->assertInstanceOf('\JsonAPI\Renderer', $jsonRenderer);
    }

    public function testValidResponse()
    {
        $body = ['status' => 'ok'];
        $jsonRenderer = new Renderer();
        $jsonRenderer->data = $body;

        $response = new Response();
        $response = $jsonRenderer->render($response, 200);

        $result = new \StdClass();
        $result->data = $body;
        $result->errors = [];

        $this->assertTrue($response->getStatusCode() === 200);
        $this->assertTrue($response->getBody() === json_encode($result));
    }
}
