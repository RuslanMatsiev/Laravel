<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Получаем постынее не менее 5 на странице для пагинации
    public function index()
    {
        $posts = Post::paginate(5);
        // Передаем в вид
        return view('pages.index', ['posts' => $posts]);
    }

    // Получаем слаг поста
    public function show($slug)
    {
        // Выведем ошибкку, если такого поста не существует    
    	$post = Post::where('slug', $slug)->firstOrFail();

    	return view('pages.show', compact('post'));
    } 

    // Берем посты от тега текущего и отдаем их в вид, на странице не более 5 шт
    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()->paginate(5);

        return view('pages.list', ['posts'  =>  $posts]);
    }

    // Берем посты от категории текущей и отдаем их в вид, на странице не более 5 шт
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()->paginate(5);

        return view('pages.list', ['posts'  =>  $posts]);   
    }    
    
}
