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
        $hasColumn = Schema::hasColumn('users', 'division_id');

        Schema::table('users', function (Blueprint $table) use ($hasColumn) {
            if (!$hasColumn) {
                $table->foreignId('division_id')
                    ->nullable()
                    ->after('role')
                    ->constrained('divisions')
                    ->nullOnDelete();
                return;
            }

            // Column may already exist (e.g. from a previously failed migration),
            // so only add the FK constraint.
            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('users', 'division_id')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropColumn('division_id');
        });
    }
};

