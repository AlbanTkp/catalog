<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'page_title'=>'Catégories',
            'categories'=>Category::with('products')->orderBy('name')->get(),
        ];
        return view('pages.categories', $data);
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
    public function store(Request $request)
    {
        for ($i=0; $i < count($request['name']); $i++) {
            $name = $request['name'][$i];
            Category::create(['name'=>strtoupper($name)]);
        }
        session()->flash("alert",[
            "type"=>"success",
            "title"=>"Ajout de carégorie",
            "message"=>"Catégories ajoutée avec succès"
        ]);
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return sendResponse("success", [
            "category"=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category['name'] = $request['name'];
        $category->update();
        return sendResponse("Catégorie modifiée avec succès", [
            "category"=>$category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return sendResponse("Catégorie ".$category->name." supprimée avec succès");
    }
}
