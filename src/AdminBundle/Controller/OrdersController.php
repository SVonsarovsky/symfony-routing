<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class OrdersController extends AbstractController
{
    public function viewAction(string $path): Response
    {
        return new Response($path);
    }
}
