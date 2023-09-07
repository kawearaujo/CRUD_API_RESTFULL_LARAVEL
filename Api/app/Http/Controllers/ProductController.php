<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'products' => $products
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();

            Product::create([
                'name' =>$request->name,
                'image' => $imageName,
                'description' => $request->description,
            ]);

            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            return response()->json([
                'message'=> "Produto adicionado com Sucesso!"
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message'=> "Aconteceu algo de errado!"
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::find($id);
        if(!product){
            return response()->json([
                'message'=>'Product Not Found'
            ],404);
        }
        return response()->json([
            'product'=> $product
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, string $id)
    {
        try {
            $product = Product::find($id);
            if(!$product){
                return response()->json([
                    'message' =>'Produto não encontrado.'
                ],404);
            }
            echo "request : $request->name";
            echo "description : $request->description";
            $product->name = $request->name;
            $product->description = $request->description;

            if($request->image){
                $storage = Storage::disk('public');

                if($storage->exists($product->image))
                    $storage->delete($product->image);

                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                $product->image = $imageName;
            }

            $product->save();

            return response()->json([
                'message'=>"Produto atualizado com sucesso"
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>"Aconteceu algo de errado!"
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'message'=>'Produto não encontrado'
            ],404);
        }
        $storage = Storage::disk('public');

        if($storage->exists($product->image))
            $storage->delete($product->image);
        $product->delete();
        return response()->json([
            'message'=>"O produto foi deletado com sucesso!"
        ],200);
    }
}
