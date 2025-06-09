<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('n_doc', 50)->unique()->nullable();
            $table->string('school_year')->nullable();
            $table->string('section')->nullable();
            $table->double('matricula', 15, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->enum('status', [
                'ACTIVE', 'INACTIVE','RETIRED','GRADUATED'
                ])->default('INACTIVE');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('representantes')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
