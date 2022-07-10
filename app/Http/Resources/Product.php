<?php

namespace App\Http\Resources;

class Product
{
    /**
     * @param $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function toArray($request)
    {
        $product = $this->resource;
        if ($product['status']) {
            $data = $product['product'];
            $productData['product'] = json_decode($data->body(), true);
            $productData['status'] = count($responseBody) > 0 ? true : false;
            return $productData;
        } else {
            return $product;
        }
    }
}
