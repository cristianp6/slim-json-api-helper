<?php

namespace JsonApiHelper;

use Interop\Container\ContainerInterface;
use InvalidArgumentException;

class JsonApiHelper
{
    /**
     * Container.
     *
     * @var ContainerInterface
     */
    private $container;

    /********************************************************************************
     * Constructor
     *******************************************************************************/

    /**
     * Create new application.
     *
     * @param ContainerInterface|array $container Either a ContainerInterface or an
     *                                            associative array of application settings
     *
     * @throws InvalidArgumentException when no container is provided that implements ContainerInterface
     */
    public function __construct($container = null)
    {
        if (!$container instanceof ContainerInterface) {
            throw new InvalidArgumentException('Expected a ContainerInterface');
        }
        $this->container = $container;
    }

    /**
     * register json response result.
     */
    public function registerResponseView()
    {
        $this->container['result'] = function ($c) {
            $result = new JsonApiRenderer();

            return $result;
        };
    }

    /**
     * register all error handler (not found, not allowed, and generic error handler).
     */
    public function registerErrorHandlers()
    {
        $this->container['notAllowedHandler'] = function ($c) {
            return function ($request, $response, $methods) use ($c) {
                $result = new Renderer();

                $result->errors[] = [
                    'code' => 405,
                    'message' => 'Method must be one of: '.implode(', ', $methods),
                ];

                return $result->render($response, 405);
            };
        };

        $this->container['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {
                $result = new Renderer();

                $result->errors[] = [
                    'code' => 404,
                    'message' => 'Not Found',
                ];

                return $result->render($response, 404);
            };
        };

        $this->container['errorHandler'] = function ($c) {
            return function ($request, $response, $exception) use ($c) {
                $result = new Renderer();

                $error_code = $exception->getCode();
                if (is_numeric($error_code) && $error_code > 300 && $error_code < 600) {
                    $error_code = $exception->getCode();
                } else {
                    $error_code = 500;
                }

                if ($c->settings['displayErrorDetails'] === true) {
                    $result->errors[] = [
                        'code' => $error_code,
                        'message' => $exception->getMessage(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'trace' => explode("\n", $exception->getTraceAsString()),
                    ];
                } else {
                    $result->errors[] = [
                        'code' => $error_code,
                        'message' => $exception->getMessage(),
                    ];
                }

                return $result->render($response, $error_code);
            };
        };
    }
}
