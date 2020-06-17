@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить статью
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Вывод формы и обработка данных   -->    
    {!! Form::open([
        'route' => ['posts.update', $post->id],
        'files' => true,
        'method' => 'put'
    ]) !!}
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Обновляем статью</h3>
          <!-- Выводим ошибки -->
          @include('admin.errors')           
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Заголовок</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$post->title}}" name="title">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail2">Подзаголовок</label>
              <input type="text" class="form-control" id="exampleInputEmail2" placeholder="" value="{{$post->subtitle}}" name="subtitle">
            </div>            
            <div class="form-group">
              <img src="{{$post->getImage()}}" alt="" class="img-responsive" width="200">
              <label for="exampleInputFile">Лицевая картинка</label>
              <input type="file" id="exampleInputFile" name="image">

              <p class="help-block">Какое-нибудь уведомление о форматах..</p>
            </div>
            <div class="form-group">
              <label>Категория</label>
              <!-- Выводим массив категорий с мультивыбором категорий  -->
              {!! Form::select('categories[]', 
                $categories, 
                $selCategories, 
                ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Выберите категории']) 
              !!}
            </div>
            <div class="form-group">
              <label>Теги</label>
              <!-- Выводим массив тегов с мультивыбором тегов  -->
              {!! Form::select('tags[]', 
                $tags, 
                $selTags,
                ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Выберите теги' ]) 
              !!}
            </div>
            <!-- Date -->
            <div class="form-group">
              <label>Дата:</label>

              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" value="{{$post->date}}" name="date">
              </div>
              <!-- /.input group -->
            </div>
            <!-- checkbox -->
            <div class="form-group">
              <label>
              {{Form::checkbox('is_featured', '1', $post->is_featured, ['class'=>'minimal'])}}
              </label>
              <label>
                Рекомендовать
              </label>
            </div>
            <!-- checkbox -->
            <div class="form-group">
              <label>
                {{Form::checkbox('status', '1', $post->status, ['class'=>'minimal'])}}
              </label>
              <label>
                Черновик
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Описание</label>
              <textarea name="description" id="" cols="30" rows="10" class="form-control" >{{$post->description}}</textarea>
          </div>
        </div>       
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Полный текст</label>
              <textarea name="content" id="" cols="30" rows="10" class="form-control">{{$post->content}}</textarea>
          </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{route('posts.index')}}" class="btn btn-default">Назад</a>
          <button class="btn btn-warning pull-right">Изменить</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
 {!! Form::close() !!}
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection