<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;

    // Константы статусов/положений
    const IS_ON = 0;
    const IS_OFF = 1;

    // Формирование массива заполняемых полей поста
    protected $fillable = [
        'title', 'subtitle', 'content', 'date', 'description'
    ];

    // Создание связи много постов - много категорий 
    public function categories()
    {
        // return $this->hasOne(Category::class);
       
        return $this->belongsToMany(
            Category::class,
            'post_categories',
            'post_id',
            'category_id'
        );        
    }

    // Создание связи Один пост - один автор     
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Создание связи много постов - много тегов (связь многие ко многим)
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }

    // Перевод заголовка поста на латиницу, формирование seo friendly ссылки
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }
    
    // Создание поста
    public static function add($fields)
    {
        // Создание нового эксземпляра класса
        $post = new static;
        // Получаем массив заполняемых полей
        $post->fill($fields);
        // Запрещаем запись в таблицу от имени администратора 
        $post->user_id = 1;
        // Сохраняем пост    
        $post->save();
        // Возвращаем пост на случай, если потребуется
        return $post;           
    }

    // Редактирование поста
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    // Удаление поста с изображением
    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    // Удаление изображения поста
    public function removeImage()
    {
        if($this->image != null )
        {
            Storage::delete('uploads/' . $this->image);
        }
    }

    // Загрузка изображения поста на сервер
    public function uploadImage($image)
    {
        // Если изображение не загружено, то ничего не делаем, иначе загружаем картинку 
        if($image == null) {return;}

        // Если такое изображение есть в папке - удаляем его
        $this->removeImage();
        // Генерируем рандомное название файла с расширением
        $filename = str_random(10) . '.' . $image->extension();
        // Сохраняем изображение в папку uploads
        $image->storeAs('uploads', $filename);
        // Пишем название изображения в нужное поле для статьи (поста)
        $this->image = $filename;
        $this->save(); 
    }

    // Вывод изображения
    public function getImage()
    {
        // Если изображение отсутствует, выводим дефолтное изображение, иначе то, которое загрузили
        if ($this->image == null)
        {
            return '/img/default-image.png';
        }
        return '/uploads/' . $this->image;
    }


    // Сохранение категорий, привязка к категориям
    public function addCategories($ids)
    {
        // if($id == null) {return;}

        // // Ищем id категории
        // $category = Category::find($id);
        // // Передаем саму категорию по ее id
        // $this->category()->save($category);
        
        if($ids == null) {return;}
        // Синхронизация статьи с категориями
        $this->categories()->sync($ids);

    }

    // Добавление тегов
    public function addTags($ids)
    {
        if($ids == null) {return;}
        
        // Синхронизация статьи с тегами
        $this->tags()->sync($ids);
    }

    // Присвоение статуса "Черновик"
    public function addDraft()
    {
        $this->status = Post::IS_ON;
        $this->save();
    }

    // Присвоение статуса "Опубликовано"
    public function addPublic()
    {
        $this->status = Post::IS_OFF;
        $this->save();
    }    

    // Изменение статуса публикации на "Черновик" или "Опубликовано"
    public function changeStatus($value)
    {
        if($value == null) 
        {
            return $this->addDraft();
        }
        return $this->addPublic();
    }

    // Добавление статьи в "Рекомендованные"
    public function addFeatured()
    {
        $this->is_featured = Post::IS_OFF;
        $this->save();
    }

    // Обычная статья
    public function addDefault()
    {
        $this->is_featured = Post::IS_ON;
        $this->save();
    }

    // Изменение статьи на обычныю или "Рекомендуемую"
    public function changeView($value)
    {
        if($value == null) 
        {
            return $this->addDefault();
        }
        return $this->addFeatured();
    }

    // Преобразование формата даты (для БД)
    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }
    
    // Преобразование формата даты наоборот (для вида редаактировния поста админ. панели)
    public function getDateAttribute($value)
    {
        //Отправляем в поле даты
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
        // Возвращаем
        return $date;
    }    
    

    // Получаем категории, если добавлены к посту
    public function getCategories()
    {
        if($this->categories != null) 
        {
            // Получаем через запятую строковые данные из массива категорий
            return implode(', ', $this->categories->pluck('title')->all());
        }
        return 'Категория отсутствует';
    }

    // Получаем теги, если добавлены к посту
    public function getTags()
    {
        if($this->tags != null) 
        {
            // Получаем через запятую строковые данные из массива тегов
            return implode(', ', $this->tags->pluck('title')->all());
        }
        return 'Теги отсутствует';
    }

    // Получаем дату в нужном формате
    public function getDate()
    {
        return Carbon::createFromFormat('d/m/y', $this->date)->format('d F Y');
    }
    
    // Шагам к предыдущему посту
    public function hasPrevious()
    {
        return self::where('id', '<', $this->id)->max('id');
    }

    
    // Навигация по постам внутри поста
    public function getPrevious()
    {
        $postID = $this->hasPrevious(); //ID
        return self::find($postID);
    }

    public function hasNext()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getNext()
    {
        $postID = $this->hasNext();
        return self::find($postID);
    }

    // Статьи из этой же темы, кроме текущего
    public function related()
    {
        return self::all()->except($this->id);
    }


}