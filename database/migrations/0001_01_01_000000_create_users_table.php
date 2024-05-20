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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique()->nullable();
            $table->integer('code')->nullable();
            $table->tinyInteger('is_verified')->default(false);
            $table->string('password')->nullable();
            $table->tinyInteger('is_admin')->default(false);
            $table->string('photo')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

//        Schema::create('providers', function (Blueprint $table) {
//            $table->id();
//            $table->string('provider_id');
//            $table->string('provider_token')->nullable();
//            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
//            $table->timestamps();
//        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
