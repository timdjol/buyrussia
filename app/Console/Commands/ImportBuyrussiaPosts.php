<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportBuyrussiaPosts extends Command
{
    protected $signature = 'buyrussia:import-posts {--limit=0}';

    protected $description = 'Import posts from wordpress custom CMS to Laravel posts table';

    public function handle()
    {
        $limit = (int)$this->option('limit');

        $query = DB::connection('wordpress')
            ->table('tmp_table_1')
            ->orderBy('tmp1_field_1');

        if ($limit > 0) {
            $query->limit($limit);
        }

        $this->info('Import started...');

        $query->chunk(100, function ($rows) {

            foreach ($rows as $row) {

                // URL
                $url = DB::connection('wordpress')
                    ->table('tmp_table_2')
                    ->where('tmp2_field_6', $row->tmp1_field_1)
                    ->value('tmp2_field_2');

                // Featured image
                $image = DB::connection('wordpress')
                    ->table('tmp_table_6')
                    ->where('tmp6_field_2', $row->tmp1_field_1)
                    ->where('tmp6_field_9', 'Y')
                    ->selectRaw("CONCAT('/upload/', tmp6_field_4, tmp6_field_3) as img")
                    ->value('img');

                // Publish datetime
                $publishedAt = null;
                if ($row->tmp1_field_24 !== '0000-00-00') {
                    $publishedAt = $row->tmp1_field_24 . ' ' . ($row->tmp1_field_25 ?? '00:00:00');
                }

                DB::table('buyrussia.posts')->updateOrInsert(
                    ['id' => $row->tmp1_field_1],
                    [
                        'title'       => $row->tmp1_field_2,
                        'code'        => 'news-' . $row->tmp1_field_1,
                        'description' => $row->tmp1_field_4,
                        'image'       => $image,
                        'url'         => $url,
                        'user_id'     => 1,
                        'created_at'  => $publishedAt ?? now(),
                        'updated_at'  => now(),
                    ]
                );
            }
        });

        $this->info('Import finished successfully ✔');
        return Command::SUCCESS;
    }
}
