<?php
require_once(__DIR__ . "/vendor/autoload.php");

use GuzzleHttp\Client as Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class APIClient {

  private $client;
  const API_URL = 'https://api.thecatapi.com/v1/';
  const API_HEADERS =  [
    'Accept' => 'application/json',
    'x-api-key' => 'e13b7f5e-6961-41df-9110-768e0d85b9db',
  ];

  public function __construct() {
    $logger = new Logger('Logger');
    $logger->pushHandler(new StreamHandler(__DIR__ . '/logs.log', Logger::DEBUG));
    $stack = HandlerStack::create();
    $stack->push(
      Middleware::log(
        $logger,
        new MessageFormatter('{uri} - {res_body}')
      )
    );

    $this->client = new Client(
      [
        'base_uri' => self::API_URL,
        'timeout' => 2.0,
        'handler' => $stack
      ]
    );
  }

  public function getBreeds() {
      try {
            return $this->client->request(
              'GET',
              'breeds',
              ['headers' => self::API_HEADERS]
            );
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
					return $e;
        }
    }

    public function getBreedByName(string $name) {
        try {
            return $this->client->request(
              'GET',
              'images/search?breed_ids='.$name,
              ['headers' => self::API_HEADERS]
            );
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
					return $e;
        }
    }

}