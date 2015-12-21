slim-json-helpers
=======

[![Latest Stable Version](https://poser.pugx.org/aporat/slim-json-helpers/version.png)](https://packagist.org/packages/aporat/slim-json-helpers)
[![Composer Downloads](https://poser.pugx.org/aporat/slim-json-helpers/d/total.png)](https://packagist.org/packages/aporat/slim-json-helpers)
[![Build Status](https://travis-ci.org/aporat/slim-json-helpers.png?branch=master)](https://travis-ci.org/aporat/slim-json-helpers)
[![Code Coverage](https://scrutinizer-ci.com/g/aporat/slim-json-helpers/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/aporat/slim-json-helpers/?branch=master)
[![License](https://poser.pugx.org/aporat/slim-json-helpers/license.svg)](https://packagist.org/packages/aporat/slim-json-helpers)


## Requirements ##

* PHP >= 5.5


## Usage ##

```php

use JsonHelpers\Request as JsonRequest;
use JsonHelpers\Renderer as JsonRenderer;

$container = $app->getContainer();

$container['view'] = function ($c) {
  $view = new JsonRenderer();

  return $view;
};

$container['jsonRequest'] = function ($c) {
  $jsonRequest = new JsonRequest();

  return $jsonRequest;
};

$container['notAllowedHandler'] = function ($c) {
  return function ($request, $response, $methods) use ($c) {

    $view = new JsonRenderer();
    return $view->render($response, 405,
        ['error_code' => 'not_allowed', 'error_message' => 'Method must be one of: ' . implode(', ', $methods)]
    );

  };
};

$container['notFoundHandler'] = function ($c) {
  return function ($request, $response) use ($c) {
    $view = new JsonRenderer();

    return $view->render($response, 404, ['error_code' => 'not_found', 'error_message' => 'Not Found']);
  };
};

$container['errorHandler'] = function ($c) {
  return function ($request, $response, $exception) use ($c) {

    $settings = $c->settings;
    $view = new JsonRenderer();

    $errorCode = 500;
    if (is_numeric($exception->getCode()) && $exception->getCode() > 300  && $exception->getCode() < 600) {
      $errorCode = $exception->getCode();
    }

    if ($settings['displayErrorDetails'] == true) {
      $data = [
          'error_code' => $errorCode,
          'error_message' => $exception->getMessage(),
          'file' => $exception->getFile(),
          'line' => $exception->getLine(),
          'trace' => explode("\n", $exception->getTraceAsString()),
      ];
    } else {
      $data = [
          'error_code' => $errorCode,
          'error_message' => $exception->getMessage()
      ];
    }

    return $view->render($response, $errorCode, $data);
  };
};

$this->post('/users', function (Request $request, Response $response, $args)
{
  $jsonRequest = $this->jsonRequest->setRequest($request);

  $user_id = $jsonRequest->getRequestParam('user_id');
  
   $data = [
        'user_id' => $user_id
    ];

    $response = $this->view->render($response, 200, $data);
    return $response;

  });
}
```
