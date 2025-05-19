<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            $table->json('submission_data');
            $table->string('slug')->unique();
            $table->timestamps();

            // Removed unique constraint involving employee_id as it is removed
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_submissions');
    }
}
