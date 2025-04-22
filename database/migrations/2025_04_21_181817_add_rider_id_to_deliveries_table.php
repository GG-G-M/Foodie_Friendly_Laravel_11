<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRiderIdToDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->foreignId('rider_id')->constrained('users')->after('status'); // Add the rider_id column
        });
    }

    public function down()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn('rider_id'); // Remove the column on rollback
        });
    }
}
