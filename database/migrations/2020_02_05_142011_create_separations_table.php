<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeparationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('separations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->integer('supervisor_id')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->date('last_day_worked')->nullable();
            $table->string('department')->nullable();
            $table->date('separation_date')->nullable();
            $table->string('quit_terminated')->nullable();
            $table->string('type_of_notice')->nullable();
            $table->string('termination_type')->nullable();
            $table->string('disciplinary_action')->nullable();
            $table->string('level_of_severity')->nullable();
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('separations');
    }
}
