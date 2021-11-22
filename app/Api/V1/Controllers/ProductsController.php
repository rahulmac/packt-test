<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductsController extends ApiBaseController
{
    protected $token;
    protected $endpoint;

    public function __construct()
    {
        $this->token = env('MIX_API_TOKEN');
        $this->endpoint = env('MIX_PACKET_API');
    }

    public function getProducts(Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit');

        $token = $this->token;

        $endpoint = $this->endpoint . 'products';
        $url = $endpoint . '?page=' . $page . '&&limit=' . $limit . '&&token=' . $token;

        try {
            $products = Http::get($url);

            if ($products->failed()) {
                return response()->json([
                    'status' => 'failure',
                    'data' => []
                ], 200);
            } else {
                $responseBody = json_decode($products->body(), true);
                $lastPage = $responseBody['last_page'];
                $products = $responseBody['products'];

                $productListing = [];
                foreach ($products as $product) {
                    $item['title'] = $product['title'];
                    $item['concept'] = $product['concept'];
                    $item['cover'] = $endpoint . '/' . $product['id'] . '/cover/small?token=' . $this->token;
                    $item['id'] = $product['id'];
                    $productListing[] = $item;
                }
                return response()->json([
                    'status' => 'success',
                    'data' => $productListing,
                    'pageCount' => count($productListing) > 0 ? $lastPage : 0
                ], 200);
            }
        } catch (\Exception $e) {
            // send error exception from here

            return response()->json([
                'status' => 'error',
                'data' => [],
                'error' => $e->getMessage()
            ], 200);
        }
    }

    public function getProduct($productID)
    {
        $endpoint = $this->endpoint . 'products/' . $productID . '?token=' . $this->token;

        try {
            $products = Http::get($endpoint);

            if ($products->failed()) {
                return response()->json([
                    'status' => false,
                    'data' => []
                ], 200);
            } else {
                $responseBody = [];
                $responseBody = json_decode($products->body(), true);

                $status = count($responseBody) > 0 ? true : false;
                return response()->json([
                    'status' => $status,
                    'data' => $responseBody,
                ], 200);
            }
        } catch (\Exception $e) {
            // send error exception from here

            return response()->json([
                'status' => 'error',
                'data' => [],
                'error' => $e->getMessage()
            ], 200);
        }
    }
}
