<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryDebitResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoryCollection(Category::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $user = auth()->user();

        DB::transaction(function () use ($request, $user) {
            $category = $user->categories()->create([
               'title' => $request->get('title'),
                'maxValue' => $request->get('maxValue')
            ]);
        });

        return response()->json(status: JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryDebitResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        DB::transaction(function () use($request, $category) {
           $title = $request->get('title', $category->title);
           $maxValue = $request->get('maxValue', $category->maxValue);

           $category->update([
               'title' => $title,
               'maxValue' => $maxValue
           ]);

        });

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
