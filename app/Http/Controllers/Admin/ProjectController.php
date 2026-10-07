<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\PreparesViewData;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Images;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class ProjectController extends Controller
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
        $data = Post::getListForAdmin(2);
        return view('admin.pages.list_project', [
            'data'      => $data,
            'cateNames' => $this->cateNamesFor($data),
            'images'    => $this->firstImagesFor($data),
        ]);
    }

    public function getAdd(){
        return view('admin.pages.add_project', [
            'categories' => Category::getList(2),
        ]);
    }

    public function postAdd(PostRequest $request){
        $post = new Post();
        try{
            DB::beginTransaction();
            $post->title = $request->name;
            $post->slug = makeUnicode($request->name);
            $post->description = $request->name;
            $post->content = $request->content;
            $post->viewed = 0;
            $post->votes = 0;
            $post->parent = Category::find($request->cate_id)->parent;
            $post->type = 1;
            $post->categorieID = $request->cate_id;
            $post->userID = Auth::user()->id;
            $post->sttesign = 1;
            $post->price = 0;
            $post->save();
            $post_id = $post->id;

            if($request->file('fileImage')){
                foreach($request->file('fileImage') as $file ){
                    $pImages = new Images;
                    $destinationPath = checkFolderImage();
                    if(isset($file)){
                        $file_name = randomString().'.'.$file->getClientOriginalExtension();
                        $pImages->image = $destinationPath.'/'.$file_name;
                        $pImages->post_id = $post_id;
                        $pImages->thumb = '';
                        $file->move($destinationPath, $file_name);
                        // Anh upload thuong 3000-5000px/vai MB trong khi khung hien thi chi ~240px.
                        // Thu nho ngay tren file da luu; that bai thi giu nguyen anh goc.
                        resize_uploaded_image($destinationPath . '/' . $file_name);
                        $pImages->save();
                    }
                }
            }
            DB::commit();
            return redirect()->route('get.admin.list.project')->with(['flash_message'=>'Tạo mới thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.project')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }

    public function getEdit($id){
        $post_id = $id;
        $data = Post::find($id);
        return view('admin.pages.edit_project', [
            'data'       => $data,
            'post_id'    => $post_id,
            'categories' => Category::getList(2),
            'images'     => $this->imagesFor($post_id),
        ]);
    }

    public function postEdit(PostRequest $request, $id){
        $post_id = $id;
        $post = Post::findOrFail($post_id);;
        try{
            DB::beginTransaction();
            $post->title = $request->name;
            $post->slug = makeUnicode($request->name);
            $post->content = $request->content;
            $post->parent = Category::find($request->cate_id)->parent;
            $post->categorieID = $request->cate_id;
            $post->userID = Auth::user()->id;
            $post->save();
            if($request->file('fileImage')){
                foreach($request->file('fileImage') as $file ){
                    $pImages = new Images;
                    $destinationPath = checkFolderImage();
                    if(isset($file)){
                        $file_name = randomString().'.'.$file->getClientOriginalExtension();
                        $pImages->image = $destinationPath.'/'.$file_name;
                        $pImages->post_id = $post_id;
                        $pImages->thumb = '';
                        $file->move($destinationPath, $file_name);
                        // Anh upload thuong 3000-5000px/vai MB trong khi khung hien thi chi ~240px.
                        // Thu nho ngay tren file da luu; that bai thi giu nguyen anh goc.
                        resize_uploaded_image($destinationPath . '/' . $file_name);
                        $pImages->save();
                    }
                }
            }
            DB::commit();
            return redirect()->route('get.admin.list.project')->with(['flash_message'=>'Chỉnh sửa thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.project')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }
    public function getDelete($id){
        $post = Post::findOrFail($id);
        try{
            DB::beginTransaction();
            if(isset($post)){
                // Xoa mem qua Eloquent: DB::table() bo qua SoftDeletes nen ban cu
                // xoa vinh vien. File anh cung duoc giu lai de con khoi phuc duoc.
                $post->delete();
            }  
            DB::commit();
            return redirect()->route('get.admin.list.project')->with(['flash_message'=>'Xóa dữ liệu thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.project')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }

}