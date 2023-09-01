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
        Schema::connection('mysql_command')->dropIfExists('product_commands');
        Schema::connection('mysql_command')->create('product_commands', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('price');
            $table->integer('stock');
            $table->string('sku')->unique();
            $table->uuid('category_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_command')->dropIfExists('product_commands');
    }
};
