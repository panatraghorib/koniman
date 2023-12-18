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
        Schema::create(config('apptra.database.prefix') . 'settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('key')->nullable();
            $table->text('value')->nullable();
            $table->string('display_name')->nullable();
            $table->char('type', 20)->default('string');
            $table->text('details')->nullable();
            $table->integer('order')->default('1');
            $table->string('group')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('apptra.database.prefix') . 'settings');
    }
};