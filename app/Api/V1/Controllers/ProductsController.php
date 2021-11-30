<?php

namespace App\Api\V1\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

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
     * @param ProductService $productService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request, ProductService $productService)
    {
        $page = $request->input('page'); //page number to get particular product listing page
        $limit = $request->input('limit'); // limit number of products per page

        $endpoint = $this->endpoint . 'products';

        try {
            //curl call
            $products = $productService->getProducts($page, $limit);
            if ($products['status']) {
                $data = $products['products'];
                $responseBody = json_decode($data->body(), true);
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
                    'status' => true,
                    'data' => $productListing,
                    'pageCount' => count($productListing) > 0 ? $lastPage : 0
                ], 200);
            } else {
                return response()->json($products);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * This function will take productID and return details of that product
     * @param $productID
     * @param ProductService $productService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProduct($productID, ProductService $productService)
    {
        try {

            $product = $productService->getProduct($productID);

            if ($product['status']) {
                $data = $product['product'];
                $responseBody = json_decode($data->body(), true);

                $status = count($responseBody) > 0 ? true : false;
                return response()->json([
                    'status' => $status,
                    'data' => $responseBody,
                ], 200);
            } else {
                return response()->json($product);
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
