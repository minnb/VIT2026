<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Slide;
use App\Models\Images;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Số danh mục con lấy kèm ở trang chủ.
     */
    const HOME_POSTS_PER_CATEGORY = 4;

    /**
     * Trang chủ.
     *
     * Toàn bộ truy vấn trước đây nằm trong view nay được gom về đây.
     */
    public function index()
    {
        $topDocs = $this->featuredDocuments();

        $topProducts       = Post::getRandomPost(1, 7);
        $productCategories = $this->categoriesWithPosts(1);
        $projectCategories = $this->categoriesWithPosts(2);
        $productLinks      = Post::getProductLink(999, 9);

        // Nap truoc anh dai dien cho moi bai viet se hien tren trang:
        // truoc day moi the san pham tu goi Images::checkImageProduct() -> N+1.
        Images::warmCacheFor($this->collectPosts([
            $topProducts,
            $productLinks,
            $productCategories,
            $projectCategories,
        ]));

        return view('home.pages.index', [
            'slides'            => Slide::orderBy('id', 'DESC')->take(5)->get(),
            'topDocs'           => $topDocs,
            'topProducts'       => $topProducts,
            'productCategories' => $productCategories,
            'projectCategories' => $projectCategories,
            'productLinks'      => $productLinks,
        ]);
    }

    /**
     * Tai lieu noi bat cho card o trang chu, kem ten danh muc de hien thi.
     *
     * Ten danh muc lay bang MOT truy van whereIn thay vi goi
     * Category::getNameById() cho tung ban ghi (N+1).
     *
     * @return array  [['title' => ..., 'url' => ..., 'cate' => ...], ...]
     */
    private function featuredDocuments(): array
    {
        $docs = Post::getRandomDocuments(5);

        if (empty($docs)) {
            return [];
        }

        $cateNames = Category::whereIn('id', array_column($docs, 'categorieID'))
            ->pluck('name', 'id');

        return array_map(function (array $doc) use ($cateNames) {
            return [
                'title' => $doc['title'],
                'url'   => $doc['description'],
                'cate'  => $cateNames[$doc['categorieID']] ?? 'Tài liệu kỹ thuật',
            ];
        }, $docs);
    }

    /**
     * Lấy danh mục theo parent kèm sẵn bài viết của từng danh mục.
     *
     * @param  int  $parent
     * @return array
     */
    /**
     * Gom moi bai viet nam trong cac nhom du lieu truyen vao (ke ca nhom
     * long trong danh muc) thanh mot mang phang de nap truoc anh.
     *
     * @param  array  $groups
     * @return array
     */
    protected function collectPosts(array $groups)
    {
        $posts = [];

        foreach ($groups as $group) {
            if (empty($group)) {
                continue;
            }

            foreach ($group as $entry) {
                if (is_array($entry) && isset($entry['posts'])) {
                    foreach ($entry['posts'] as $post) {
                        $posts[] = $post;
                    }

                    continue;
                }

                $posts[] = $entry;
            }
        }

        return $posts;
    }

    protected function categoriesWithPosts($parent)
    {
        $categories = Category::getList($parent);

        foreach ($categories as $key => $category) {
            $categories[$key]['posts'] = Post::getPostByCateId(
                $category['id'],
                self::HOME_POSTS_PER_CATEGORY
            );
        }

        return $categories;
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function getProducts()
    {
        $data = Post::where([
            ['parent', 1],
            ['sttesign', 1],
        ])->paginate(12);

        return view('home.pages.products', compact('data'));
    }

    public function getProductByCate($id, $title)
    {
        $id        = fdecrypt($id);
        $cate_name = Category::getNameById($id);

        $data = Post::where([
            ['categorieID', $id],
            ['sttesign', 1],
        ])->orderBy('id', 'DESC')->paginate(18);

        return view('home.pages.product_by_cate', compact('data', 'id', 'cate_name'));
    }

    public function getProductSingle($id, $title)
    {
        $id   = fdecrypt($id);
        $data = Post::find($id);

        if (!$data) {
            abort(404);
        }

        $cateName = Category::getNameById($data->categorieID);

        return view('home.pages.single_product', [
            'data'            => $data,
            'id'              => $id,
            'title'           => $cateName . ' - ' . $data->title,
            'cateName'        => $cateName,
            'parentCateName'  => Category::getParentNameByCateId($data->categorieID),
            'relatedProducts' => Post::getRandomPostByCate($data->categorieID, 3),
            'otherProducts'   => Post::getRandomPostByCate($data->categorieID, 4),
            'sidebarDocs'     => Post::getRandomPostByCate(12, 5),
        ]);
    }

    public function getProject()
    {
        $data = Post::where([
            ['parent', 2],
            ['sttesign', 1],
        ])->paginate(20);

        return view('home.pages.projects', compact('data'));
    }

    public function getDocument()
    {
        $data = Post::where([
            ['parent', 11],
            ['sttesign', 1],
        ])->get()->toArray();

        return view('home.pages.documents', compact('data'));
    }

    public function getAbout()
    {
        return $this->showStaticPage(16, 'home.pages.about');
    }

    public function getWarranty()
    {
        return $this->showStaticPage(24, 'home.pages.baohanh');
    }

    public function getSecurity()
    {
        return $this->showStaticPage(25, 'home.pages.baomat');
    }

    /**
     * Hiển thị trang nội dung tĩnh lấy theo danh mục.
     *
     * @param  int     $categoryId
     * @param  string  $view
     * @return \Illuminate\Http\Response
     */
    protected function showStaticPage($categoryId, $view)
    {
        $post = Post::where('categorieID', $categoryId)->first();

        if (!$post) {
            return back();
        }

        return view($view, [
            'data'  => $post->content,
            'title' => $post->title,
        ]);
    }

    public function postSearch(Request $request)
    {
        $keyword = trim($request->input('search'));

        $data = Post::where('parent', 1)
            ->where('sttesign', 1)
            ->where('title', 'like', '%' . $keyword . '%')
            ->get();

        return view('home.pages.result', compact('keyword', 'data'));
    }
}
