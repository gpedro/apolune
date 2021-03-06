<?php

namespace Apolune\Account\Resources\Migrations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Apolune\Core\Facades\Database\Trigger;
use Illuminate\Database\Migrations\Migration;

class CreatePandaacAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__pandaac_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->char('recovery_key', 40)->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_date')->nullable();
            $table->tinyInteger('email_requests')->unsigned()->default(0);
            $table->string('email_code', 100)->nullable();
            $table->timestamp('deleted')->nullable()->default('0000-00-00 00:00:00');
            $table->rememberToken();
            $table->timestamps();
        });

        Trigger::after('insert')->on('accounts')->create(function ($query) {
            $query->table('__pandaac_accounts')->insert([
                'account_id' => DB::raw('NEW.`id`')
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Trigger::after('insert')->on('accounts')->rollback();

        Schema::drop('__pandaac_accounts');
    }
}
