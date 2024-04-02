<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use voku\helper\HtmlMin;
use Symfony\Component\HttpFoundation\RequestStack;

class BrowserController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    // Remove all the occurences of tag $tag if they contain string $criteria
    private function removeTagIfContains($html, $startTag, $endTag, $criteria): String {
        $tempContent = $html;
        $startScript = 0;
        while ( strpos($tempContent, $startTag, $startScript) ) {
            $startScript = strpos($tempContent, $startTag, $startScript);   // Get the position where the script starts
            $scriptContent = substr($tempContent, $startScript);            // Cut the string where script starts
            $endScript = strpos($scriptContent, $endTag);                  // Get the position where the script ends
            $scriptContent = substr($scriptContent, 0, $endScript + 9);       // Cut the string where the script ends
            $startScript++;
            if ( strpos($scriptContent, $criteria) ) {
                $html = str_replace($scriptContent, '', $html); // Remove the script from the page
            }
        }
        return $html;
    }

    #[Route('/{slug}', name: 'app_index', requirements: ['slug'=>'.*'])]
    public function index($slug): Response
    {
        // Create the http client
        $httpClient = HttpClient::create();
        $baseUrl = 'https://premiertablelinens.com/';

        // Make the HTTP request to fetch the content
        $response = $httpClient->request('GET', $baseUrl . $slug);

        // Get the content of the response
        $content = $response->getContent();

        // We will store the cleaned html in a new variable
        $cleanContent = $content;

        // Minify HTML content
        $htmlMinifier = new HtmlMin();
        $cleanContent = $htmlMinifier->minify($cleanContent);

        // Let's remove all the script and style tags that were injected by WholeSale AllInOne app
        $cleanContent = $this->removeTagIfContains($cleanContent, '<script', '</script', 'WSAIO.');
        $cleanContent = $this->removeTagIfContains($cleanContent, '<script', '</script', '.wsaio');

        // Directly return the HTML
        $response = new Response($cleanContent);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }
}
