<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTypes\StoreProductTypeRequest;
use App\Http\Resources\Products\Types\ProductTypeResource;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductTypeController extends Controller
{

    use HttpResponse;

    public function __construct()
    {
        $this->middleware('auth.api.admin')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productTypes = ProductType::with(['products'])->latest()->get();
        return $this->success(
            ProductTypeResource::collection($productTypes),
            200,
            "product_types"
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductTypeRequest $request)
    {
        $productType = ProductType::create([
            "name" => $request->name,
            "slug" => str()->slug($request->name),
            "category_id" => $request->category_id
        ]);

        return $this->responseStatus(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $productType = ProductType::where("slug", $slug)->first();
        if (!$productType) {
            return $this->failed("Product Type Not Found", 404);
        }
        return $this->success(new ProductTypeResource($productType), 200, "type");
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
        $productType = ProductType::where("slug", $slug)->first();
        if (!$productType) {
            return $this->failed("Product Type Not Found", 404);
        }
        $request->validate([
            "name" => [
                "string", "max:255", Rule::unique('product_types', 'name')->ignore($productType->id)
            ],
            "category_id" => [
                "numeric", Rule::exists('categories', 'id')
            ]
        ], [
            "name.unique" => "The selected name has already exists.",
            "category_id.exists" => "The selected category doesn't exists."
        ]);

        $productType = $productType->update([
            "name" => $request->name ?? $productType->name,
            "slug" => $request->name ? str()->slug($request->name) : $productType->slug,
            "category_id" => $request->category_id ?? $productType->category_id
        ]);

        return $this->responseStatus(201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $productType = ProductType::where("slug", $slug)->first();
        if (!$productType) {
            return $this->failed("Product Type Not Found", 404);
        }

        if (count($productType->products) > 0) {
            return $this->failed("You can't delete this product type", 406);
        } else {
            $productType->delete();
            return $this->responseStatus(204);
        }
    }
}
