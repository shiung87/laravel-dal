<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dal-list', function () {
    return view('dal-list');
});

Route::get('/dal-table', function () {
    return view('dal-table');
});