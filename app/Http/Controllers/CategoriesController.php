<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category, Topic $topic, Request $request)
    {
        $topics = $topic->withOrder($request->order)
            ->with('category','user')
            ->where('category_id',$category->id)
            ->paginate(20);
        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category'));
    }
}
