<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds a `deleted_at` column to every content table so "Hapus" becomes
     * a soft delete (moved to Sampah / Trash) instead of a permanent,
     * unrecoverable delete. Records only disappear for good when an admin
     * explicitly empties them from the Sampah page.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('carousel_items', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('cms_pages', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('carousel_items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('cms_pages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
