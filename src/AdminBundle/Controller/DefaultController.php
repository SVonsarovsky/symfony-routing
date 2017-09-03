<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function viewAction(string $path, Request $request): Response
    {
        dump($request->headers);

        return new Response($path);
    }

    public function testAction(string $path): Response
    {
        return new Response($path);
    }
}
