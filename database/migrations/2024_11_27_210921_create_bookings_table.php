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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('expert_id');
        $table->string('expert_name');
        $table->string('user_name');
        $table->string('status')->default('Pending');
        $table->timestamp('timestamp')->useCurrent();
        $table->text('note')->nullable();
        $table->string('rate')->nullable();
        $table->string('expert_address');
        $table->string('expert_image_url')->nullable();
        $table->string('user_address');
    

        // Foreign keys to link to users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('expert_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
