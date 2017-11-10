<?php

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

Manager::schema()->create('giftlist', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('description');
    $table->string('token');
    $table->date('date');
    $table->string('recipient');
    $table->unsignedInteger('user_id');
    $table->timestamps();
    $table->foreign('user_id')->references('id')->on('user');
});

Manager::schema()->create('gift', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('giftlist_id');
    $table->string('name');
    $table->string('url')->nullable();
    $table->string('description')->nullable();
    $table->float('price');
    $table->string('picture')->nullable();
    $table->boolean('booked');
    $table->timestamps();
    $table->foreign('giftlist_id')->references('id')->on('giftlist');
});

Manager::schema()->create('commentlist', function (Blueprint $table) {
    $table->increments('id');
    $table->string('author');
    $table->string('content');
    $table->unsignedInteger('giftlist_id');
    $table->timestamps();
    $table->foreign('giftlist_id')->references('id')->on('giftlist');
});

Manager::schema()->create('commentgift', function (Blueprint $table) {
    $table->increments('id');
    $table->string('author');
    $table->string('content');
    $table->unsignedInteger('gift_id');
    $table->timestamps();
    $table->foreign('gift_id')->references('id')->on('gift');
});
