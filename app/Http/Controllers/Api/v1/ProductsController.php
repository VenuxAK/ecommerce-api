<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    use HttpResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(
            ProductResource::collection(Product::with('category')->orderBy('id', 'desc')->get()),
            200,
            "products"
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     // return $this->failed("Request not found", 404);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            "name" => $request->name,
            "slug" => str()->slug($request->name),
            "description" => $request->description ?? NULL,
            "price" => $request->price,
            "stock_quantity" => $request->stock_quantity,
            "category_id" => $request->category_id
        ]);
        return $this->success(new ProductResource($product), 201, "product");
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::where("slug", $slug)->first();
        if (!$product) {
            return $this->failed("Product Not Found", 404);
        }
        return $this->success(new ProductResource($product), 200, "product");
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $product = Product::where("slug", $slug)->first();
        if (!$product) {
            return $this->failed("Product Not Found", 404);
        }
        $request->validate([
            "name" => [
                "string", "max:255",
                Rule::unique('products', 'name')->ignore($product->id)
            ],
            "description" => [],
            "price" => ["numeric"],
            "stock_quantity" => ["numeric"],
            "category_id" => ["numeric", Rule::exists('categories', 'id')]
        ], [
            "category_id.exists" => "The selected category doesn't exist."
        ]);
        $product = $product->update([
            "name" => $request->name ?? $product->name,
            "slug" => $request->name ? str()->slug($request->name) : $product->slug,
            "description" => $request->description ?? $product->description,
            "price" => $request->price ?? $product->price,
            "stock_quantity" => $request->stock_quantity ?? $product->stock_quantity,
            "category_id" => $request->category_id ?? $product->category_id,
        ]);

        return $this->responseStatus(201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $slug)
    {
        $product = Product::where("slug", $slug)->first();
        if (!$product) {
            return $this->failed("Product Not Found", 404);
        }
        $product->delete();
        return $this->responseStatus(204);
    }

    private function findProduct($product)
    {
        if (!$product) {
            return $this->failed("Product Not Found", 404);
        }
    }
}
