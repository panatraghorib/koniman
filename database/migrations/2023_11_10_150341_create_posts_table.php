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
        Schema::create(config('apptra.database.prefix') . 'posts', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('intro')->nullable();
            $table->text('content')->nullable();
            $table->string('type')->nullable();
            $table->integer('category_id')->unsigned()->nullable();

            $table->integer('is_featured')->default(0); // for hero
            $table->string('featured_image')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_og_image')->nullable();
            $table->string('meta_og_url')->nullable();
            // SEO


            $table->integer('hits')->default(0)->unsigned();
            $table->integer('order')->nullable();
            $table->tinyInteger('status')->default(1); //Publish, Unpublish, Draft
            $table->tinyInteger('approval')->default(0)->unsigned();// Approve, Reject to show on public

            $table->integer('moderated_by')->unsigned()->nullable();
            $table->datetime('moderated_at')->nullable();

            $table->integer('created_by')->unsigned()->nullable();
            $table->string('created_by_name')->nullable();
            $table->string('created_by_alias')->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('apptra.database.prefix') . 'posts');
    }
};