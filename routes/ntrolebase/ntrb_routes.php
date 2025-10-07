<?php

use Illuminate\Support\Facades\Route;
use Netizens\RB\Http\Controllers\NtRoleBase\NtRoleBaseController;

Route::middleware(['web', 'auth'])->group(function () {

    Route::prefix('role-base')->group(function () {
        Route::get('/index', [NtRoleBaseController::class, 'index']);
    });

});
