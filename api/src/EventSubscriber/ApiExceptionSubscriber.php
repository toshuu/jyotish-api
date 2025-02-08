<?php

namespace App\EventSubscriber;

use App\Exception\ApiException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    private $logger;
    private $debug;

    public function __construct(LoggerInterface $logger, bool $debug = false)
    {
        $this->logger = $logger;
        $this->debug = $debug;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 0],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        // Only handle JSON API requests
        if (strpos($request->getPathInfo(), '/api') !== 0) {
            return;
        }

        $statusCode = 500;
        $details = [];

        if ($exception instanceof ApiException) {
            $statusCode = $exception->getStatusCode();
            $details = $exception->getDetails();
        } elseif ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
        }

        $data = [
            'status' => $statusCode,
            'message' => $exception->getMessage() ?: $this->getMessageForStatusCode($statusCode),
        ];

        if (!empty($details)) {
            $data['details'] = $details;
        }

        // Add debug information in development
        if ($this->debug) {
            $data['debug'] = [
                'class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ];
        }

        // Log error for 500 and 502 errors
        if ($statusCode >= 500) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception,
                'request_uri' => $request->getUri(),
            ]);
        }

        $response = new JsonResponse($data, $statusCode);
        $event->setResponse($response);
    }

    private function getMessageForStatusCode(int $statusCode): string
    {
        $messages = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            422 => 'Unprocessable Entity',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
        ];

        return $messages[$statusCode] ?? 'An error occurred';
    }
}