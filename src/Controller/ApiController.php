<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'api')]
    public function apiAction(Request $request): Response
    {
        return $this->json([
            'message' => 'Welcome to your new API endpoint!',
            'path' => '/api',
        ]);
    }
}
