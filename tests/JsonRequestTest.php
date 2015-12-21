<?php
use JsonHelpers\Request as JsonRequest;

/**
 * @group library
 */
class JsonRequestTest extends \PHPUnit_Framework_TestCase
{


  public function testValidConstuctor()
  {
    $jsonRequest = new JsonRequest();

    $this->assertInstanceOf("\JsonHelpers\Request", $jsonRequest);
  }

}
