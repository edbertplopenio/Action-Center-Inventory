<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('records', function (Blueprint $table) {
            $table->string('status')->default('active')->after('disposition');
        });
    }

    public function down() {
        Schema::table('records', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};