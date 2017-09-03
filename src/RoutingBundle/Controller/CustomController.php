<?php

namespace RoutingBundle\Controller;

use ReflectionClass;
use RoutingBundle\Routing\CustomLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomController extends Controller
{
    protected $path;
    protected $bundle;
    protected $controller;
    protected $action;

    public function forwardAction(string $path): Response
    {
        $this->processPath($path);

        return $this->getResponse();
    }

    protected function getResponse(): Response
    {
        $controller = $this->getForwardController();
        if ($controller == CustomLoader::CONTROLLER) {
            throw $this->createNotFoundException();
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
            throw $this->createNotFoundException();
        }

        $this->bundle = ucfirst($pathSegments[0]);
        $this->controller = ucfirst($pathSegments[1]);
        $this->action = $pathSegments[2];
    }

    protected function getForwardController(): string
    {
        $class = "{$this->bundle}Bundle\\Controller\\{$this->controller}Controller";
        if (class_exists($class)) {
            $reflector = new ReflectionClass($class);
            if (!$reflector->isAbstract() && $reflector->hasMethod("{$this->action}Action")) {
                return "{$this->bundle}Bundle:{$this->controller}:{$this->action}";
            }
        }

        throw $this->createNotFoundException();
    }
}
