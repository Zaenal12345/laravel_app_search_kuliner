<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\History;
use App\Models\Store;
use App\Http\Resources\APIResource;
use Validator;


class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rating = History::with('stores')->orderBy('id','DESC')->get();
        return new APIResource(true,'List of histories store', $rating);
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
            'store_id'  => 'required',
            'view'    => 'required|numeric',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // check store exist
        $store = Store::find($request->store_id);
        if ($store == null) {
            return new APIResource(false, 'Data store not found', []);
        }

        $data = [
            'store_id' => $request->store_id,
            'view' => $request->view,
        ];
        History::create($data);

        //return response
        return new APIResource(true, 'View success', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showHistory()
    {
        
    }
}
