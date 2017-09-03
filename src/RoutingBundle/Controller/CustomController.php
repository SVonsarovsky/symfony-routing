<?php

namespace RoutingBundle\Controller;

use RoutingBundle\Routing\CustomLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomController extends Controller
{
    protected $path;
    protected $bundle;
    protected $controller;
    protected $action;

    public function forwardAction(string $path, Request $request): Response
    {
        $this->processPath($path);

        return $this->getResponse();
    }

    protected function getResponse(): Response
    {
        $controller = $this->getForwardController();
        if ($controller == CustomLoader::CONTROLLER) {
            throw new NotFoundHttpException();
        }

        return $this->forward($controller, [
            'path' => $this->path,
        ]);
    }

    protected function processPath(string $path): void
    {
        $this->path = strtolower(preg_replace("/[\/]+$/", '', $path));
        $pathSegments = explode('/', $this->path);
        if (count($pathSegments) != 3) {
            throw new NotFoundHttpException();
        }

        $this->bundle = ucfirst($pathSegments[0]);
        $this->controller = ucfirst($pathSegments[1]);
        $this->action = $pathSegments[2];
    }

    protected function getForwardController()
    {
        $class = "{$this->bundle}Bundle\\Controller\\{$this->controller}Controller";
        if (!(class_exists($class) && method_exists(new $class, "{$this->action}Action"))) {
            throw new NotFoundHttpException();
        }

        return "{$this->bundle}Bundle:{$this->controller}:{$this->action}";
    }
}
