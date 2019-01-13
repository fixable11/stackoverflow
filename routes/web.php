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

Route::resource('questions', 'QuestionsController');

//Answers of the question
Route::get('/questions/{slug}/answers', 'AnswersController@index')->name('answers.index');
Route::post('/questions/{slug}/answers', 'AnswersController@store')->name('answers.store');
Route::delete('questions/{slug}/answers/{answer}', 'AnswersController@destroy');
Route::patch('questions/{slug}/answers/{answer}', 'AnswersController@update');

//Accept answer
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

//Favorite question
Route::post('/questions/{slug}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{slug}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

//Vote question
Route::post('/questions/{question}/vote', 'VoteQuestionController@store')->name('questions.vote');
Route::delete('/questions/{question}/unvote', 'VoteQuestionController@destroy')->name('questions.unvote');

//Vote answer
Route::post('/answers/{answer}/vote', 'VoteAnswerController@store')->name('answers.vote');
Route::delete('/answers/{answer}/unvote', 'VoteAnswerController@destroy')->name('answers.unvote');