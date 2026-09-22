<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_request_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source_name')->nullable();
            $table->string('endpoint_slug')->nullable();
            $table->unsignedInteger('status_code')->nullable();
            $table->json('request')->nullable();
            $table->json('response')->nullable();
            $table->datetime('occurred_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_request_logs');
    }
};
