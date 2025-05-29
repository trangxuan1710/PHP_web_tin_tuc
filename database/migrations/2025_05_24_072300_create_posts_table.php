<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // <- BẮT BUỘC để làm khóa chính
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
