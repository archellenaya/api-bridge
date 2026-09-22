<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_endpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->nullable()->constrained('tenant_sources')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('method')->default('GET');
            $table->string('route');
            $table->json('transform')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_endpoints');
    }
};
