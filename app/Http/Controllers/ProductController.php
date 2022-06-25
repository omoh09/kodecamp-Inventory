<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            //$data = ProductResource::collection(Product::all());
            $data = Product::all();

            return response()->json([
                'message' => 'success!',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
                return $e->getMessage();
        }
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
        $request->validate([
            'name' => 'required|unique:products|max:255',
            'price' => 'required|int',
            'quantity' => 'required|int',
            'description' => 'required',
        ]);
        
        $product = Product::create([
            'name' => $request->name,
            'ItemNumber' => $this->quickRandom(),
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description
        ]);
        
        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            $url  = cloudinary()->upload($files->getRealPath(),['folder' => 'leo'])->getSecurePath();
            if($url){
                $file = $product->files()->create([
                    'project_id' => $product->id,
                    'url' => $url
                ]);
            }
        }
        
        return response()->json([
            'message' => 'success',
            'data' => $product
        ]);      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::find($id);

        return response()->json([
            'message' => 'success!',
            'data' => $data
        ], 200);
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
        $data = Product::findOrFail($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->save();

        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            $url  = cloudinary()->upload($files->getRealPath(),['folder' => 'leo'])->getSecurePath();
            
            if($url){
                $file = $data->files()->update([
                    'url' => $url
                ])->whereId($id);
            }
        }

        return response()->json([
            'message' => 'successfully updated!',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ], 200);
    }

    protected function quickRandom($length = 9)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
