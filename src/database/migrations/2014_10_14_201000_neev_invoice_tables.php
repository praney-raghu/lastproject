<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NeevInvoiceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable(); // if not null, means that it is a part of a parent order
            $table->string('status'); // draft, pending, processing, active, shipped, complete, cancel_requested, canceled
            $table->boolean('shippable'); // If products needs to be physically shipped
            $table->boolean('recurring'); // If it is a recurring order

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->increments('id'); // required to uniquely identify each order item
            $table->integer('order_id')->unsigned();
            $table->integer('product_id')->unsigned()->nullable(); // if null, it is not a standard product

            // Product details entered again for maintaing order consistency, in case, product details are changed in future
            $table->string('name');
            $table->string('description');
            $table->decimal('cost', 13, 2);
            $table->decimal('qty', 13, 2)->nullable();
            $table->string('unit');
            $table->string('hsn');
            $table->string('type');

            $table->boolean('shippable'); // If products needs to be physically shipped
            $table->boolean('recurring'); // If it is a recurring order

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned();
            $table->string('status'); // draft, unpaid, partial, paid, canceled 

            $table->date('invoice_date');
            $table->string('invoice_number');
            $table->string('po_number');
            $table->date('due_date');

            $table->string('bill_name');
            $table->string('bill_address');
            $table->string('bill_state');
            $table->string('bill_country');
            $table->string('bill_zip');
            $table->string('bill_taxcode_name');
            $table->string('bill_taxcode_number');
            $table->string('bill_field_name_1');
            $table->string('bill_field_value_1');
            $table->string('bill_field_name_2');
            $table->string('bill_field_value_2');
            $table->string('ship_name');
            $table->string('ship_address');
            $table->string('ship_state');
            $table->string('ship_country');
            $table->string('ship_zip');
            $table->string('ship_taxcode_name');
            $table->string('ship_taxcode_number');
            $table->string('ship_field_name_1');
            $table->string('ship_field_value_1');
            $table->string('ship_field_name_2');
            $table->string('ship_field_value_2');
            $table->string('seller_name');
            $table->string('seller_address');
            $table->string('seller_state');
            $table->string('seller_country');
            $table->string('seller_zip');
            $table->string('seller_taxcode_name');
            $table->string('seller_taxcode_number');
            $table->string('seller_field_name_1');
            $table->string('seller_field_value_1');
            $table->string('seller_field_name_2');
            $table->string('seller_field_value_2');

            $table->text('item_description');
            $table->text('slug');
            
            $table->decimal('amount', 13, 2);
            $table->string('currency');
            $table->decimal('amount_base_currency', 13, 2);
            $table->string('base_currency');
            $table->decimal('currency_rate', 15, 8);

            $table->text('terms');
            $table->text('footer');
            $table->text('private_notes');

            $table->boolean('visible')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
        });

        Schema::create('invoice_order', function (Blueprint $table) {
            $table->integer('invoice_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        //Schema::dropIfExists('product_description');
    }
}
