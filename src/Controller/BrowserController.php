<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrowserController extends AbstractController
{
    #[Route('/browser', name: 'app_browser')]
    public function index(): Response
    {
        return $this->render('browser.html.twig');
    }
}
