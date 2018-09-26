<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefferredOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defferred_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_from');
            $table->integer('user_id_to');
            $table->decimal('amount', 10, 2);
            $table->dateTime('operation_datetime');
            $table->boolean('operation_completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defferred_operations');
    }
}
