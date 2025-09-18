<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('region_id')->nullable()->constrained('tags')->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('tags')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('region_id');
            $table->dropConstrainedForeignId('company_id');
        });
    }
};
