<?php

namespace App;

use \Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Константы статусов/положений
    const IS_ON = 0;
    const IS_OFF = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Создание связи Один пользователь - много постов      
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Создание связи Одна категория - много комментариев      
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Добавление пользователя
    public static function add($fields)
    {
        // Создание нового эксземпляра модели
        $user = new static;
        // Загружаем поля из массива
        $user->fill($fields);
        // Хэшируем пароль
        $user->save();
        // Возвращаем пользователя, если нам потребуется
        return $user;
    }

    // Редактирование пользователя
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }
    
    // Принимаем значение пароля из формы
    public function genPass($pass)
    {
         // Обновление пароля c хэшем, записываем пароль только в том случае, если он изменен
        if($pass != null)
        {
            $this->password = bcrypt($pass);
            $this->save();
        }
    }

    // Удаление пользователя
    public function remove()
    {
        $this->removeUserImage();
        $this->delete();
    }

    // Загрузка аватара пользователя
    public function uploadUserImage($image)
    {
        // Если изображение не загружено, то ничего не делаем, иначе загружаем картинку 
        if($image == null) {return;}

        $this->removeUserImage();

        // Генерируем рандомное название файла с расширением
        $filename = str_random(10) . '.' . $image->extension();
        // Сохраняем изображение в папку uploads
        $image->storeAs('uploads', $filename);
        // Пишем название изображения в нужное поле
        $this->userimage = $filename;
        $this->save(); 
    } 

    // Удаление аватара
    public function removeUserImage()
    {
        // Если пользователь имеет картинку - удаляем, если нет, то ничего не делаем       
        if($this->userimage != null) 
        {
            Storage::delete('uploads/' . $this->userimage);
        }

    }
    
    // Вывод изображения
    public function getUserImage()
    {
        // Если изображение отсутствует, выводим дефолтное изображение, иначе то, которое загрузили
        if ($this->userimage == null)
        {
            return '/img/default-user-image.png';
        }
        return '/uploads/' . $this->userimage;
    }

    // Делаем пользователя админом
    public function setAdmin()
    {
        $this->is_admin = User::IS_ON;
        $this->save();
    }                
    
    // Делаем юзера простым пользователем
    public function setUser()
    {
        $this->is_admin = User::IS_Off;
        $this->save();
    } 

    // Изменение статуса пользтователя на "Пользователь" или "Админ"
    public function changeStatus($value)
    {
        if($value == null) 
        {
            return $this->setUser();
        }
        return $this->setAdmin();
    }
    
    // Статус "забанен"
    public function ban()
    {
        $this->status = User::IS_ON;
        $this->save();
    }

    // Статус стандартный, без бана
    public function unBan()
    {
        $this->status = User::IS_OFF;
        $this->save();
    }

    // Изменение статуса пользтователя на "Стандартный" или "Забанен"
    public function changeBan($value)
    {
        if($value == null) 
        {
            return $this->unBan();
        }
        return $this->ban();
    }


}
