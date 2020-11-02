<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category, Topic $topic, Request $request, User $user)
    {
        $topics = $topic->where('category_id',$category->id)->withOrder($request->order)
            ->with('category','user')
            ->paginate(20);
        $active_users = $user->getActiveUsers();
        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category','active_users'));
    }
}
