<?php
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

$routes = require_once __DIR__ . '/../app/routes.php';
$routeCollection = new RouteCollection();
foreach ($routes as $name => $route) {
    $routeCollection->add($name, $route);
}
$request = Request::createFromGlobals();
$context = new RequestContext();
$matcher = new UrlMatcher($routeCollection, $context);
$requestStack = new RequestStack();
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));
$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();
$kernel = new HttpKernel($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
