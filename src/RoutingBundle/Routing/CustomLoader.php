<?php
namespace RoutingBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CustomLoader extends Loader
{
    public const CONTROLLER = 'RoutingBundle:Custom:forward';
    public const ROUTE_NAME = 'customRoute';
    protected const TYPE = 'custom';

    protected $loaded = false;

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "' . self::TYPE . '" loader twice');
        }

        $routes = new RouteCollection();

        // prepare a new route
        $pattern = '/{path}';
        $defaults = [
            '_controller' => self::CONTROLLER
        ];
        $requirements = [
            'path' => '.+'
        ];
        $route = new Route($pattern, $defaults, $requirements);

        // add the new route to the route collection
        $routes->add(self::ROUTE_NAME, $route);

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return self::TYPE === $type;
    }
}