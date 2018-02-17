<?php

Route::resource('users', 'Admin\AdminUsersController',
//con 'names' si possono modificare i nomi delle rotte prestabilite con la creazione del controller resource
    ['names' =>

        ['index' => 'user-list'
            ]
    ]
);

Route::get('getUsers', 'Admin\AdminUsersController@getUsers')
    ->name('admin.getUsers');

Route::view('/', 'templates/admin')->name('admin');

Route::get('/dashboard',function(){
    return "loggato dashboard";
});

