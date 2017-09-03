<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    public function viewAction(string $path, Request $request)
    {
        dump($request->headers);

        return new Response($path);
    }
}
