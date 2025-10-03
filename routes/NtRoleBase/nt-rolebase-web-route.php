<?php

use Illuminate\Support\Facades\Route;
use Netizens\RB\Http\Controllers\NtRoleBase\NtRoleBaseController;


Route::prefix('role-base')->group(function () {
    Route::get('/index', [NtRoleBaseController::class, 'index']);
});

