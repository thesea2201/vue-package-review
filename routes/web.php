<?php
    Route::get('pagereview', 'PageReviewController@index')->name('pagereview.index');
    Route::post('pagereview', 'PageReviewController@store')->name('pagereview.store');

