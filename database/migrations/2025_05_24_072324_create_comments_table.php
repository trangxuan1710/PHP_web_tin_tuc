<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->dateTime('date');
            $table->integer('like_count')->default(0);
            $table->integer('dislike_count')->default(0);

            $table->unsignedBigInteger('commentId')->nullable();
            $table->foreign('commentId')->references('id')->on('comments')->onDelete('cascade');
//            $table->foreignId('user_id')->constrained()->onDelete('cascade');
//            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->foreignId('clientId')->constrained('clients')->onDelete('cascade');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
