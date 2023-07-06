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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('type');
            $table->string('class');
            $table->boolean('is_required');
            $table->boolean('is_multiple');
            $table->json('options')->nullable();
            $table->boolean('is_active');
            $table->foreignId('dynamic_form_id')->constrained('dynamic_forms');
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
        Schema::dropIfExists('fields');
    }
};
