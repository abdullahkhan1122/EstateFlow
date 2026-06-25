<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type')->index();
            $table->string('status')->default('draft')->index();
            $table->string('listing_type')->index();
            $table->decimal('price', 12, 2)->index();
            $table->unsignedInteger('bedrooms')->default(0)->index();
            $table->unsignedInteger('bathrooms')->default(0)->index();
            $table->unsignedInteger('area_sqft')->index();
            $table->string('address');
            $table->string('city')->index();
            $table->string('state')->index();
            $table->string('zip_code')->nullable();
            $table->text('description');
            $table->json('features')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
