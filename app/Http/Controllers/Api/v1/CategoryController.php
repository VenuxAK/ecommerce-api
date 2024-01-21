<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\HttpResponse;
use App\Helpers\MediaUploadService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Resources\Categories\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    use HttpResponse, MediaUploadService;

    public function __construct()
    {
        $this->middleware('auth.api.admin')->only(["store", "update", "destroy"]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()     // http://localhost:8000/api/v1/categories?products=10
    {
        return $this->success(
            CategoryResource::collection(Category::with('productTypes')->get()),
            200,
            "categories"
        );
        // return $this->success(CategoriesResource::collection(Category::with('products')->latest()->get()), 200, "categories");
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {

    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // $thumbnail_path = $request->file("thumbnail")->store("/categories", ["disks", "eStore_images"]);
        $file = $this->categoryThumbnailUpload($request->file("thumbnail"));
        if ($file) {
            Category::create([
                "name" => $request->name,
                "slug" => str()->slug($request->name),
                "thumbnail" => $file,
                "description" => $request->description ?? NULL
            ]);

            return $this->responseStatus(201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $category = Category::where("slug", $slug)->first();
        if (!$category) {
            return $this->failed("Category Not Found", 404);
        }
        return $this->success(new CategoryResource($category), 200, "category");
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
        $category = Category::where("slug", $slug)->first();
        if (!$category) {
            return $this->failed("Category Not Found", 404);
        }

        $request->validate([
            "name" => ["string", "min:3", "max:255", Rule::unique('categories', 'name')->ignore($category->id)],
            "description" => []
        ], [
            "name.unique" => "The selected name has already been used."
        ]);

        $category->update([
            "name" => $request->name ?? $category->name,
            "slug" => $request->name ? str()->slug($request->name) : $category->slug,
            "description" => $request->description ?? $category->description
        ]);

        return $this->responseStatus(201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $category = Category::where("slug", $slug)->first();
        if (!$category) {
            return $this->failed("Category Not Found", 404);
        }
        if (count($category->productTypes) > 0) {
            return $this->failed("You can't delete this category.", 406);
        }
        $category->delete();
        return $this->responseStatus(204);
    }
}
