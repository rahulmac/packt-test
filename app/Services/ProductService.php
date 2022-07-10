<?php


namespace App\Services;


use App\Http\Validators\ProductValidator;
use Illuminate\Support\Facades\Http;

/**
 * Class ProductService
 * @package App\Services\
 */
class ProductService
{

    /**
     * service method that takes page no and limit and returns product listing accrodingly
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getProducts(ProductValidator $productValidator)
    {


        $token = config('app.token'); // packt token

        $endpoint = config('app.endpoint') . 'products';
        //create endpoint url to make curl call
        $url = $endpoint . '?page=' . $productValidator->getPage() . '&&limit=' . $productValidator->getLimit() . '&&token=' . $token;

        try {
            //curl call
            $products = Http::get($url);

            if ($products->failed()) {
                return ['status' => false, 'messages' => 'error occurred'];
            } else {
                //read reesponse from curl call and retrive needed information and create array
                return ['status' => true, 'products' => $products];
            }
        } catch (\Exception $e) {
            // send error exception from here

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * @param string $productID
     * @return array
     */
    public function getProduct(string $productID)
    {

        $endpoint = config('app.endpoint') . 'products/' . $productID . '?token=' . config('app.token');

        try {
            //curl / http call
            $product = Http::get($endpoint);

            if ($product->failed()) {
                return ['status' => false, 'messages' => 'error occurred'];
            } else {
                return ['status' => true, 'product' => $product];
            }
        } catch (\Exception $e) {
            // send error exception from here

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
