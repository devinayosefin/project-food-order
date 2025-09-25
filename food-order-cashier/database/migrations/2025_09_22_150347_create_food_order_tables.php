<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // MENU
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category');
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // CUSTOMER
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });

        // ORDERS
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->integer('total_price')->default(0);
            // otomatis sekarang
            $table->dateTime('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            // otomatis hanya tanggal hari ini
            $table->date('order_date_only')->default(DB::raw('CURRENT_DATE'));
            $table->integer('queue_number');
            $table->timestamps();
        });

        // ORDER DETAIL
        Schema::create('orderdetail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('menu_id');
            $table->integer('quantity');
            $table->integer('subtotal')->default(0);
            $table->timestamps();
        });

        // PAYMENT
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('cashier_id')->nullable();
            // otomatis isi saat insert kalau tidak diisi
            $table->dateTime('payment_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('payment_amount')->default(0);
            $table->enum('payment_status', ['Pending', 'Paid', 'Cancel'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payment');
        Schema::dropIfExists('orderdetail');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('menu');
    }
};
