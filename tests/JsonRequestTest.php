<?php
require_once 'src/JsonHelpers/JsonRequest.php';

use JsonHelpers\Request as JSONRequest;

class JsonRequestTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var JSONRequest
   */
  private $jsonRequest;

  public function setUp()
  {
    parent::setUp();

    $this->jsonRequest = new JSONRequest();
  }

  public function testBasicRequest()
  {

    $this->assertInstanceOf("\JsonHelpers\Request", $this->jsonRequest);
  }
}