<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Concerns\PreparesViewData;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Auth;

class CateController extends Controller
{
    use PreparesViewData;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Danh muc goc cua tung nhom noi dung, dung cho breadcrumb va redirect.
     *
     * @var array
     */
    protected static $rootRoutes = [
        1  => 'get.admin.cate.product.list',
        2  => 'get.admin.cate.project.list',
        3  => 'get.admin.cate.new.list',
        11 => 'get.admin.cate.document.list',
    ];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCateProduct()
    {
        $data = Category::getList(1);

        return view('admin.pages.cate_product', [
            'data'          => $data,
            'catePostCount' => $this->catePostCountFor($data),
        ]);
    }

    public function getCateProject()
    {
        $data = Category::getList(2);

        return view('admin.pages.cate_project', [
            'data'          => $data,
            'catePostCount' => $this->catePostCountFor($data),
        ]);
    }

    public function getCateDocument()
    {
        $data = Category::getList(11);

        return view('admin.pages.cate_document', [
            'data'          => $data,
            'catePostCount' => $this->catePostCountFor($data),
        ]);
    }

    public function getCateNew()
    {
        $data = Category::getList(3);

        return view('admin.pages.cate_news', [
            'data'          => $data,
            'catePostCount' => $this->catePostCountFor($data),
        ]);
    }

    /**
     * Form them danh muc con cho mot danh muc goc.
     */
    public function getAdd($parent)
    {
        return view('admin.pages.cate_form', [
            'category' => null,
            'parent'   => (int) $parent,
            'action'   => route('post.admin.cate.add', ['parent' => $parent]),
        ]);
    }

    public function postAdd(CategoryRequest $request, $parent)
    {
        Category::create([
            'name'   => $request->name,
            'slug'   => makeUnicode($request->name),
            'parent' => (int) $parent,
            'sort'   => (int) $request->input('sort', 0),
            'userID' => Auth::user()->id,
        ]);

        return redirect()->to($this->listUrlFor((int) $parent))
            ->with(['flash_message' => 'Tạo danh mục thành công']);
    }

    public function getEdit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.pages.cate_form', [
            'category' => $category,
            'parent'   => (int) $category->parent,
            'action'   => route('post.admin.cate.edit', ['id' => $category->id]),
        ]);
    }

    public function postEdit(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->slug = makeUnicode($request->name);
        $category->sort = (int) $request->input('sort', 0);
        $category->save();

        return redirect()->to($this->listUrlFor((int) $category->parent))
            ->with(['flash_message' => 'Cập nhật danh mục thành công']);
    }

    /**
     * Xoa mem. Danh muc con dang co bai viet thi tu choi xoa de tranh
     * bai viet bi mo coi (khoa ngoai posts.categorieID dang ON DELETE CASCADE).
     */
    public function postDelete($id)
    {
        $category = Category::findOrFail($id);
        $parent   = (int) $category->parent;

        if (Category::countPost($category->id) > 0) {
            return redirect()->to($this->listUrlFor($parent))
                ->with(['flash_message' => 'Danh mục vẫn còn bài viết, không thể xoá.']);
        }

        if ($category->children()->count() > 0) {
            return redirect()->to($this->listUrlFor($parent))
                ->with(['flash_message' => 'Danh mục vẫn còn danh mục con, không thể xoá.']);
        }

        $category->delete();

        return redirect()->to($this->listUrlFor($parent))
            ->with(['flash_message' => 'Đã xoá danh mục']);
    }

    /**
     * URL trang danh sach tuong ung voi danh muc goc.
     *
     * @param  int  $parent
     * @return string
     */
    protected function listUrlFor($parent)
    {
        $route = isset(self::$rootRoutes[$parent]) ? self::$rootRoutes[$parent] : 'dashboard';

        return route($route);
    }
}
