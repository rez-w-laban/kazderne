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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->timestamps();
        });


        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('city_name');
            $table->string('description')->nullable();
            $table->string('location')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();
        });

        Schema::create('city_pictures', function (Blueprint $table) {
            $table->id();
            $table->string('media')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->string('picture')->nullable();
            $table->unsignedBigInteger('likes_count');
            $table->unsignedBigInteger('comments_count');
            $table->unsignedBigInteger('rate_count');
            $table->unsignedBigInteger('rate_sum');
            $table->double('average_rate');
            $table->string('location')->nullable();
            $table->unsignedBigInteger('activity_type_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('activity_type_id')->references('id')->on('activity_types')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('activity_pictures', function (Blueprint $table) {
            $table->id();
            $table->string('media')->nullable();
            $table->unsignedBigInteger('activity_id');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('comment_id');
            $table->boolean('is_reply');
            $table->foreign('comment_id')->references('id')->on('comments')->nullable()->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rating');
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('followings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('following_id');
            $table->unsignedBigInteger('follower_id');
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('city_pictures');
        Schema::dropIfExists('activity_types');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('activity_pictures');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('followings');
    }
};
