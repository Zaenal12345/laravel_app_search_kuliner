<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use App\Http\Resources\APIResource;
use Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with('categories')->orderBy('id','DESC')->get();
        return new APIResource(true,'List of product', $product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'picture'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id'   => 'required',
            'product_name'  => 'required',
            'price'         => 'required|numeric',
            'status'        => 'required',
            'description'   => 'required',
            'store_id'      => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        // check category exist
        $category = Category::find($request->category_id);
        if ($category == null) {
            return new APIResource(false, 'Data category not found', []);
        }
        
        // check store exist
        $store = Store::find($request->store_id);
        if ($store == null) {
            return new APIResource(false, 'Data store not found', []);
        }

        //upload image
        $image = $request->file('picture');
        $image->storeAs('public/product/', $image->hashName());

        //create post
        Product::create([
            'category_id'   => $request->category_id,
            'product_name'  => $request->product_name,
            'price'         => $request->price,
            'description'   => $request->description,
            'status'        => $request->status,
            'picture'       => $image->hashName(),
            'store_id'      => $request->store_id
        ]);

        //return response
        return new APIResource(true, 'Product data added successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //define validation rules
         $validator = Validator::make($request->all(), [
            'picture'       => 'image|mimes:jpeg,png,jpg|max:2048',
            'category_id'   => 'required',
            'product_name'  => 'required',
            'price'         => 'required|numeric',
            'status'        => 'required',
            'description'   => 'required',
            'store_id'      => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        // check category exist
        $category = Category::find($request->category_id);
        if ($category == null) {
            return new APIResource(false, 'Data category not found', []);
        }

        $data = [
            'category_id'     => $request->category_id,
            'product_name'     => $request->product_name,
            'price'     => $request->price,
            'description'     => $request->description,
            'status'     => $request->status,
            'store_id'      => $request->store_id
        ];

        if ($request->file('picture')) {

            //upload image
            $image = $request->file('picture');
            $image->storeAs('public/product', $image->hashName());
            $data['picture'] = $image->hashName();

            // delete old image
            $old_data = Product::findOrFail($id);
            Storage::delete('public/product/'.$old_data->picture);

        }


        //update post
        Product::where('id',$id)->update($data);

        //return response
        return new APIResource(true, 'Product data updated successfully', []);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product != null) {
            Storage::delete('public/product/'.$product->picture);
            $product->delete();
            $result = $product == true ? $product : null;

            //return response
            return new APIResource(true, 'Product data deleted successfully', []);
        }else{

            return new APIResource(false, 'Data product not found', []);

        }

    }
}
