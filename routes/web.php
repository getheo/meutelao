<?php

Route::get('/' function(){
    return view('welcome');
})->name('site.home');

Route::get('/comofunciona' function(){
    return view('comofunciona');
})->name('site.comofunciona');

Route::get('/' function(){
    return view('plano');
})->name('site.plano');