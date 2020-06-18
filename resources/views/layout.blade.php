<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<title>TestBlog</title>
	<meta name="keywords" content="тестовый блог, блог">
    <meta name="description" content="Full-Stack разработка на laravel + javascript.">

    <link rel="stylesheet" href="/css/front.css"> 

    <link rel="icon" type="image/png" href="/img/favicon.png">
</head>
<body>

	<header class="header">
		<div class="container">
			<div class="navigation">
				<a class="navigation__logo" href="/">TestBlog</a>
			    <div class="navigation__toggle">
			       <div class="navigation__toggle-icon"></div>
			    </div> 				
				<nav class="navigation__categories">
			        <ul class="navigation__categories-list">
						@foreach($post->categories as $category)
							<li class="navigation__categories-item"><a class="navigation__categories-link" href="{{route('category.show', $category->slug)}}">{{$category->title}}<span class="count"> ({{$category->posts()->count()}})</span></a></li>
						@endforeach
			        </ul>	        
		    	</nav> 
		    	<form class="navigation__search" action="" method="get">
	  				<input class="navigation__search-field input" name="s" placeholder="Поиск по сайту..." type="search">
	  				<button class="navigation__search-btn btn" type="submit">Поиск</button>
				</form>
		    	<div class="navigation__cabinet">
		    	    <ul class="navigation__cabinet-list">
	                    <li class="navigation__cabinet-item navigation__cabinet-item_nomargin"><a class="navigation__cabinet-link" href="#">Регистрация</a></li>
	                    <li class="navigation__cabinet-item"><a class="navigation__cabinet-link" href="#">Вход</a></li>
	                    <li class="navigation__cabinet-item"><a class="navigation__cabinet-link" href="#">Профиль</a></li>
	                </ul>
	            </div>            				
	    	</div>
    	</div>
	</header>

    @yield('content')

	<footer class="footer">
		<div class="container">
			<div class="navigation">
				<a class="navigation__logo footer__logo" href="index.html">TestBlog</a>
		    	<div class="navigation__cabinet footer__cabinet">
		    	    <ul class="navigation__cabinet-list">
	                    <li class="navigation__cabinet-item footer__item"><a class="navigation__cabinet-link" href="#">Регистрация</a></li>
	                    <li class="navigation__cabinet-item footer__item"><a class="navigation__cabinet-link" href="#">Вход</a></li>
	                    <li class="navigation__cabinet-item footer__item"><a class="navigation__cabinet-link" href="#">Профиль</a></li>
	                </ul>
	            </div> 				
	    	</div>
    	</div>	
	</footer>

    <script src="/js/front.js"></script>
    <script>
    // Бургер
	$('.navigation__toggle').on('click',function(){
		$(this).find('.navigation__toggle-icon').toggleClass('active');
		$('.navigation__categories').slideToggle();
  	});
  
    $('.content__similar-posts').owlCarousel({
    	items: 3,
    	autoPlay: true,
    	pagination: false
	});

  </script>
</body>
</html>