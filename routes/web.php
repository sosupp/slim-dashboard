<?php

use Illuminate\Support\Facades\Route;
use Sosupp\SlimDashboard\Http\Controllers\EditorImageUploadAdapterController;
use Sosupp\SlimDashboard\Http\Controllers\SlimerDashboardController;

Route::controller(EditorImageUploadAdapterController::class)->group(function(){
    Route::post('editor/image/upload', 'upload')->name('editor.image.upload');
    Route::post('editor/image/adaptor', 'upload')->name('editor.adapter.upload');
});

// Protected route to panel/dashboard 
Route::get('tester', function(){
    return 'to slimer';
});

Route::controller(SlimerDashboardController::class)->group(function(){
    Route::get('home', 'index')->name('slimer::dasboard.home');
});
