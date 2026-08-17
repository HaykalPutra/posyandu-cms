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
        Schema::table('cms_pages', function (Blueprint $table): void {
            $table->foreignId('hero_media_asset_id')->nullable()->after('hero_image')->constrained('media_assets')->nullOnDelete();
        });

        Schema::table('posts', function (Blueprint $table): void {
            $table->foreignId('cover_media_asset_id')->nullable()->after('cover_image')->constrained('media_assets')->nullOnDelete();
        });

        Schema::table('gallery_items', function (Blueprint $table): void {
            $table->foreignId('image_media_asset_id')->nullable()->after('image_url')->constrained('media_assets')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('image_media_asset_id');
        });

        Schema::table('posts', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('cover_media_asset_id');
        });

        Schema::table('cms_pages', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('hero_media_asset_id');
        });
    }
};
