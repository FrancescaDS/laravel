<?php
//per pagine statiche dove non serve chiamare il controller
//  chiamare view e dare direttam,ente il nome della view
Route::view('about','about');
//Route::get('about','PageController@about');

Route::get('blog','PageController@blog');
Route::get('staff','PageController@staff');
