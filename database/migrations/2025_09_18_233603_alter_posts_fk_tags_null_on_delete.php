<?php
// php artisan make:migration alter_posts_fk_tags_null_on_delete --table=posts
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Сброс старых внешних ключей (имя у тебя может отличаться — try/catch не помешает)
            try { $table->dropForeign(['region_id']); } catch (\Throwable $e) {}
            try { $table->dropForeign(['company_id']); } catch (\Throwable $e) {}

            // Столбцы должны быть nullable, иначе SET NULL не сработает
            $table->unsignedBigInteger('region_id')->nullable()->change();
            $table->unsignedBigInteger('company_id')->nullable()->change();

            // Новые FK с ON DELETE SET NULL
            $table->foreign('region_id')->references('id')->on('tags')->nullOnDelete();
            $table->foreign('company_id')->references('id')->on('tags')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            try { $table->dropForeign(['region_id']); } catch (\Throwable $e) {}
            try { $table->dropForeign(['company_id']); } catch (\Throwable $e) {}

            // Вернуть как было (если у тебя были not null — поменяй на нужное)
            $table->unsignedBigInteger('region_id')->nullable(false)->change();
            $table->unsignedBigInteger('company_id')->nullable(false)->change();

            $table->foreign('region_id')->references('id')->on('tags');
            $table->foreign('company_id')->references('id')->on('tags');
        });
    }
};
