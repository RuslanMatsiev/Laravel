<?php

namespace App\Http\Controllers\Admin;

// Подключаем модель пользователей
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Рендерим страницу пользователей админ. панели 
    public function index()
    {
        // Выгружаем всех польщователей из БД
        $users = User::all();
        // Передаем юзеров в админку на страницу пользователей
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Выводим страницу создания пользователей
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Добавляем пользователя со всеми данными
    public function store(Request $request)
    {
        // Валидация полей, обязательно для заполнения
        $this->validate($request, [
            'name' => 'required',
            // Валидация на уникальность email
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'userimage' => 'nullable|image'
        ]);
        // Создание нового пользователя, используя все поля из массива полей юзера
        $user = User::add($request->all());
        $user->genPass($request->get('password'));        
        // Передаем аватар пользователя
        $user->uploadUserImage($request->file('userimage'));
        // Редиректим
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Редактируем определенного пользователя
    public function edit($id)
    {
        // Делаем выборку пользователя из базы
        $user = User::find($id);
        // Передаем нашего юзера в админку на страницу редактирования
        return view('admin.users.edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Изменение данных юзера, ловим идентификатор пользователя   
    public function update(Request $request, $id)
    {
        // Берем пользователя из базы
        $user = User::find($id);        
        // Валидация полей
        $this->validate($request, [
            'name' => 'required',
            // Валидация на уникальность email
            'email' => [
                'required', 
                'email',
                // Проверка на уникальность email за исключением проверки на уникальность по отношению к себе
                Rule::unique('users')->ignore($user->id),
            ],    
            'userimage' => 'nullable|image'
        ]);        
        // Изменяем все данные пользователя на все те, что пришли с запроса
        $user->edit($request->all());
        // Обновляем пароль
        $user->genPass($request->get('password'));
        // Обновляем аватар
        $user->uploadUserImage($request->file('userimage'));
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // Удаление пользователя 
    public function destroy($id)
    {
        // Ищем индекс нужного юзера и удаляем его
        User::find($id)->remove();
        // После удаления возвращаемся обратно
        return redirect()->route('users.index');

    }
}
