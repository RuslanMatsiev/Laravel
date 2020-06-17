<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Роут главной страницы
Route::get('/', 'HomeController@index');
// Создем роут страницы постов в клиентской части
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');
// Создаем роут страницы выборки постов по тегу
Route::get('/tag/{slug}', 'HomeController@tag')->name('tag.show');
// Создаем роут страницы категории с постами
Route::get('/category/{slug}', 'HomeController@category')->name('category.show');

// Создаем роут-группу для повторяющихся префиксов и неймспейсов
Route::group(['prefix'=>'adminpanel', 'namespace'=>'Admin'], function () {
    // Создаем роут главной страницы админ. панели
    Route::get('/', 'DashboardController@index');
    // Создаем роут страницы категорий
    Route::resource('/categories', 'CategoriesController');
    // Создаем роут страницы тегов
    Route::resource('/tags', 'TagsController');
    // Создаем роут страницы пользователей
    Route::resource('/users', 'UsersController');
    // Создаем роут страницы публикаций
    Route::resource('/posts', 'PostsController');              
});