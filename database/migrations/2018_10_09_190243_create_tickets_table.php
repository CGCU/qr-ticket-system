<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('tickets', function (Blueprint $table) {
      $table->increments('id');

      $table->integer('event_id');
      $table->foreign('event_id')->references('id')->on('events');
      $table->integer('purchaser_id');
      $table->foreign('purchaser_id')->references('id')->on('attendees');
      $table->integer('attendee_id')->nullable()->unique();
      $table->foreign('attendee_id')->references('id')->on('attendees');
      $table->integer('union_product_id')->nullable();
      $table->foreign('union_product_id')->references('id')->on('products');

      $table->integer('order_number')->nullable();
      $table->string('qr');
      $table->boolean('email_sent');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('tickets');
  }
}
