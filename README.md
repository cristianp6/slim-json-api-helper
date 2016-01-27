slim-json-api-helper
=======


## Requirements ##

* PHP >= 5.5


## Usage ##

```php

use Slim\Http\Request as Request;
use JsonApiHelper\Renderer;

$app = new \Slim\App($settings);
$container = $app->getContainer();

// register the json response and error handlers
$jsonApiHelper = new JsonApiHelper\JsonApiHelper($app->getContainer());
$jsonApiHelper->registerResponseView();
$jsonApiHelper->registerErrorHandlers();


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
