@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blank page
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Вывод формы и обработка данных   -->
 
      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Листинг сущности</h3>
                <!-- Выводим ошибки -->
                @include('admin.errors')               
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('posts.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название</th>
                  <th>Категории</th>
                  <th>Теги</th>                  
                  <th>Дата публикации</th>
                  <th>Лайков</th>
                  <th>Просмотров</th>
                  <th>Картинка</th>
                  <th>Статус публикации</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <!-- Выводим циклом все посты в админку со всеми данными -->
                @foreach($posts as $post)                    
                    <tr>
                        <td>{{$post->id}}</td>
                        <td>{{$post->title}}</td>
                        <!-- Все категории поста -->
                        <td>{{$post->getCategories()}}</td>
                        <!-- Все теги поста -->
                        <td>{{$post->getTags()}}</td>
                        <!-- Дата публикации                         -->
                        <td>{{$post->date}}</td>
                        <td></td>
                        <td></td>
                        <td>
                            <img src="{{$post->getImage()}}" alt="" width="100">
                        </td>
                        <td>
                        <div class="form-group">
                            <span data-status="{{$post->status}}" class="status-int"></span>
                        </div>                          
                                    </td>
                        <td><a href="{{route('posts.edit', $post->id)}}" class="fa fa-pencil"></a>
                        {{Form::open(['route' => ['posts.destroy', $post->id], 'method'=>'delete'])}}
                            <button type="submit" class="delete">
                                <i class="fa fa-remove"></i>
                            </button>
                        {{Form::close()}} 
                        </td>
                    </tr>
                @endforeach
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection