<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Class ProductsController
 * @package App\Api\V1\Controllers
 */
class ProductsController extends ApiBaseController
{
    protected $token;
    protected $endpoint;

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        $this->token = env('MIX_API_TOKEN');
        $this->endpoint = env('MIX_PACKET_API');
    }

    /**
     * This function will return products listing
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        $page = $request->input('page'); //page number to get particular product listing page
        $limit = $request->input('limit'); // limit number of products per page

        $token = $this->token; // packt token

        $endpoint = $this->endpoint . 'products';
        //create endpoint url to make curl call
        $url = $endpoint . '?page=' . $page . '&&limit=' . $limit . '&&token=' . $token;

        try {
            //curl call
            $products = Http::get($url);

            if ($products->failed()) {
                return response()->json([
                    'status' => 'failure',
                    'data' => []
                ], 200);
            } else {
                //read reesponse from curl call and retrive needed information and create array
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

    /**
     * This function will take productID and return details of that product
     * @param $productID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProduct($productID)
    {
        //endpoint to fetch product details
        $endpoint = $this->endpoint . 'products/' . $productID . '?token=' . $this->token;

        try {
            //curl / http call
            $products = Http::get($endpoint);

            if ($products->failed()) {
                return response()->json([
                    'status' => false,
                    'data' => []
                ], 200);
            } else {
                //retrive and use product details 
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
