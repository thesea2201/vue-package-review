<?php
    Route::get('vuepagereview', 'VuePageReviewController@index')->name('vuepagereview.index');
    Route::post('vuepagereview', 'VuePageReviewController@store')->name('vuepagereview.store');

