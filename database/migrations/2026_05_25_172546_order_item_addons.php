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
        Schema::create('order_item_addons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_item_id');

            $table->foreignId('addon_id');

            $table->integer('quantity')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
    }
};
