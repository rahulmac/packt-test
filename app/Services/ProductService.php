<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

/**
 * Class ProductService
 * @package App\Services\
 */
class ProductService
{
    protected $token;
    protected $endpoint;

    /**
     * ProductService constructor.
     */
    public function __construct()
    {
        $this->token = env('MIX_API_TOKEN');
        $this->endpoint = env('MIX_PACKET_API');
    }

    /**
     * service method that takes page no and limit and returns product listing accrodingly
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getProducts($page = 1, $limit = 8)
    {


        $token = $this->token; // packt token

        $endpoint = $this->endpoint . 'products';
        //create endpoint url to make curl call
        $url = $endpoint . '?page=' . $page . '&&limit=' . $limit . '&&token=' . $token;

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
     * service function that will return product details using productID
     * @param $productID
     * @return array
     */
    public function getProduct($productID)
    {

        $endpoint = $this->endpoint . 'products/' . $productID . '?token=' . $this->token;

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
