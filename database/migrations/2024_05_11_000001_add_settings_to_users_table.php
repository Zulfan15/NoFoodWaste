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
        Schema::table('users', function (Blueprint $table) {
            // Add bio column
            $table->text('bio')->nullable()->after('address');
            
            // Add notification settings
            $table->boolean('email_notifications')->default(true)->after('bio');
            $table->boolean('donation_alerts')->default(true)->after('email_notifications');
            $table->boolean('claim_updates')->default(true)->after('donation_alerts');
            $table->boolean('news_updates')->default(false)->after('claim_updates');
            
            // Add privacy settings
            $table->boolean('profile_visibility')->default(true)->after('news_updates');
            $table->boolean('location_sharing')->default(true)->after('profile_visibility');
            $table->boolean('activity_tracking')->default(false)->after('location_sharing');
            
            // Add account settings
            $table->string('language')->default('id')->after('activity_tracking');
            $table->string('timezone')->default('Asia/Jakarta')->after('language');
            $table->boolean('two_factor_auth')->default(false)->after('timezone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'email_notifications',
                'donation_alerts',
                'claim_updates',
                'news_updates',
                'profile_visibility',
                'location_sharing',
                'activity_tracking',
                'language',
                'timezone',
                'two_factor_auth'
            ]);
        });
    }
};
