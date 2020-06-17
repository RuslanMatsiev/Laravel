<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use Sluggable;

    // Формирование массива с полями, в данном случае с полем заголовка категории
    protected $fillable = ['title'];

    // Создание связи много категорий - много постов  
    public function posts()
    {
        // return $this->hasMany(Post::class);
        return $this->belongsToMany(
            Post::class,
            'post_categories',
            'category_id',
            'post_id'
        );        
    }

    // Перевод заголовка категории на латиницу, формирование seo friendly ссылки
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    } 

    // Получение количества постов категории
    public function countPosts()
    {
        // Получаем количество публикаций в массиве определенной категории
        return $this->posts->pluck('id')->count();
    }
    
}
