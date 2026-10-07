<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\PreparesViewData;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;use Illuminate\Support\Facades\Auth;
class DocumentController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $data = Post::getListForAdmin(11);
        return view('admin.pages.list_document', [
            'data'      => $data,
            'cateNames' => $this->cateNamesFor($data),
            'images'    => $this->firstImagesFor($data),
        ]);
    }

    public function getAdd(){
        return view('admin.pages.add_document', [
            'categories' => Category::getList(11),
        ]);
    }
    public function postAdd(PostRequest $request){
        $post = new Post();
        $post->title = $request->name;
            $post->slug = makeUnicode($request->name);
        $post->description = $request->description;
        $post->content = '';
        $post->viewed = 0;
        $post->votes = 0;
        $post->parent = Category::find($request->cate_id)->parent;
        $post->type = 0;
        $post->categorieID = $request->cate_id;
        $post->userID = Auth::user()->id;
        $post->sttesign = 1;
        $post->price = 0;
        $post->save();
        return redirect()->route('get.admin.list.document')->with(['flash_message'=>'Tạo mới thành công']);
    }
    public function getEdit($id){
        $post_id = $id;
        $data = Post::find($id);
        return view('admin.pages.edit_document', [
            'data'       => $data,
            'post_id'    => $post_id,
            'categories' => Category::getList(11),
        ]);
    }
    public function postEdit(PostRequest $request, $id){
        $post = Post::findOrFail($id);
        $post->title = $request->name;
            $post->slug = makeUnicode($request->name);
        $post->description = $request->description;
        $post->parent = Category::find($request->cate_id)->parent;
        $post->categorieID = $request->cate_id;
        $post->userID = Auth::user()->id;
        $post->save();
        return redirect()->route('get.admin.list.document')->with(['flash_message'=>'Chỉnh sửa thành công']);
    }

    public function getDelete($id){
        $post = Post::findOrFail($id);
        if(isset($post)){
            $post->delete();
        }
        return redirect()->route('get.admin.list.document')->with(['flash_message'=>'Xóa thành công']);   
    }
}