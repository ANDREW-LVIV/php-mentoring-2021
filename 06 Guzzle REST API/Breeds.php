<?php


class Breeds extends Base
{
    public function getBreeds() {
        return $client->request(
          'GET',
          $word_id,
          ['headers' => $headers]
        );
    }

}