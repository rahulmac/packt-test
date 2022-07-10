<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Products extends JsonResource
{
    /**
     * @param $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $products = $this->resource;
        if ($products['status']) {
            $data = $products['products'];
            $responseBody = json_decode($data->body(), true);
            $lastPage = $responseBody['last_page'];
            $products = $responseBody['products'];

            $productListing = [];
            $productListing['last_page'] = $lastPage;
            foreach ($products as $product) {
                $item['title'] = $product['title'];
                $item['concept'] = $product['concept'];
                $item['cover'] = config('app.endpoint') . '/' . $product['id'] . '/cover/small?token=' . config('app.token');
                $item['id'] = $product['id'];
                $productListing[] = $item;
            }
            return $productListing;
        } else {
            return $products;
        }

    }
}
