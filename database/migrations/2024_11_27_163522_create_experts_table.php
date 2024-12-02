<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('experts', function (Blueprint $table) {
        $table->id();
        $table->string('full_name');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('profession');
        $table->string('date_of_birth');
        $table->string('address');
        $table->string('phone_number');
        $table->string('profile_image')->nullable(); // This will store the path to the profile image
        $table->string('role')->default('expert'); // Default role for the expert
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experts');
    }
};
