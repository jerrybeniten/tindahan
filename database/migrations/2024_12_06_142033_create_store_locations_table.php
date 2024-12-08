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
        Schema::create('store_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->uuid('uuid');
            $table->string('location_name'); // Store name
            $table->string('store_code')->unique(); // Unique identifier for the store
            $table->string('manager_name')->nullable(); // Optional store manager name
            $table->string('email')->nullable(); // Contact email
            $table->string('phone')->nullable(); // Contact phone

            // Address fields
            $table->string('address_line1'); // Street address
            $table->string('address_line2')->nullable(); // Optional secondary address
            $table->string('city');
            $table->string('state')->nullable(); // State or province
            $table->string('zip_code')->nullable();
            $table->string('country')->default('Philippines'); // Default to a specific country

            // Geolocation
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Status and other details
            $table->boolean('is_active')->default(true); // Active/inactive status
            $table->json('opening_hours')->nullable(); // Store hours in JSON
            
            $table->softDeletes(); // Deleted timestamp for soft deletes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_locations');
    }
};
