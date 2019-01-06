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

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionsController')->except('show');
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');
Route::get('/questions/{slug}/answers', 'AnswersController@index')->name('answers.index');
//Route::post('/questions/{question}/answers', 'AnswersController@store')->name('answers.store');
Route::get('questions/{slug}/answers/{answer}/edit', 'AnswersController@edit');
Route::delete('questions/{slug}/answers/{answer}', 'AnswersController@destroy');
Route::patch('questions/{slug}/answers/{answer}', 'AnswersController@update');
Route::resource('questions.answers', 'AnswersController')->except(['index', 'create', 'show']);

Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

Route::post('/questions/{question}/vote', 'VoteQuestionController@store')->name('questions.vote');
Route::delete('/questions/{question}/unvote', 'VoteQuestionController@destroy')->name('questions.unvote');

Route::post('/answers/{answer}/vote', 'VoteAnswerController@store')->name('answers.vote');
Route::delete('/answers/{answer}/unvote', 'VoteAnswerController@destroy')->name('answers.unvote');