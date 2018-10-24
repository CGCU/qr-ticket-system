<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnionProductsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('union_products', function (Blueprint $table) {
      $table->integer('id'); // ID from Union shop
      $table->primary('id');
      $table->integer('event_id');
      $table->foreign('event_id')->references('id')->on('events');
      $table->date('last_imported')->nullable();
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
    Schema::drop('union_products');
  }
}
