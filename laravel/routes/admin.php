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

Route::patch('restore/{id}', 'Admin\AdminUsersController@restore')
    ->name('users.restore');

Route::view('/', 'templates/admin')->name('admin');

Route::get('/dashboard',function(){
    return "Admin dashboard";
});

