<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_has_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable()->index()->references('id')->on('users')->onDelete('cascade');
            $table->uuid('role_id')->nullable()->index()->references('id')->on('roles')->onDelete('cascade');
            $table->string('role_name')->nullable();
            $table->boolean('is_deleted')->nullable()->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_has_roles');
    }
};
