<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('name', 50)->index();
            $table->tinyInteger('area');
            $table->tinyInteger('type');
            $table->string('detail', 300)->nullable();
            $table->date('purchasedate')->nullable(); //購入した日
            $table->date('dumpdate')->nullable(); //「捨てたモノ一覧」に移動した日
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
