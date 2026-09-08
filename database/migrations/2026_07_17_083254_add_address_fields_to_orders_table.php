<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('recipient_name')->nullable()->after('paymentMethod');
            $table->string('phone_number')->nullable()->after('recipient_name');
            $table->string('province')->nullable()->after('phone_number');
            $table->string('city')->nullable()->after('province');
            $table->string('district')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('district');
            $table->text('street_address')->nullable()->after('postal_code'); // Nama jalan, gedung, no rumah
            $table->text('address_detail')->nullable()->after('street_address'); // Detail lainnya (patokan, blok/unit, dll)
            $table->string('address_label')->default('Rumah')->after('address_detail'); // Rumah / Kantor / Lainnya
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'recipient_name',
                'phone_number',
                'province',
                'city',
                'district',
                'postal_code',
                'street_address',
                'address_detail',
                'address_label',
            ]);
        });
    }
};