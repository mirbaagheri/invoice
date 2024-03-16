<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationMirinvoice extends Migration
{
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->integer('id',)->unsigned();
            $table->string('description', 512)->nullable();
            $table->integer('status',)->default('0');
            $table->bigInteger('price',)->default('0');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

        });

        Schema::create('invoice_callback', function (Blueprint $table) {
            $table->integer('id',);
            $table->integer('invoice_id',)->unsigned();
            $table->string('url',128);

        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->integer('id',)->unsigned();
            $table->integer('invoice_id',)->unsigned();
            $table->string('item_info',1024)->nullable();
            $table->bigInteger('price',)->default('0');
            $table->bigInteger('quantity',)->default('1');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

        });

        Schema::create('invoice_item_product', function (Blueprint $table) {

            $table->integer('id',);
            $table->integer('item_id',)->unsigned();
            $table->integer('product_id',)->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

        });

        Schema::create('invoice_tracking_id', function (Blueprint $table) {
            $table->string('id',32);
            $table->integer('invoice_id',)->unsigned();

        });

        Schema::create('invoice_user', function (Blueprint $table) {
            $table->integer('id',)->unsigned();
            $table->integer('invoice_id',)->unsigned();
            $table->integer('user_id',)->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice');
        Schema::dropIfExists('invoice_callback');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoice_item_product');
        Schema::dropIfExists('invoice_tracking_id');
        Schema::dropIfExists('invoice_user');
    }
}
