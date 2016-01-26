slim-json-api
=======


## Requirements ##

* PHP >= 5.5


## Usage ##

```php

use Slim\Http\Request as Request;
use JsonAPI\Renderer as JsonRenderer;

$app = new \Slim\App($settings);
$container = $app->getContainer();

// register the json response and error handlers
$jsonAPI = new JsonAPI\JsonAPI($app->getContainer());
$jsonAPI->registerResponseView();
$jsonAPI->registerErrorHandlers();


$this->post('/users', function (Request $request, Response $response, $args)
{
    $user_id = $request->getParam('user_id');

    $this->result->data = [
        'user_id' => $user_id
    ];

    $response = $this->result->render($response, 200);
    return $response;

  });
}
```
