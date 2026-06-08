<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/a', function () {
    echo 'test1';
    echo 'test2';
})->name('a');
