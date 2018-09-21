<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;

return [
    'home' => new Route('/', ['_controller' => function(Request $request) {
        return new Response('<a href="/foo/baz?you=are%20awesome">/foo/baz</a>');
    }]),
    'foo' => new Route('/foo/{bar}', ['_controller' => function(Request $request) {
        $queryParams = [];
        parse_str($request->getQueryString(), $queryParams);
        return new Response(
            '<pre>' .
            'This is the "bar" part in your URL: ' . $request->attributes->get('bar') . "\n" .
            'This is the query part: ' . print_r($queryParams, true) .
            '</pre>'
        );
    }]),
];
