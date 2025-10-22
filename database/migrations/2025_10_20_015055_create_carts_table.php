<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // simple cart items table (each row = product added by user)
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(1); // spec: user_id hardcoded to 1 in API
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->index(['user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
