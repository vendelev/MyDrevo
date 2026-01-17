<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_relationships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('relative_id');
            $table->enum('type', ['parent', 'child', 'spouse', 'sibling']);
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->foreign('person_id')->references('id')->on('family_members');
            $table->foreign('relative_id')->references('id')->on('family_members');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_relationships');
    }
};