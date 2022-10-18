<?php

use App\Domains\Car\Enums\CarStatusEnum;
use App\Domains\Car\Enums\TransmissionEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->index();
            $table->year('year');
            $table->unsignedTinyInteger('type')->nullable();
            $table->unsignedTinyInteger('transmission')->default(TransmissionEnum::AUTOMATIC->value);
            $table->unsignedTinyInteger('status')->default(CarStatusEnum::AVAILABLE->value)->index();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('model_id')->references('id')->on('car_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }

};
