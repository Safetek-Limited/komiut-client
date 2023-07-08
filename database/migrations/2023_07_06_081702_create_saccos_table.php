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
        Schema::create('saccos', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name")->unique();
            $table->string("phone_number");
            $table->string("motto");
            $table->string("pay_bill")->nullable();
            $table->string("consumer_key")->nullable();
            $table->string("consumer_secret")->nullable();
            $table->string("passkey")->nullable();
            $table->integer("status")->default(1);
            $table->unsignedInteger("created_by");
            $table->timestamps();

            $table->foreign("created_by")->references("id")->on("users")->onUpdate("CASCADE")->onDelete("RESTRICT");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saccos');
    }
};
