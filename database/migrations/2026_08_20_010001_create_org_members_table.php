<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('org_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_group_id')->constrained('org_groups')->cascadeOnDelete();
            $table->string('name');
            $table->string('position');
            $table->foreignId('photo_media_asset_id')->nullable()->constrained('media_assets')->nullOnDelete();
            $table->string('photo_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('org_members');
    }
};
