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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('managerId')->nullable(); // Foreign key cho Managers
            $table->dateTime('date')->nullable(); // Thay thế created_at/updated_at bằng 'date'
            $table->string('tag')->nullable();     // Thẻ, có thể dùng để tìm kiếm
            $table->text('content');               // Nội dung bài viết (thay thế description)
            $table->string('status')->default('published'); // Trạng thái bài viết
            $table->string('thumbNailUrl')->nullable(); // URL ảnh thumbnail (thay thế image_url)
            $table->boolean('isHot')->default(false); // Bài viết hot
            $table->unsignedBigInteger('labelId')->nullable(); // Foreign key cho Labels

            // Định nghĩa các khóa ngoại
            $table->foreign('managerId')->references('id')->on('managers')->onDelete('set null');
            $table->foreign('labelId')->references('id')->on('labels')->onDelete('set null');

            // Không cần timestamps() vì bạn đã tắt nó trong Model
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
