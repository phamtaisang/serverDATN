<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('gender')->nullable()->after('email');
            $table->string('address')->nullable()->after('email');
            $table->string('avatar')->default('https://lh3.googleusercontent.com/proxy/x5WpQTGAgqXtluNFk_xdkyUD1wzCwABKumdJpmOgUrpTpbmkjZpP4sIm3KqgLgGn9mq9EaXuKUDkWPXHvnzSo_S2BVmC7joTlRfHyyxwXg')->after('email');
            $table->string('cover')->nullable()->after('email');
            $table->string('description')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
