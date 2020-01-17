<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
    public function get() {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }
}
