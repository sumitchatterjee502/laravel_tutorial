<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Services\ProductServices;
use Validator;


class ProductController extends BaseController
{
    private ProductServices $ProductServices;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ProductServices $ProductServices){
        $this->ProductServices = $ProductServices;
    }
    public function index()
    {   
        $responseData = $this->ProductServices->fetchAllProduct();
        return $this->sendResponse($responseData);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validator = $request->all();
        $responseData = $this->ProductServices->storeProduct($validator);
        return $this->sendResponse($responseData);
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $responseData = $this->ProductServices->showProducts($id);
        return $this->sendResponse($responseData);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $input = $request->all();
        //print_r($id);die();
        //print_r($request);die();

        $responseData = $this->ProductServices->updateProducts($input, $id);
        print_r($responseData);die();
     
        // $validator = Validator::make($input, [
        //     'name' => 'required',
        //     'detail' => 'required'
        // ]);
     
        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }
     
        // $product->name = $input['name'];
        // $product->detail = $input['detail'];
        // $product->save();
     
        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
     
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
