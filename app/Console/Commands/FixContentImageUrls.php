<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * 194/194 the <img> trong posts.content dang la URL tuyet doi
 * http://vitduct.com.vn/... - khoa cung ten mien va gay mixed content
 * khi site chay HTTPS. Lenh nay doi chung ve duong dan tuong doi.
 */
class FixContentImageUrls extends Command
{
    protected $signature = 'content:fix-image-urls
                            {--dry-run : Chi dem va in ra, khong ghi DB}';

    protected $description = 'Doi URL tuyet doi cua ten mien cu trong posts.content thanh duong dan tuong doi';

    public function handle()
    {
        $dryRun  = $this->option('dry-run');
        $domains = config('upload.legacy_domains', []);

        if (empty($domains)) {
            $this->error('config/upload.php chua khai legacy_domains.');

            return 1;
        }

        $changedPosts = 0;
        $changedUrls  = 0;

        DB::table('posts')->select('id', 'content')->orderBy('id')->chunk(25, function ($posts) use (&$changedPosts, &$changedUrls, $domains, $dryRun) {
            foreach ($posts as $post) {
                $content = $post->content;
                $hits    = 0;

                foreach ($domains as $domain) {
                    $content = str_replace($domain . '/', '/', $content, $count);
                    $hits += $count;
                }

                if ($hits === 0) {
                    continue;
                }

                $changedPosts++;
                $changedUrls += $hits;

                $this->line(sprintf('#%d: %d URL', $post->id, $hits));

                if (! $dryRun) {
                    DB::table('posts')->where('id', $post->id)->update(['content' => $content]);
                }
            }
        });

        $this->info(sprintf(
            '%s: %d bai viet, %d URL.',
            $dryRun ? 'THU (dry-run)' : 'Da sua',
            $changedPosts,
            $changedUrls
        ));

        return 0;
    }
}
