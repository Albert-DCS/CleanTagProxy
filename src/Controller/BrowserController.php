<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrowserController extends AbstractController
{
    #[Route('/browser', name: 'app_browser')]
    public function index(Request $request): Response
    {
        // Get the url-encoded url that we want to browse
        $url = urldecode( $request->query->get('p') );

        return $this->render('browser.html.twig',[
            'url_content' => 'you want to see the content of '.$url
        ]);
    }
}
