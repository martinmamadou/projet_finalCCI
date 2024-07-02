<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExerciseApiService
{
    private HttpClientInterface $client;
    private string $apiKey = '09c1e08947mshff274454c6424c8p18336bjsn5884bb3df1f5' ;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchExercises(): array
    {
        $response = $this->client->request(
            'GET',
            'https://exercisedb.p.rapidapi.com/exercises?limit=100&offset=0',
            [
                'headers' => [
                    'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
                    'X-RapidAPI-Key' => $this->apiKey,
                ],
            ]
        );

        return $response->toArray();
    }
}
