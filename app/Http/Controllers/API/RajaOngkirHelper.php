<?php

namespace App\Http\Controllers\API;

use GuzzleHttp\Client;

trait RajaOngkirHelper {

    function createClient() {
        return new Client([
            'base_uri' => 'https://pro.rajaongkir.com/api/',
            'headers' => [
                "key" => env('RAJAONGKIR_API_KEY'),
                "Content-Type" => "application/x-www-form-urlencoded"
            ]
        ]);
    }
}