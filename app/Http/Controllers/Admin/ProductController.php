<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Images;
use App\Http\Controllers\Admin\Concerns\PreparesViewData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
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
        $data = Post::getListForAdmin(1);

        return view('admin.pages.list_product', [
            'data'      => $data,
            'cateNames' => $this->cateNamesFor($data),
            'images'    => $this->firstImagesFor($data),
        ]);
    }
    public function getListLink()
    {
        $data = Post::getListForAdmin(Category::linkRootId());

        return view('admin.pages.list_product_link', [
            'data'   => $data,
            'images' => $this->firstImagesFor($data),
        ]);
    }

    public function getAdd(){
        return view('admin.pages.add_product', [
            'categories' => Category::getList(1),
        ]);
    }

    public function getAddLink(){
        return view('admin.pages.add_product_link');
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
            return redirect()->route('get.admin.list.product')->with(['flash_message'=>'Tạo mới thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.product')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }

    public function postAddLink(PostRequest $request){
        $post = new Post();
        try{
            DB::beginTransaction();
            $post->title = $request->name;
            $post->slug = makeUnicode($request->name);
            $post->description = $request->description;
            
            if (empty($request->content)) {
                $post->content = "";
            }else{
                $post->content = $request->content;
            }
            
            $post->viewed = 0;
            $post->votes = 0;
            // Truoc day gan cung 999: danh muc 999 khong ton tai nen khoa ngoai
            // chan insert, con sttesign 999 thi tran tinyint.
            $linkCateId = Category::linkRootId();
            $post->parent = $linkCateId;
            $post->type = 999;
            $post->categorieID = $linkCateId;
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
            return redirect()->route('get.admin.list.product.link')->with(['flash_message'=>'Tạo mới thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.product.link')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }

    public function getEdit($id){
        $post_id = $id;
        $data = Post::find($id);

        return view('admin.pages.edit_product', [
            'data'       => $data,
            'post_id'    => $post_id,
            'categories' => Category::getList(1),
            'images'     => $this->imagesFor($post_id),
        ]);
    }
    public function getEditLink($id){
        $post_id = $id;
        $data = Post::find($id);

        return view('admin.pages.edit_product_link', [
            'data'    => $data,
            'post_id' => $post_id,
            'images'  => $this->imagesFor($post_id),
        ]);
    }

    public function postEditLink(PostRequest $request, $id){
        $post_id = $id;
        $post = Post::findOrFail($post_id);;
        try{
            DB::beginTransaction();
            $post->title = $request->name;
            $post->slug = makeUnicode($request->name);
            $post->description = $request->description;
            
            if (empty($request->content)) {
                $post->content = "";
            }else{
                $post->content = $request->content;
            }
            
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
            return redirect()->route('get.admin.list.product.link')->with(['flash_message'=>'Chỉnh sửa thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.product.link')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
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
            return redirect()->route('get.admin.list.product')->with(['flash_message'=>'Chỉnh sửa thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.product')->with(['flash_message'=>'Có lỗi xảy ra']);
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
            return redirect()->route('get.admin.list.product')->with(['flash_message'=>'Xóa dữ liệu thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.product')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }
    public function getDeleteLink($id){
        $post = Post::findOrFail($id);
        try{
            DB::beginTransaction();
            if(isset($post)){
                // Xoa mem qua Eloquent: DB::table() bo qua SoftDeletes nen ban cu
                // xoa vinh vien. File anh cung duoc giu lai de con khoi phuc duoc.
                $post->delete();
            }  
            DB::commit();
            return redirect()->route('get.admin.list.product.link')->with(['flash_message'=>'Xóa dữ liệu thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.add.product.link')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }

    public function getDelImage($id){
        $pImage = Images::findOrFail($id);
        if(isset($pImage)){
            File::delete($pImage->image);
            DB::table('images')->where('id','=',$id)->delete();
        }
        return 'OK';
    }
}