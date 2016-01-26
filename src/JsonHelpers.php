<?php

namespace JsonAPI;

use Interop\Container\ContainerInterface;
use JsonAPI\Renderer as JsonRenderer;
use InvalidArgumentException;

class JsonHelpers
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
     * register json response view.
     */
    protected function registerResponseView()
    {
        $this->container['result'] = function ($c) {
            $result = new JsonRenderer();

            return $result;
        };
    }

    /**
     * register all error handler (not found, not allowed, and generic error handler).
     */
    protected function registerErrorHandlers()
    {
        $this->container['notAllowedHandler'] = function ($c) {
            return function ($request, $response, $methods) use ($c) {

                $result = new JsonRenderer();

                $result->errors[] = [
                    'code' => 405,
                    'message' => 'Method must be one of: '.implode(', ', $methods),
                ];

                return $result->render($response, 405);
            };
        };

        $this->container['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {
                $result = new JsonRenderer();

                $result->errors[] = [
                    'code' => 404,
                    'message' => 'Not Found',
                ];

                return $result->render($response, 404);
            };
        };

        $this->container['errorHandler'] = function ($c) {
            return function ($request, $response, $exception) use ($c) {

                $settings = $c->settings;
                $result = new JsonRenderer();

                $error_code = 500;
                if (is_numeric($exception->getCode()) && $exception->getCode() > 300  && $exception->getCode() < 600) {
                    $error_code = $exception->getCode();
                }

                if ($settings['displayErrorDetails'] === true) {
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
