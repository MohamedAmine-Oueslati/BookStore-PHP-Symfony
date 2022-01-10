<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BookListAPI
{
    private $client;

    public function __construct(HttpClientInterface $client, ContainerInterface $container)
    {
        $this->client = $client;
        $this->container = $container;
    }

    public function fetchBookList($title): array
    {
        $apiKey = $this->container->getParameter('apiKey');

        $response = $this->client->request(
            'GET',
            "https://www.googleapis.com/books/v1/volumes?q=$title&key=$apiKey"
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        $books = $content['items'];

        return $books;
    }
}
