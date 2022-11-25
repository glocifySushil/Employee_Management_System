<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
        
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->unsignedTinyInteger('employee_id')->nullable();
        $table->unsignedTinyInteger('designation_id')->nullable();
        $table->unsignedTinyInteger('department_id')->nullable();
        $table->unsignedTinyInteger('employee_status_id')->nullable();
        $table->string('gender')->nullable();
        $table->longText('about_me')->nullable();
        $table->integer('contact_number')->nullable();
        $table->integer('emergency_contact_number')->nullable();
        $table->longText('Address')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->string('profile_picture', 500)->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->unsignedTinyInteger('role_id');
        $table->string('password');
        $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
