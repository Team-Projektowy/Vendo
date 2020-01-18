<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Image;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Image as ImageResource;


class CategoryController extends Controller
{
    public function get() {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function getImages() {
        $categories = CategoryResource::collection((Category::all()));
        $images = [];
        for ($i = 1; $i <= $categories->count(); $i++) {
            $image = Image::where("category", strval($i))->get();
            array_push($images, ImageResource::collection($image)->random());
        }
        return ['data' => $images];
    }
}
