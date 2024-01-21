<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\HttpResponse;
use App\Helpers\MediaUploadService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    use HttpResponse, MediaUploadService;

    public function __construct()
    {
        $this->middleware(['auth.api.admin'])->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(
            ProductResource::collection(
                Product::with(['productType', 'images'])->filter(request([
                    "search", "latest", "recommanded", "price", "min_price", "max_price", "related", "limit"
                ]))->get()
            ),
            200,
            "products"
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        if ($request->hasFile("images")) {
            if ($this->productImagesUpload($request->file("images"))) {
                // if ($request->file('thumbnail')) {
                // $file = $request->file('thumbnail');
                // $extension = $file->getClientOriginalExtension();
                // $check = in_array($extension, $this->allowedFileExtension);
                // if (!$check) {
                //     return $this->failed(["errors" => "Invalid file format"], 422);
                // }
                // $file_path = $file->store("/products/thumbnails", ["disks" => "eStore_images"]);
                // Fix later
                // thumbnail photo duplicate
                // "thumbnail" => $file_path,
                // }
                $product = Product::create([
                    "name" => $request->name,
                    "slug" => str()->slug($request->name),
                    "description" => $request->description ?? NULL,
                    "price" => $request->price,
                    "stock_quantity" => $request->stock_quantity,
                    "product_type_id" => $request->product_type_id
                ]);

                foreach ($request->images as $photo) {
                    $file = $photo->store("/products", ["disks" => "eStore_images"]);
                    ProductImage::create([
                        "image_path" => $file,
                        "product_id" => $product->id
                    ]);
                }
                return $this->responseStatus(201);
            } else {
                return $this->failed(["errors" => "Invalid file format"], 422);
            }
        } else {
            return $this->success("NO_FILE_FOUND", 200);
        }
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
                "required", "string", "max:255",
                Rule::unique('products', 'name')->ignore($product->id)
            ],
            "description" => ["required"],
            "price" => ["required", "numeric"],
            "stock_quantity" => ["required", "numeric"],
            "product_type_id" => ["required", "numeric", Rule::exists('product_types', 'id')]
        ], [
            "product_type_id.exists" => "The selected product type doesn't exist."
        ]);
        $product = $product->update([
            "name" => $request->name ?? $product->name,
            "slug" => $request->name ? str()->slug($request->name) : $product->slug,
            "description" => $request->description ?? $product->description,
            "price" => $request->price ?? $product->price,
            "stock_quantity" => $request->stock_quantity ?? $product->stock_quantity,
            "product_type_id" => $request->product_type_id ?? $product->product_type_id,
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
}
