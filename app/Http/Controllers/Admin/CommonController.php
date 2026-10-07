<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Http\Requests\SlideRequest;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Slide;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class CommonController extends Controller
{
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
    public function getHotline(){
        return view('admin.setting.hotline');
    }
    public function getListHotline(){
        return Setting::where('type','HOTLINE')->orderBy('id','DESC')->get();
    }
    public function postHotline(SettingRequest $request){
        $setting = new Setting;
        try{
            DB::beginTransaction();
            $setting->type ='HOTLINE';
            $setting->name =$request->name;
            $setting->address ='';
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->alias = '';
            $setting->sort = 1;
            $setting->status = 1;
            $setting->save();
            DB::commit();
            return "OK";  
        }catch (\Throwable $e) {
            DB::rollBack();
            return "NOT"; 
        }
    }
    public function getEditHotline($id){
        return Setting::findOrFail($id);
    }
    public function postEditHotline(SettingRequest $request, $id){
        $setting = Setting::findOrFail($id);
        try{
            DB::beginTransaction();
            $setting->name =$request->name;
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->save();
            DB::commit();
            return "OK";  
        }catch (\Throwable $e) {
            DB::rollBack();
            return "NOT"; 
        }
    }

    public function getDelete($id){
        $hotline = Setting::findOrFail($id);
        $hotline->delete();
        return "OK";
    }
//******************************************************************************
    public function getCompany(){
        return view('admin.setting.company');
    }
    public function getListCompany(){
        return Setting::where('type','COMPANY')->orderBy('id','DESC')->get();
    }
    public function getEditCompany($id){
        return Setting::findOrFail($id);
    }
    public function postEditCompany(SettingRequest $request, $id){
        $setting = Setting::findOrFail($id);
        try{
            DB::beginTransaction();
            $setting->name =$request->name;
            $setting->address =$request->address;
            $setting->phone = $request->phone;
            $setting->fax =$request->fax;
            $setting->email = $request->email;
            $setting->save();
            DB::commit();
            return "OK";  
        }catch (\Throwable $e) {
            DB::rollBack();
            return "NOT"; 
        }
    }

    public function getListSlide(){
        $data = Slide::orderBy('id')->get()->toArray();
        return view('admin.setting.slide', compact('data'));
    }

    public function postSlide(SlideRequest $request){
        try{
            DB::beginTransaction();

            if($request->file('fileImage')){
                foreach($request->file('fileImage') as $file ){
                    $slide = new Slide;
                    $destinationPath = checkFolderImage();
                    if(isset($file)){
                        $file_name = randomString().'.'.$file->getClientOriginalExtension();
                        $slide->image = $destinationPath.'/'.$file_name;
                        $slide->description = '';
                        $slide->alias = '';
                        $file->move($destinationPath, $file_name);
                        // Slide la banner full-width nen cho khung rong hon anh san pham.
                        // Thu nho ngay tren file da luu; that bai thi giu nguyen anh goc.
                        resize_uploaded_image($destinationPath . '/' . $file_name, 1920, 1080);
                        $slide->save();
                    }
                }
            }
            DB::commit();
            return redirect()->route('get.admin.setting.slide.list')->with(['flash_message'=>'Upload hình ảnh thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.setting.slide.list')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }

    public function getSlideDel($id){
        $slide = Slide::findOrFail($id);
        try{
            DB::beginTransaction();
            if(isset($slide)){
                if(isset($slide->image)){
                    File::delete($slide->image);
                    DB::table('slide')->where('id','=',$id)->delete();
                }
            }  
            DB::commit();
            return redirect()->route('get.admin.setting.slide.list')->with(['flash_message'=>'Xóa dữ liệu thành công']);
        }catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('get.admin.setting.slide.list')->with(['flash_message'=>'Có lỗi xảy ra']);
        }
    }
}