<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractController extends Controller
{
    public function __construct(RequestStack $requestStack = null)
    {
        $request = $requestStack->getCurrentRequest();
        if ($request->headers->get('admin') !== 'test') {
            throw new HttpException(401, 'You cannot access this page!');
        }
    }
}
