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
        // Only add columns/index if they don't already exist (make migration idempotent)
        if (!Schema::hasColumn('users', 'google_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('google_id')->nullable()->after('email');
            });
        }

        if (!Schema::hasColumn('users', 'avatar')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar')->nullable()->after('google_id');
            });
        }

        if (!Schema::hasColumn('users', 'google_id') || !Schema::hasColumn('users', 'avatar')) {
            // add index only if column exists and index is not present
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'google_id')) return;
                // avoid error if index already exists
                try {
                    $table->index('google_id');
                } catch (\Exception $e) {
                    // ignore index creation errors (index may already exist)
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'google_id')) {
                // drop index if exists (silently handle exceptions)
                try {
                    $table->dropIndex(['google_id']);
                } catch (\Exception $e) {
                }
            }

            $cols = [];
            if (Schema::hasColumn('users', 'google_id')) $cols[] = 'google_id';
            if (Schema::hasColumn('users', 'avatar')) $cols[] = 'avatar';
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
