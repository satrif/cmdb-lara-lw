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
        Schema::create('cmdb_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('cmdb_items')->onDelete('cascade');
            $table->foreignId('child_id')->constrained('cmdb_items')->onDelete('cascade');
            $table->string('relationship_type'); // contains, depends_on, licensed_to, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cmdb_relationships');
    }
};
