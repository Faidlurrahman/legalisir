<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // kolom nama
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps(); // penting: agar created_at & updated_at ada
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
