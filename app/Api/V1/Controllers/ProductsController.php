<?php

namespace App\Api\V1\Controllers;

use App\Http\Resources\Product;
use App\Http\Resources\Products;
use App\Http\Responses\Product\FailureResponse;
use App\Http\Responses\Product\SuccessResponse;
use App\Http\Validators\ProductValidator;
use App\Services\ProductService;
use Illuminate\Http\Request;

/**
 * Class ProductsController
 * @package App\Api\V1\Controllers
 */
class ProductsController extends ApiBaseController
{

    /**
     * @param Request $request
     * @param ProductService $productService
     * @param ProductValidator $productValidator
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getProducts(Request $request, ProductService $productService, ProductValidator $productValidator)
    {

        $validateRequest = $productValidator->setRequest($request)->setFromRequest()->validateRequest();
        if (is_array($validateRequest)) {
            return FailureResponse::handleValidation($validateRequest);
        }
        try {
            return  SuccessResponse::response(Products::make($productService->getProducts($productValidator))->resolve());

        } catch (\Exception $e) {
            return FailureResponse::handleException($e->getMessage());
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
           return SuccessResponse::response(Product::make($productService->getProduct($productID))->resolve());
        } catch (\Exception $e) {
            return FailureResponse::handleException($e->getMessage());
        }
    }
}
