<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::group(['prefix' => 'shows'], function () {
    //episodes
    Route::get('anime-watching/{show_id}/{episode_id}', [App\Http\Controllers\Anime\AnimeController::class, 'animeWatching'])->name('anime.watching');

    //show details
    Route::get('show-details/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'animeDetails'])->name('anime.details');

    //store comments
    Route::post('store-comment/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'storeComment'])->name('store.comment');

    //following
    Route::post('follow/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'follow'])->name('anime.follow');

    //category
    Route::get('category/{category_name}', [App\Http\Controllers\Anime\AnimeController::class, 'animePerCategory'])->name('anime.category');

    //search shows
    Route::any('search', [App\Http\Controllers\Anime\AnimeController::class, 'searchShows'])->name('anime.search.shows');
});

//users 'users followed shows'
Route::get('users/followed-shows', [App\Http\Controllers\Users\UsersController::class, 'followedShows'])->name('users.followed.shows')->middleware('auth:web');

//admin pannel
Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login')->middleware('check.for.auth');
Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::get('index', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admins.dashboard');

    //admins
    Route::get('/all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'allAdmins'])->name('admins.all');
    Route::get('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('admins.create');
    Route::post('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmin'])->name('admins.store');

    //shows
    Route::get('/all-shows', [App\Http\Controllers\Admins\AdminsController::class, 'allShows'])->name('shows.all');
    Route::get('/create-shows', [App\Http\Controllers\Admins\AdminsController::class, 'createShow'])->name('shows.create');
    Route::post('/create-shows', [App\Http\Controllers\Admins\AdminsController::class, 'storeShow'])->name('shows.store');
    Route::get('/delete-shows/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteShow'])->name('shows.delete');

    //genres
    Route::get('/all-genres', [App\Http\Controllers\Admins\AdminsController::class, 'allGenres'])->name('genres.all');
    Route::get('/create-genres', [App\Http\Controllers\Admins\AdminsController::class, 'createGenre'])->name('genres.create');
    Route::post('/create-genres', [App\Http\Controllers\Admins\AdminsController::class, 'storeGenre'])->name('genres.store');
    Route::get('/delete-genre/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteGenre'])->name('genres.delete');


    //episodes
    Route::get('/all-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'allEpisodes'])->name('episodes.all');
    Route::get('/create-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'createEpisode'])->name('episodes.create');
    Route::post('/create-episodes', [App\Http\Controllers\Admins\AdminsController::class, 'storeEpisode'])->name('episodes.store');
    Route::get('/delete-episodes/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteEpisode'])->name('episodes.delete');
});