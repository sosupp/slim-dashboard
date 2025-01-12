<?php

use Illuminate\Support\Facades\Route;
use Sosupp\SlimDashboard\Http\Controllers\EditorImageUploadAdapterController;

Route::controller(EditorImageUploadAdapterController::class)->group(function(){
    Route::post('editor/image/upload', 'upload')->name('editor.image.upload');
});