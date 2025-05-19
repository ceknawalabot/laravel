<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToLeaveRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->string('store')->nullable()->after('employee_id');
            $table->date('active_membership_date')->nullable()->after('store');
            $table->boolean('contract_extension_status')->default(false)->after('active_membership_date');
            $table->date('scheduled_return')->nullable()->after('contract_extension_status');
            $table->date('departure_date')->nullable()->after('scheduled_return');
            $table->date('return_date')->nullable()->after('departure_date');
        });
    }

    public function down()
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn([
                'store',
                'active_membership_date',
                'contract_extension_status',
                'scheduled_return',
                'departure_date',
                'return_date',
            ]);
        });
    }
}
