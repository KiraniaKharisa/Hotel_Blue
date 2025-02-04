<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard/categories/index', [
            'title' => "Category Rooms Data",
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard/categories/create', [
            'title' => "Create Category Rooms Data"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validData = $request->validate([
            'name' => ['required', 'max:100', Rule::unique('categories', 'name')],
            'class_category' => ['required', 'max:10', 
                Rule::unique('categories', 'class_category')->where(function ($query) use ($request) {
                    return $query->whereRaw('LOWER(class_category) = ?', [strtolower($request->class_category)]);
                }),
            ],
        ]);


        $validData['class_category'] = strtoupper($validData['class_category']);

        Category::create($validData);

        return redirect()->route('categories.index')->with('succes', 'Room category data successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard/categories/edit', [
            'title' => "Edit Category Rooms Data",
            'category' => Category::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        $validData = $request->validate([
            'name' => ['required', 'max:100', 'unique:categories,name,'.$category->id],
            'class_category' => ['required', 'max:10', 
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query
                        ->whereRaw('LOWER(class_category) = ?', [strtolower($request->class_category)])
                        ->where('id', '!=', $category->id); // Abaikan ID sendiri
                }),
            ],
        ]);

        $validData['class_category'] = strtoupper($validData['class_category']);

        $category->update($validData);

        return redirect()->route('categories.index')->with('succes', 'Room category data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Category::find($id)->delete();

        // return redirect()->route('categories.index')->with('succes', 'Room category data successfully deleted');

        try {
            $category = Category::findOrFail($id);
    
            // Cek apakah kategori masih digunakan di tabel room lain
            if ($category->room()->exists()) {
                return redirect()->route('categories.index')->with('error', 'Room category cannot be deleted because it is still associated with rooms.');
            }
    
            $category->delete();
    
            return redirect()->route('categories.index')->with('succes', 'Room category successfully deleted.');
        } catch (\Exception $error) {
            return redirect()->route('categories.index')->with('error', 'An error occurred while deleting the category.');
        }
    }
}