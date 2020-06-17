<?php

namespace App\Http\Controllers\Admin;

// Подключаем модель тегов
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Рендерим страницу тегов админ. панели 
    public function index()
    {
        // Делаем запрос в таблицу тегов
        $tags = Tag::all();
        // Передаем теги в админку на страницу тегов
        return view('admin.tags.index', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Выводим страницу создания тегов 
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Валидация поля заголовка тега, обязательно для заполнения
        $this->validate($request, [
            'title' => 'required'
        ]);
        // Создание новой записи, используя все поля из массива полей тега
        Tag::create($request->all());
        // Редиректим
        return redirect()->route('tags.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Редактируем определенный тег
    public function edit($id)
    {
        // Ищем тег по идентификатору
        $tag = Tag::find($id);
        // Передаем наш тег в админку на страницу редактирования
        return view('admin.tags.edit', ['tag'=>$tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Изменение названия тега, ловим идентификатор редактируемого тега 
    public function update(Request $request, $id)
    {
        // Валидация поля заголовка тега
        $this->validate($request, [
            'title' => 'required'
        ]);        
        $tag = Tag::find($id);
        // Передаем по всем полям
        $tag->update($request->all());
        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Удаление тега
    public function destroy($id)
    {
        // Ищем индекс нужного тега и удаляем его
        Tag::find($id)->delete();
        // После удаления возвращаемся обратно
        return redirect()->route('tags.index');

    }
}
