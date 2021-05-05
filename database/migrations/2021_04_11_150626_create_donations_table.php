<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedbigInteger('requisition_id')->nullable();
            $table->foreign('requisition_id')->references('id')->on('requisitions');
            $table->tinyInteger('type')->default(1)->comment('1=blood,2=others/plazma');//Type of donation blood plazma etc.
            $table->tinyInteger('unit')->default(1);
            $table->unsignedbigInteger('approver_id')->nullable();
            $table->foreign('approver_id')->references('id')->on('users');
            $table->string('comment')->nullable();
            $table->datetime('date');
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
        Schema::dropIfExists('donations');
    }
}
