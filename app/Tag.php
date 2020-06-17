<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
{
    use Sluggable;    
 
    // Формирование массива с полями, в данном случае с полем заголовка тега
    protected $fillable = ['title'];

    // Создание связи много тегов - много постов (связь многие ко многим)
    public function tags()
    {
        return $this->belongsToMany(
            Post::class,
            'post_tags',
            'tag_id',
            'post_id'
        );
    }

    // Перевод заголовка тэга на латиницу, формирование seo friendly ссылки
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    } 
    
}
