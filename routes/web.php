<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return redirect('/kurikulum/index.php');
})->where('any', '.*');
