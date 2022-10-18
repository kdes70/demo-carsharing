<?php

use App\Domains\Rentals\Enums\RentalsStatusEnum;
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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id');
            $table->foreignId('user_id')->unique();

            $table->text('comment')->nullable();
            $table->unsignedTinyInteger('status')->default(
              RentalsStatusEnum::AVAILABLE->value
            );
            $table->dateTime('rent_start')->default(\Carbon\Carbon::now());
            $table->dateTime('rent_end');
            $table->timestamps();

            $table->index(['user_id', 'car_id']);
            $table->unique(['user_id', 'car_id']);

            $table->foreign('car_id')
              ->references('id')
              ->on('cars')
              ->onDelete('cascade');

            $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }

};
