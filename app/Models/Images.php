<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use DB;

class Images extends Model
{
  protected $table = "images";

  protected $fillable = ['post_id', 'image', 'thumb', 'alias', 'sort'];

  protected $casts = [
    'post_id' => 'int',
    'sort'    => 'int',
  ];

  /**
   * Bai viet chua anh nay.
   */
  public function post()
  {
    return $this->belongsTo(Post::class, 'post_id');
  }

  /**
   * Bo nho dem trong pham vi mot request: [post_id => duong dan anh].
   *
   * @var array
   */
  protected static $imageCache = [];

  public static function checkImageProduct($post_id){
    if (array_key_exists($post_id, self::$imageCache)) {
      return self::$imageCache[$post_id];
    }

  	$image = '';
    try{
      $check = DB::table('images')->where('post_id',$post_id)->orderBy('sort')->orderBy('id')->first();
      if(isset($check)){
        $image = $check->image;
      }else{
        $post = DB::table('posts')->where('id',$post_id)->get();
        if($post->count()>0){
          $image = getImageInContent($post[0]->content);
        }
      }
    }catch (\Exception $e) {
        $image = '';
    }

    $image = getImage($image);
    self::$imageCache[$post_id] = $image;

    return $image; 	
  }

  /**
   * Anh dai dien cho NHIEU bai viet bang MOT truy van (chong N+1).
   *
   * Bai nao chua co ban ghi trong bang `images` thi boc anh dau tien
   * trong noi dung CKEditor - van chi mot truy van cho ca danh sach.
   *
   * @param  array  $postIds
   * @return array  [post_id => duong dan anh]
   */
  public static function firstImageForMany(array $postIds)
  {
    $postIds = array_values(array_unique(array_filter($postIds)));

    if (empty($postIds)) {
      return [];
    }

    $images = [];

    foreach (DB::table('images')->whereIn('post_id', $postIds)->orderBy('sort')->orderBy('id')->get() as $row) {
      if (! isset($images[$row->post_id])) {
        $images[$row->post_id] = getImage($row->image);
      }
    }

    $missing = array_diff($postIds, array_keys($images));


    if (! empty($missing)) {
      foreach (DB::table('posts')->whereIn('id', $missing)->get(['id', 'content']) as $row) {
        $images[$row->id] = getImage(getImageInContent($row->content));
      }
    }

    // Nap luon vao bo nho dem de cac view goi checkImageProduct() khong query lai.
    self::$imageCache = $images + self::$imageCache;

    return $images;
  }

  /**
   * Nap truoc anh dai dien cho mot danh sach bai viet (chong N+1 o khu public).
   *
   * @param  array|\Illuminate\Support\Collection  $posts
   * @return void
   */
  public static function warmCacheFor($posts)
  {
    $ids = [];

    foreach ($posts as $post) {
      if (is_array($post) && isset($post['id'])) {
        $ids[] = $post['id'];
      } elseif (is_object($post) && isset($post->id)) {
        $ids[] = $post->id;
      }
    }

    $ids = array_diff($ids, array_keys(self::$imageCache));

    if (! empty($ids)) {
      self::firstImageForMany($ids);
    }
  }

  public static function checkImageByPostId($post_id){
    $image = '';
    $check = DB::table('images')->where('post_id',$post_id)->orderBy('sort')->orderBy('id')->get();
    if(isset($check)){
      $image = $check ;
    }
    return $image;
  }
}
