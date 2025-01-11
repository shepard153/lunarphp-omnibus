<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historical_prices', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('priceable_id')->index();
            $table->string('priceable_type')->index();
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('customer_group_id')->nullable();
            $table->unsignedBigInteger('price');
            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historical_prices');
    }
};
