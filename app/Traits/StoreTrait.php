<?php
namespace App\Traits;

use App\Models\Store;
trait StoreTrait {
    public function createStore($request,$user_id) {
        
        // store data   
        $data = [
            'user_id' => $user_id,
            'store_name' => $request->store_name,
            'address' => $request->address,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];

        // upload image 1
        if ($request->file('picture1')) {
            
            $image = $request->file('picture1');
            $image->storeAs('public/store/', $image->hashName());
            $data['picture1'] = $image->hashName();

        } else {
            $data['picture1'] = "";
        }

        // upload image 2
        if ($request->file('picture2')) {
            
            $image = $request->file('picture2');
            $image->storeAs('public/store/', $image->hashName());
            $data['picture2'] = $image->hashName();
            
        } else {
            $data['picture2'] = "";
        }
        
        // upload image 2
        if ($request->file('picture3')) {
            
            $image = $request->file('picture3');
            $image->storeAs('public/store/', $image->hashName());
            $data['picture3'] = $image->hashName();

        } else {
            $data['picture3'] = "";
        }

        Store::create($data);
    
    }
}