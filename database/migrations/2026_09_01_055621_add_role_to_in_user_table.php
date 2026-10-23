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
        Schema::table('users', function (Blueprint $table) {
            //default : untuk membuat role secara default user.
            $table->enum('role', ['admin', 'user'])->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   //dropColumn : untuk menghapus kolom role pada tabel users.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
