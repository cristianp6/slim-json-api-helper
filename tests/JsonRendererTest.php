<?php
use JsonHelpers\Renderer as Renderer;

/**
 * @group library
 */
class JsonRendererTest extends \PHPUnit_Framework_TestCase
{


  public function testValidConstuctor()
  {
    $jsonRenderer = new Renderer();

    $this->assertInstanceOf("\JsonHelpers\Renderer", $jsonRenderer);
  }

}
