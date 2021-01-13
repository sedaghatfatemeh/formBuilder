<?php
return [
    //Login user
    'login'     => 'site/login',
    'logout'    => 'site/logout',

    //
    'add-items'  => 'detailes-form/add-items',
   // 'set-list/<type:\w+>'  => 'detailes-form/set-list',

    //user-info
    'register'          => 'user-info/register',
   // 'view/<id:\w+>'     => 'user-info/view',
    'update/<id:\w+>'   => 'user-info/update',
    'register-list'     => 'user-info/index',

    //module formBuilder
    'register-module'          => 'form-builder/user-info/register',
    'view/<id:\w+>'     => 'form-builder/user-info/view',
    'update-module/<id:\w+>'   => 'form-builder/user-info/update',
    'register-list-module'     => 'form-builder/user-info/index',

    'add-items-module'  => 'detailes-form/add-items',
    'set-list/<type:\w+>'  => 'detailes-form/set-list',
];