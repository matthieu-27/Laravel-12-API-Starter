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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->text('product_name')->nullable();
            $table->date('date');
            $table->decimal('price', 8, 2);
            $table->string('platform', 50);
            $table->integer('quantity');
            $table->decimal('total', 8, 2)->nullable();
            $table->string('product_id')->nullable();
            $table->bigInteger('gencode')->nullable();
            $table->string('name', 50);
            $table->string('adress', 255);
            $table->string('country', 50);
            $table->string('status')->default('pending');
            $table->string('tracking_number')->nullable();
            $table->string('tracking_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
