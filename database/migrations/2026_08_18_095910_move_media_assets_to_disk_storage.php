<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Moves media storage from base64-in-database to real files on the
     * "public" disk (storage/app/public). New uploads are written straight
     * to disk by the updated storeUploadedImage() helper; this migration
     * also backfills every image that was already saved as base64 so the
     * database actually shrinks instead of just stopping growth.
     *
     * Safe to run on an empty media_assets table too - the backfill loop
     * simply does nothing if there are no old base64 rows.
     */
    public function up(): void
    {
        Schema::table('media_assets', function (Blueprint $table) {
            $table->longText('binary_data')->nullable()->change();
        });

        DB::table('media_assets')
            ->whereNotNull('binary_data')
            ->where('binary_data', '!=', '')
            ->orderBy('id')
            ->cursor()
            ->each(function ($row): void {
                $path = $row->disk_name;

                if (! Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->put($path, base64_decode($row->binary_data));
                }

                DB::table('media_assets')->where('id', $row->id)->update(['binary_data' => null]);
            });
    }

    /**
     * Reversing this would mean re-encoding every file on disk back into
     * base64 in the database - which is exactly the problem we're fixing,
     * so the down() intentionally only reverts the schema change, not the
     * data. Files already moved to disk are left as-is.
     */
    public function down(): void
    {
        Schema::table('media_assets', function (Blueprint $table) {
            $table->longText('binary_data')->nullable(false)->default('')->change();
        });
    }
};