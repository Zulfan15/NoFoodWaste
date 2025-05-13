<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ensure donation_claims table has claim_time column
        if (Schema::hasTable('donation_claims') && !Schema::hasColumn('donation_claims', 'notes')) {
            Schema::table('donation_claims', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('status');
            });
        }

        // Fix the sequence of operations for leaderboard stats
        // This ensures we have the proper structure for calculating stats
        DB::statement('
            CREATE OR REPLACE VIEW vw_donor_stats AS
            SELECT 
                u.user_id,
                u.username,
                u.role,
                COALESCE(SUM(d.quantity), 0) as total_donated,
                COUNT(d.donation_id) as donation_count
            FROM users u
            LEFT JOIN donations d ON u.user_id = d.user_id
            WHERE u.role = "donator"
            GROUP BY u.user_id, u.username, u.role
        ');

        DB::statement('
            CREATE OR REPLACE VIEW vw_recipient_stats AS
            SELECT 
                u.user_id,
                u.username,
                u.role,
                COALESCE(COUNT(dc.claim_id), 0) as total_claims
            FROM users u
            LEFT JOIN donation_claims dc ON u.user_id = dc.user_id
            WHERE u.role = "penenrima"
            GROUP BY u.user_id, u.username, u.role
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS vw_donor_stats');
        DB::statement('DROP VIEW IF EXISTS vw_recipient_stats');
    }
};
