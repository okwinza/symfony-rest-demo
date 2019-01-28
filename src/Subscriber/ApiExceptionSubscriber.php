<?php

declare(strict_types=1);

namespace App\Subscriber;


use App\Exception\ApiException;
use App\Exception\ApiProblem;
use App\Exception\GenericApiProblem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    private $supportedEnvs = ['prod'];
    private $apiBasePath = '/api/';
    private $currentEnv;

    public function __construct($currentEnv)
    {
        $this->currentEnv = $currentEnv;
    }

    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 0],
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event) : void
    {
        if (!$this->isProperEnv() || !$this->isApiRequest($event->getRequest())) {
            return;
        }

        $apiProblem = $this->extractProblem($event->getException());

        $response = new JsonResponse(
            $apiProblem->toArray(),
            $apiProblem->getStatusCode()
        );
        $response->headers->set('Content-Type', 'application/problem+json');

        $event->setResponse($response);
    }


    private function extractProblem(\Exception $e) : ApiProblem
    {
        if ($e instanceof ApiException) {
            return $e->getApiProblem();
        }

        return new GenericApiProblem(
            $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500,
            (new \ReflectionClass($e))->getShortName(),
            null
        );
    }

    private function isApiRequest(Request $request) : bool
    {
        return substr($request->getPathInfo(), 0, strlen($this->apiBasePath)) === $this->apiBasePath;
    }

    private function isProperEnv() : bool
    {
        return in_array($this->currentEnv, $this->supportedEnvs);
    }
}