<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PrintifyService
{
    public function getShops(): array
    {
        $response = Http::withToken(config('services.printify.api_token'))
            ->get('https://api.printify.com/v1/shops.json');

        return $response->json();
    }

    public function getProducts(): array
    {
        $shopId = config('services.printify.shop_id');
        $response = Http::withToken(config('services.printify.api_token'))
            ->get("https://api.printify.com/v1/shops/{$shopId}/products.json");

        return $response->json();
    }
}
