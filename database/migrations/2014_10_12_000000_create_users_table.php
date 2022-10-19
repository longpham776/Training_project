<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id',true);
            $table->string('name',255)->nullable(false);
            $table->string('email',255)->unique()->nullable(false);
            $table->string('password',255)->nullable(false);
            $table->rememberToken()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('is_active')->default(1)->nullable(false)->comment('0: Không hoạt động, 1: Hoạt động');
            $table->tinyInteger('is_delete')->default(0)->nullable(false)->comment('0: Bình thường, 1: Đã xóa');
            $table->string('group_role',50)->nullable();
            $table->timestamp('last_login_at')->nullable(false);
            $table->string('last_login_ip',40)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
