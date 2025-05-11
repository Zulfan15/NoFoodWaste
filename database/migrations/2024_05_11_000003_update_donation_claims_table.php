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
        Schema::table('donation_claims', function (Blueprint $table) {
            // Add notes column for claim messages
            $table->text('notes')->nullable()->after('status');
            
            // Drop the claim_time column since it's redundant with created_at
            $table->dropColumn('claim_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donation_claims', function (Blueprint $table) {
            $table->dateTime('claim_time')->after('user_id');
            $table->dropColumn('notes');
        });
    }
};
