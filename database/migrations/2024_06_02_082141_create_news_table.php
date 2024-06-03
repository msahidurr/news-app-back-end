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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('author')->nullable();
            $table->integer('status')->comment('1: draft, 2: pending, 3: publish, 4: change_request, 5: reject');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('published_by')->references('id')->on('users');
        });

        Schema::create('news_category_maps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('news_category_id');
            $table->timestamps();

            $table->foreign('news_id')->references('id')->on('news')->cascadeOnDelete();
            $table->foreign('news_category_id')->references('id')->on('news_categories')->cascadeOnDelete();
        });

        Schema::create('news_tag_maps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('news_tag_id');
            $table->timestamps();

            $table->foreign('news_id')->references('id')->on('news')->cascadeOnDelete();
            $table->foreign('news_tag_id')->references('id')->on('news_tags')->cascadeOnDelete();
        });

        Schema::create('news_visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('user_id');
            $table->ipAddress('visitor')->nullable();
            $table->timestamps();

            $table->foreign('news_id')->references('id')->on('news')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_tag_maps');
        Schema::dropIfExists('news_visitors');
        Schema::dropIfExists('news_category_maps');
    }
};
