<?php

use App\Models\Amenity;
use App\Models\Venue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('amenity_venue', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Venue::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Amenity::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenity_venue');
    }
};
