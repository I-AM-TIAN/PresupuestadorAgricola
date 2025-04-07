<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cost_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('quantity');
            $table->decimal('margin', 5, 2)->default(0);
            $table->json('materials');
            $table->json('labor');
            $table->json('indirect');
            $table->decimal('total_cost', 10, 2);
            $table->decimal('unit_price', 10, 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cost_sheets');
    }
};

