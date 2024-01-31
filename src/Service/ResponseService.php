<?php

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ResponseService
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getKeyFromResponse($url, $requireStatus, $requireContentType, $requireKey)
    {
        $response = $this->client->request(
            'GET',
            $url
        );

        $status = $response->getStatusCode();
        if ($status != $requireStatus) {
            echo "$url - your status code: $status change url, current $requireKey: default  \n";
            return false;
        }

        $contentType = $response->getHeaders()['content-type'][0];
        if ($contentType != $requireContentType) {
            echo $url . "  $contentType - incorrect format of content type, change url at admin panel, current $requireKey: default \n";
            return false;
        }

        $content = $response->toArray();
        if (array_key_exists($requireKey, $content) != true) {
            echo $url . "   key $requireKey doesnt exist , current $requireKey: default \n";
            return false;
        }

        return $content[$requireKey];
    }

}