<?php

use Illuminate\Support\Facades\Route;
use Netizens\RB\Http\Controllers\NtRoleBase\NtRoleBaseController;

Route::middleware(['web', 'auth'])->group(function () {

    // Route::prefix('role-base')->group(function () {
    //     Route::get('/index', [NtRoleBaseController::class, 'index']);
    // });

    Route::prefix('ntrb')->group(function () {

        /**Create custom roles with assign permissions */
        Route::middleware([])->prefix('role-permissions')->group(function () {
            Route::get('/', [NtRoleBaseController::class, 'index'])->name('ntrb.index.role');
            Route::post('/manage', [NtRoleBaseController::class, 'manage'])->name('ntrb.manage.role');
            Route::post('/save', [NtRoleBaseController::class, 'save'])->name('ntrb.save.role');
            Route::delete('/delete', [NtRoleBaseController::class, 'delete'])->name('ntrb.delete.role');

            /**Permisssions */
            Route::post('/permission', [NtRoleBaseController::class, 'manage_role_permission'])->name('ntrb.permission.role');
            Route::post('/permission-save', [NtRoleBaseController::class, 'save_role_permission'])->name('ntrb.save.permission.role');
        });

        Route::middleware([])->prefix('system-users')->group(function () {
            Route::get('/{parentId?}', [NtRoleBaseController::class, 'index_managing_user'])->name('ntrb.index-managing-user');
            Route::post('/manage', [NtRoleBaseController::class, 'manage_manging_user'])->name('ntrb.manage.managing-user');
            Route::post('/save', [NtRoleBaseController::class, 'save_managing_user'])->name('.ntrb.save.managing-user');
            Route::delete('/delete', [NtRoleBaseController::class, 'delete_managing_user'])->name('ntrb.delete.managing-user');
            Route::get('/manage-user/child-users', [NtRoleBaseController::class, 'get_child_and_parent_users'])->name('ntrb.child-parent-managing-user');
            Route::get('/breadcrumb/list/{parentId?}', [NtRoleBaseController::class, 'get_managing_child_parent_breadcrumb'])->name('ntrb.managing-child-parent-breadcrumb');
            Route::post('/permission', [NtRoleBaseController::class, 'get_managing_user_permission'])->name('ntrb.permission.managing-user');
        });

    });

});
