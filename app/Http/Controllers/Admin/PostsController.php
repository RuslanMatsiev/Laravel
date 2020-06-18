<?php

namespace App\Http\Controllers\Admin;

// Подключаем модель тега, поста, категории
use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Рендерим страницу постов админ. панели
    public function index()
    {
        // Передаем все посты из БД
        $posts = Post::all();
        // Передаем посты в админку на страницу категорий
        return view('admin.posts.index',  ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Выводим страницу создания поста 
    public function create()
    {
        // Получаем название категорий и тегов в виде массивов
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        // Передаем в админку на страницу редактирования поста
        return view('admin.posts.create', compact(
            'categories',
            'tags'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Добавляем посты со всеми данными
    public function store(Request $request)
    {
        // Валидация полей поста обязательно для заполнения
        $this->validate($request, [
            'title' => 'required',
            'subtitle' =>'required',
            'description' => 'required',
            'content' => 'required',
            'date' => 'required',
            'image' => 'nullable|image'
        ]);
        // Создание новой записи, используя все поля из массива полей поста
        $post = Post::add($request->all());
        // Загружаем изображение
        $post->uploadImage($request->file('image'));
        // Присваиваем категории
        $post->addCategories($request->get('categories'));
        // Добавляем теги
        $post->addTags($request->get('tags'));
        // Устанвливаем статус публикации
        $post->changeStatus($request->get('status'));
        // Устанавливаем вид статьи, обычная или рекомендовванная
        $post->changeView($request->get('is_featured'));
        // Редиректим
        return redirect()->route('posts.index');
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Редактируем публикацию
    public function edit($id)
    {
        // Ищем публикацию по идентификатору
        $post = Post::find($id);
        // Получаем название категорий и тегов в виде массивов
        $categories = Category::pluck('title', 'id')->all();
        $selCategories = $post->categories->pluck('id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        $selTags = $post->tags->pluck('id')->all();
        // Передаем в админку на страницу редактирования поста
        return view('admin.posts.edit', compact(
            'categories',
            'tags',
            'post',
            'selCategories',
            'selTags'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Изменяем пост 
    public function update(Request $request, $id)
    {
       // Валидация полей поста обязательно для заполнения
        $this->validate($request, [
            'title' => 'required',
            'subtitle' =>'required',
            'content' => 'required',
            'date' => 'required',
            'image' => 'nullable|image'
        ]);
        // Обращаемся к редактируемому посту
        $post = Post::find($id);
        // Берем поля
        $post->edit($request->all());
        // Загружаем изображение
        $post->uploadImage($request->file('image'));
        // Присваиваем категории
        $post->addCategories($request->get('categories'));
        // Добавляем теги
        $post->addTags($request->get('tags'));
        // Устанвливаем статус публикации
        $post->changeStatus($request->get('status'));
        // Устанавливаем вид статьи, обычная или рекомендовванная
        $post->changeView($request->get('is_featured'));
        // Редиректим
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Удаление поста 
    public function destroy($id)
    {
        // Ищем идентификатор нужного поста и удаляем ее
        Post::find($id)->remove();
        // После удаления возвращаемся обратно
        return redirect()->route('posts.index');
    }
}
