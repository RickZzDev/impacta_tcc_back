<?php

namespace App\Http\Controllers;

use App\Http\Resources\DebitCollection;
use App\Http\Resources\DebitResource;
use App\Models\Category;
use App\Models\Debit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        return new DebitCollection($category->debits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category)
    {
        DB::transaction(function () use ($request, $category) {
           $debit = $category->debits()->create([
               'title' => $request->get('title'),
               'value' => $request->get('value')
           ]);
        });

        return response()->json(status: JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, Debit $debit)
    {
        return new DebitResource($category->debits()->find($debit->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, Debit $debit)
    {
        DB::transaction(function () use($request, $category, $debit){
           $title = $request->get('title', $debit->title);
           $value = $request->get('value', $debit->value);

           $category->debits()->update([
               'title' => $title,
               'value' => $value
           ]);
        });

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Debit $debit)
    {
        $debit->delete();

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
