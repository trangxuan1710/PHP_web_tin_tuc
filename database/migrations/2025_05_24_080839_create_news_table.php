<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('views')->default(0);
            $table->unsignedBigInteger('userId')->nullable(); // Giả sử userId là khoá ngoài
            $table->dateTime('date')->nullable();
            $table->string('tag')->nullable();
            $table->text('content')->nullable();
            $table->string('thumbNailUrl')->nullable();
            $table->boolean('isHot')->default(false);
            $table->unsignedBigInteger('labelId')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};
