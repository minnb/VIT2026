<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Images;

/**
 * Bang `images` gan nhu khong duoc dung: anh dai dien thuc te duoc boc bang
 * regex tu HTML CKEditor moi lan render. Lenh nay dua anh dau tien cua tung
 * bai viet vao bang `images` de no tro thanh du lieu quan he that.
 */
class SyncImagesFromContent extends Command
{
    protected $signature = 'images:sync-from-content
                            {--dry-run : Chi in ra nhung gi se ghi, khong dung DB}';

    protected $description = 'Boc anh dau tien trong posts.content va ghi vao bang images';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $existing = DB::table('images')->pluck('post_id')->all();

        $created = 0;
        $skipped = 0;

        DB::table('posts')
            ->select('id', 'title', 'content')
            ->orderBy('id')
            ->chunk(50, function ($posts) use (&$created, &$skipped, $existing, $dryRun) {
                foreach ($posts as $post) {
                    if (in_array($post->id, $existing)) {
                        $skipped++;
                        continue;
                    }

                    $image = getImageInContent($post->content);

                    if ($image === '' || strpos($image, 'logoVIT.png') !== false) {
                        $skipped++;
                        continue;
                    }

                    $this->line(sprintf('#%d %s -> %s', $post->id, mb_substr($post->title, 0, 40), $image));

                    if (! $dryRun) {
                        Images::create([
                            'post_id' => $post->id,
                            'image'   => $image,
                            'thumb'   => '',
                            'alias'   => mb_substr($post->title, 0, 190),
                            'sort'    => 0,
                        ]);
                    }

                    $created++;
                }
            });

        $this->info(sprintf(
            '%s: %d ban ghi anh, bo qua %d bai.',
            $dryRun ? 'THU (dry-run)' : 'Da ghi',
            $created,
            $skipped
        ));

        return 0;
    }
}
