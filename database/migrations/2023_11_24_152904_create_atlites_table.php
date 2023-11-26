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
        Schema::create(config('apptra.database.prefix') . 'atlites', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->default(0);
            $table->string('atlet_name');
            $table->string('gender');
            $table->date('date_of_birth')->nullable();
            $table->date('place_of_birth')->nullable();
            $table->text('address');
            $table->string('height');
            $table->string('weight');
            $table->string('mobile', 20)->unique()->nullable();
            $table->string('email')->unique();
            $table->string('photo')->nullable()->default('img/default-avatar.jpg');
            $table->date('join_date')->nullable();
            $table->text('additional_info')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('apptra.database.prefix') . 'atlites');
    }
};
