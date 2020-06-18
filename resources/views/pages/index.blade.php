@extends('layout')

@section('content')
	<main class="content">
		<div class="container">
			<h1 class="content__title">Тестовый блог</h1>
			<article class="article">
                @foreach($posts as $post)
                    <section class="content__post">
                        <div class="content__post-img">
                            <a class="content__post-link" href="{{route('post.show', $post->slug)}}"><img class="content__img-item" src="{{$post->getImage()}}"
                                    alt="post-img"></a>
                        </div>
                        <div class="content__post-box">
                            <h2 class="content__post-title">
                                <a class="content__title-link" href="{{route('post.show', $post->slug)}}">{{$post->title}}</a>
                            </h2>
                            <div class="content__post-text">
                                {!!$post->limitDesc()!!}
                            </div>
                            <div class="content__post-info">
                                <span class="content__post-date">
                                    <time class="content__post-datatime">{{$post->getDate()}}</time>
                                </span>
                                <span class="content__post-views">Смотрели
                                    <span class="content__views-count">575</span>
                                </span>
                                <span class="content__post-likes">Нравится
                                    <span class="content__likes-count">20</span>
                                </span>
                                <div class="content__post-category">        
                                    @foreach($post->categories as $category)
                                        <a class="content__category-link" href="{{route('category.show', $category->slug)}}">{{$category->title}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>	
                    </section>                
                @endforeach
{{$posts->links()}}
				<!-- <div class="content__pagination">
					<ul class="content__pagination-list">
						<li class="content__pagination-item content__pagination-item_prev">
							<a class="content__pagination-link" href="#"> < </a>
						</li> 
						<li class="content__pagination-item"> 
							<a class="content__pagination-link" href="#">1</a>
						</li>
						<li class="content__pagination-item"> 
							<a class="content__pagination-link"	href="#">2</a>
						</li>
						<li class="content__pagination-item"> 
							<a class="content__pagination-link"href="#">3</a>
						</li>
						<li class="content__pagination-item"> 
							<a class="content__pagination-link"href="#">4</a>
						</li>
						<li class="content__pagination-item content__pagination-item_next"> 
							<a class="content__pagination-link" href="#"> > </a>
						</li>
					</ul>
				</div> -->
			</article>			
		</div>		
	</main>

@endsection