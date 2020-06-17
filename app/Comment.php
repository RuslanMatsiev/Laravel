<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Константы статусов/положений
    const IS_ALLOW = 1;
    const IS_DISALLOW = 0;

    // Создание связи Один коммментарий - один пост  
    public function posts()
    {
        return $this->hasOne(Post::class);
    }

    // Создание связи Один комментарий - один автор  
    public function author()
    {
        return $this->hasOne(User::class);
    }

    // Одобряем комментарий
    public function allow()
    {
        $this->status = Comment::IS_ALLOW;
        $this->save();
    }

    // Отклоняем комментарий
    public function disAllow()
    {
        $this->status = Comment::IS_DISALLOW;
        $this->save();
    }
    
   // Изменение статуса комментария на "Одобрен" или "Отклонен"
    public function changeStatus()
    {
        if($this->status = Comment::IS_DISALLOW) 
        {
            return $this->allow();
        }
        return $this->disAllow();
    }
    
    // Удаление комментария
    public function remove()
    {
        $this->delete();
    }
}
