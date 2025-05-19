<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('bank')->nullable()->after('position_id');
            $table->string('account_number')->nullable()->after('bank');
            $table->date('active_membership_date')->nullable()->after('account_number');
            $table->date('passport_expiry_date')->nullable()->after('active_membership_date');
            $table->date('visa_expiry_date')->nullable()->after('passport_expiry_date');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'bank',
                'account_number',
                'active_membership_date',
                'passport_expiry_date',
                'visa_expiry_date',
            ]);
        });
    }
}
