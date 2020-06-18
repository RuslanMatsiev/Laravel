@extends('layout')

@section('content')
	<main class="content">
		<div class="container">
			<article class="article">
				<section class="content__post post">
					<div class="content__post-img post__img">
						<a class="content__post-link post__link" href="#"><img class="content__img-item post__img-item" src="{{$post->getImage()}}"
								alt="post-img"></a>
					</div>
					<div class="content__post-box post__box">
						<h1 class="content__post-title post__title">
							<a class="content__title-link" href="#">{{$post->title}}</a>
						</h1>
						<h2 class="content__post-subtitle">
							<a class="content__subtitle-link  post__subtitle-link" href="#">{{$post->subtitle}}</a>
						</h2>
						<div class="content__post-text post__text">
                            {!!$post->content!!}
                        </div>
						<div class="content__post-info post-info">
							<span class="content__post-date post-info__date post-info__item">
								<time class="content__post-datatime">{{$post->getDate()}}</time>
							</span>
							<span class="content__post-views post-info__views post-info__item">Смотрели
								<span class="content__views-count">575</span>
							</span>
							<span class="content__post-likes post-info__likes post-info__item">Нравится
								<span class="content__likes-count">20</span>
							</span>
                        </div>
                            <div class="content__post-tags">
                                @foreach($post->tags as $tag)
                                    <a class="content__tag-link" href="{{route('tag.show', $tag->slug)}}">{{$tag->title}}</a>
                                @endforeach
                            </div>
						<div class="content__post-author">
							<img class="content__author-avatar" src="assets/img/post-img.jpg" alt="post-img">
							<h3 class="content__author-name"><a class="content__author-link" href="#">Руслан Мациев</a></h3>
							<p class="content__author-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda beatae odio iusto voluptates distinctio expedita, porro cumque voluptate velit fugiat suscipit error rem natus doloremque repellat harum delectus autem tenetur.</p>
						</div>
					</div>	
                </section>                
				<div class="content__pagination">
					<ul class="content__pagination-list pagination-list">
                        @if($post->hasPrevious())
                            <li class="content__pagination-item pagination-list__item">
                                <a class="content__pagination-link pagination-link" href="{{route('post.show', $post->getPrevious()->slug)}}"> Предыдущий пост </a>
                            </li> 
                        @endif
                        @if($post->hasNext())
                            <li class="content__pagination-item pagination-list__item">
                                <a class="content__pagination-link pagination-link" href="{{route('post.show', $post->getNext()->slug)}}"> Следующий пост </a>
                            </li>
                        @endif
					</ul>
				</div>
				<h4 class="content__similar">Материалы по теме</h4>
				<div class="content__similar-posts">
                    @foreach($post->related() as $item)
                        <div class="content__similar-post">
                            <a class="content__similar-link" href="{{route('post.show', $item->slug)}}">
                                <img class="content__similar-img" src="{{$item->getImage()}}" alt="post-img">
                                <h4 class="content__similar-title">{{$item->title}}</h4>
                            </a>
                        </div>
                    @endforeach
				</div>

				<h4 class="content__similar">Комментарии</h4>
                <div class="content__comments">
					
                	<p class="content__comments-count">3 комментария</p>
					<div class="content__comments-box">
						<div class="content__comments-imgbox">
							<img class="content__comments-img" src="/img/post-img.jpg" alt="post-img">
						</div>

						<div class="content__comments-text">
							
							<h5 class="content__comments-user"><a class="content__user-link" href="#"></a>Руслан Мациев</h5>

							<p class="content__comments-date">
								<time class="content__comments-datetime">05 Jule 2019</time>
							</p>


							<p class="content__comment">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
								diam nonumy
								eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
								voluptua. At vero eos et cusam et justo duo dolores et ea rebum.</p>
							<a href="#" class="content__comments-reply btn"> Ответить</a>
						</div>
					</div>
				</div>
				<div class="content__form-comments">
					<form class="content__form form-auth" method="post" action="">
						<input type="text" class="content__form-input input" id="name" name="name" placeholder="Имя">
						<input type="text" class="content__form-input input" id="email" name="email" placeholder="Email">
						<textarea class="content__form-input input input-area" rows="6" name="message"
							placeholder="Оставьте комментарий"></textarea>
						<button type="submit" name="submit" class="content__form-btn btn">Отправить</button>
					</form>
				</div>
			</article>			
		</div>		
	</main>

@endsection