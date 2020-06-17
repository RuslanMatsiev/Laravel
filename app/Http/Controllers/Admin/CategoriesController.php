<?php

namespace App\Http\Controllers\Admin;

// Подключаем модель категории
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    // Рендерим страницу категорий админ. панели
    public function index()
    {
        // Выгружаем все категории из нашей таблицы категорий
        $categories = Category::all();
        // Передаем категории в админку на страницу категорий
        return view('admin.categories.index', ['categories' => $categories]);
    }

    // Выводим страницу создания категории
    public function create()
    {
        return view('admin.categories.create');
    }

    // Добавляем категорию со всеми данными
    public function store(Request $request)
    {
        // Валидация поля заголовка категории, обязательно для заполнения
        $this->validate($request, [
            'title' => 'required'
        ]);
        // Создание новой записи, используя все поля из массива полей категории
        Category::create($request->all());
        // Редиректим
        return redirect()->route('categories.index');
    }

    // Редактируем определенную категорию
    public function edit($id)
    {
        // Ищем категорию по идентификатору
        $category = Category::find($id);
        // Передаем нашу категорию в админку на страницу редактирования
        return view('admin.categories.edit', ['category'=>$category]);
    }

    // Изменение названия категории, ловим идентификатор редактируемой категории    
    public function update(Request $request, $id)
    {
        // Валидация поля заголовка категории
        $this->validate($request, [
            'title' => 'required'
        ]);        
        $category = Category::find($id);
        // Передаем по всем полям
        $category->update($request->all());
        return redirect()->route('categories.index');
    }

    // Удаление категории
    public function destroy($id)
    {
        // Ищем индекс нужной категории и удаляем ее
        Category::find($id)->delete();
        // После удаления возвращаемся обратно
        return redirect()->route('categories.index');

    }
}
