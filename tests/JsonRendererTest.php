<?php

namespace JsonRendererTest;

use JsonApiHelper\Renderer;
use Slim\Http\Response;

class JsonRendererTest extends \PHPUnit_Framework_TestCase
{
    public function testValidConstuctor()
    {
        $jsonRenderer = new Renderer();

        $this->assertInstanceOf('\JsonApiHelper\Renderer', $jsonRenderer);
    }

    public function testValidResponse()
    {
        $body = ['status' => 'ok'];

        $jsonRenderer = new Renderer();
        $jsonRenderer->data = $body;

        $response = new Response();
        $response = $jsonRenderer->render($response);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getHeaderLine('Content-Type'), 'application/json;charset=utf-8');
        $this->assertTrue($response->getBody() === json_encode($jsonRenderer)); // TODO: response->getBody() is empty!
    }
}
