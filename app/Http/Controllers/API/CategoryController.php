<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\APIResource;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get and return list of category
        $category = Category::orderBy('id','DESC')->get();
        if ($category == null) {
            $result = [];
        } else {
            $result = $category;
        }
        
        return new APIResource(true, 'List of category', $result);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'category_name'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $category = Category::create([
            'category_name'     => $request->category_name,
        ]);

        $result = $category == true ? $category : null;

        //return response
        return new APIResource(true, 'Category data added successfully', []);

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
            'category_name'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $category = Category::where('id',$id)->update([
            'category_name'     => $request->category_name,
        ]);

        $result = $category == true ? [] : null;

        //return response
        return new APIResource(true, 'Category data updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find data and delete it
        $category = Category::findOrFail($id)->delete();
        $result = $category == true ? [] : null;

        return new APIResource(true, 'Category data deleted successfully', []);

    }
}
