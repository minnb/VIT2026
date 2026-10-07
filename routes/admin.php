<?php

/*
|--------------------------------------------------------------------------
| Route khu quan tri
|--------------------------------------------------------------------------
|
| File duoc include tu routes/web.php nen thua huong middleware `web`.
| Moi route ben duoi deu di qua `auth` + `admin` (kiem tra users.role),
| thay vi chi dua vao middleware('auth') dat trong constructor controller.
|
*/

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('password/reset', fn () => redirect()->route('login'))->name('password.request');


// Logout bat buoc la POST: link GET co the bi prefetch hoac nhung vao <img>.
// Ban cu khai route nay hai lan, ban sau (closure redirect) de len ban truoc
// nen Auth::logout() khong bao gio chay - bam "Dang xuat" khong thuc su thoat.

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Admin\AdminController@index']);

    Route::group(['prefix' => 'dashboard'], function () {

        /* ------------------------------------------------ Danh muc */
        Route::group(['prefix' => 'cate'], function () {
            Route::get('product/lists', ['as' => 'get.admin.cate.product.list', 'uses' => 'Admin\CateController@getCateProduct']);
            Route::get('project/lists', ['as' => 'get.admin.cate.project.list', 'uses' => 'Admin\CateController@getCateProject']);
            Route::get('document/lists', ['as' => 'get.admin.cate.document.list', 'uses' => 'Admin\CateController@getCateDocument']);
            Route::get('news/lists', ['as' => 'get.admin.cate.new.list', 'uses' => 'Admin\CateController@getCateNew']);

            Route::get('add/{parent}', ['as' => 'get.admin.cate.add', 'uses' => 'Admin\CateController@getAdd'])->where('parent', '[0-9]+');
            Route::post('add/{parent}', ['as' => 'post.admin.cate.add', 'uses' => 'Admin\CateController@postAdd'])->where('parent', '[0-9]+');
            Route::get('edit/{id}', ['as' => 'get.admin.cate.edit', 'uses' => 'Admin\CateController@getEdit'])->where('id', '[0-9]+');
            Route::post('edit/{id}', ['as' => 'post.admin.cate.edit', 'uses' => 'Admin\CateController@postEdit'])->where('id', '[0-9]+');
            Route::post('delete/{id}', ['as' => 'post.admin.cate.delete', 'uses' => 'Admin\CateController@postDelete'])->where('id', '[0-9]+');
        });

        /* ------------------------------------------------ Danh sach */
        Route::group(['prefix' => 'lists'], function () {
            Route::get('products', ['as' => 'get.admin.list.product', 'uses' => 'Admin\ProductController@getList']);
            Route::get('products/link', ['as' => 'get.admin.list.product.link', 'uses' => 'Admin\ProductController@getListLink']);
            Route::get('projects', ['as' => 'get.admin.list.project', 'uses' => 'Admin\ProjectController@getList']);
            Route::get('documents', ['as' => 'get.admin.list.document', 'uses' => 'Admin\DocumentController@getList']);
            Route::get('news', ['as' => 'get.admin.list.news', 'uses' => 'Admin\NewController@getList']);

            Route::get('about', ['as' => 'get.admin.list.about', 'uses' => 'Admin\NewController@getAbout']);
            Route::post('about', ['as' => 'post.admin.list.about', 'uses' => 'Admin\NewController@postAbout']);

            Route::get('chinh-sach-bao-hanh', ['as' => 'get.admin.list.baohanh', 'uses' => 'Admin\NewController@getBaohanh']);
            Route::post('chinh-sach-bao-hanh', ['as' => 'post.admin.list.baohanh', 'uses' => 'Admin\NewController@postBaohanh']);

            Route::get('chinh-sach-bao-mat', ['as' => 'get.admin.list.baomat', 'uses' => 'Admin\NewController@getBaomat']);
            Route::post('chinh-sach-bao-mat', ['as' => 'post.admin.list.baomat', 'uses' => 'Admin\NewController@postBaomat']);
        });

        /* ------------------------------------------------ Them moi */
        Route::group(['prefix' => 'add'], function () {
            Route::get('product', ['as' => 'get.admin.add.product', 'uses' => 'Admin\ProductController@getAdd']);
            Route::post('product', ['as' => 'post.admin.add.product', 'uses' => 'Admin\ProductController@postAdd']);

            Route::get('product/link', ['as' => 'get.admin.add.product.link', 'uses' => 'Admin\ProductController@getAddLink']);
            Route::post('product/link', ['as' => 'post.admin.add.product.link', 'uses' => 'Admin\ProductController@postAddLink']);

            Route::get('document', ['as' => 'get.admin.add.document', 'uses' => 'Admin\DocumentController@getAdd']);
            Route::post('document', ['as' => 'post.admin.add.document', 'uses' => 'Admin\DocumentController@postAdd']);

            Route::get('project', ['as' => 'get.admin.add.project', 'uses' => 'Admin\ProjectController@getAdd']);
            Route::post('project', ['as' => 'post.admin.add.project', 'uses' => 'Admin\ProjectController@postAdd']);

            Route::get('news', ['as' => 'get.admin.add.news', 'uses' => 'Admin\NewController@getAdd']);
            Route::post('news', ['as' => 'post.admin.add.news', 'uses' => 'Admin\NewController@postAdd']);
        });

        /* ------------------------------------------------ Chinh sua */
        Route::group(['prefix' => 'edit'], function () {
            Route::get('product/{id}', ['as' => 'get.admin.edit.product', 'uses' => 'Admin\ProductController@getEdit'])->where('id', '[0-9]+');
            Route::post('product/{id}', ['as' => 'post.admin.edit.product', 'uses' => 'Admin\ProductController@postEdit'])->where('id', '[0-9]+');


            Route::get('product/link/{id}', ['as' => 'get.admin.edit.product.link', 'uses' => 'Admin\ProductController@getEditLink'])->where('id', '[0-9]+');
            Route::post('product/link/{id}', ['as' => 'post.admin.edit.product.link', 'uses' => 'Admin\ProductController@postEditLink'])->where('id', '[0-9]+');

            Route::get('document/{id}', ['as' => 'get.admin.edit.document', 'uses' => 'Admin\DocumentController@getEdit'])->where('id', '[0-9]+');
            Route::post('document/{id}', ['as' => 'post.admin.edit.document', 'uses' => 'Admin\DocumentController@postEdit'])->where('id', '[0-9]+');

            Route::get('project/{id}', ['as' => 'get.admin.edit.project', 'uses' => 'Admin\ProjectController@getEdit'])->where('id', '[0-9]+');
            Route::post('project/{id}', ['as' => 'post.admin.edit.project', 'uses' => 'Admin\ProjectController@postEdit'])->where('id', '[0-9]+');

            Route::get('news/{id}', ['as' => 'get.admin.edit.news', 'uses' => 'Admin\NewController@getEdit'])->where('id', '[0-9]+');
            Route::post('news/{id}', ['as' => 'post.admin.edit.news', 'uses' => 'Admin\NewController@postEdit'])->where('id', '[0-9]+');
        });

        /* ------------------------------------------------ Xoa (POST + CSRF) */
        Route::group(['prefix' => 'delete'], function () {
            Route::post('product/{id}', ['as' => 'post.admin.delete.product', 'uses' => 'Admin\ProductController@getDelete'])->where('id', '[0-9]+');
            Route::post('product/link/{id}', ['as' => 'post.admin.delete.product.link', 'uses' => 'Admin\ProductController@getDeleteLink'])->where('id', '[0-9]+');
            Route::post('document/{id}', ['as' => 'post.admin.delete.document', 'uses' => 'Admin\DocumentController@getDelete'])->where('id', '[0-9]+');
            Route::post('project/{id}', ['as' => 'post.admin.delete.project', 'uses' => 'Admin\ProjectController@getDelete'])->where('id', '[0-9]+');
            Route::post('news/{id}', ['as' => 'post.admin.delete.news', 'uses' => 'Admin\NewController@getDelete'])->where('id', '[0-9]+');
            Route::post('product/img/{id}', ['as' => 'post.admin.delete.product.image', 'uses' => 'Admin\ProductController@getDelImage'])->where('id', '[0-9]+');
        });

        /* ------------------------------------------------ Cai dat */
        Route::group(['prefix' => 'setting'], function () {
            Route::get('hotline', ['as' => 'get.admin.setting.hotline', 'uses' => 'Admin\CommonController@getHotline']);
            Route::get('hotline/list', ['as' => 'get.admin.setting.hotline.list', 'uses' => 'Admin\CommonController@getListHotline']);
            Route::post('hotline/add', ['as' => 'post.admin.setting.hotline.add', 'uses' => 'Admin\CommonController@postHotline']);
            Route::get('hotline/edit/{id}', ['as' => 'get.admin.setting.hotline.edit', 'uses' => 'Admin\CommonController@getEditHotline'])->where('id', '[0-9]+');
            Route::post('hotline/edit/{id}', ['as' => 'post.admin.setting.hotline.edit', 'uses' => 'Admin\CommonController@postEditHotline'])->where('id', '[0-9]+');
            Route::post('hotline/del/{id}', ['as' => 'post.admin.setting.hotline.del', 'uses' => 'Admin\CommonController@getDelete'])->where('id', '[0-9]+');

            Route::get('company', ['as' => 'get.admin.setting.company', 'uses' => 'Admin\CommonController@getCompany']);
            Route::get('company/list', ['as' => 'get.admin.setting.company.list', 'uses' => 'Admin\CommonController@getListCompany']);
            Route::get('company/edit/{id}', ['as' => 'get.admin.setting.company.edit', 'uses' => 'Admin\CommonController@getEditCompany'])->where('id', '[0-9]+');
            Route::post('company/edit/{id}', ['as' => 'post.admin.setting.company.edit', 'uses' => 'Admin\CommonController@postEditCompany'])->where('id', '[0-9]+');

            Route::get('slide/list', ['as' => 'get.admin.setting.slide.list', 'uses' => 'Admin\CommonController@getListSlide']);
            Route::post('slide/post', ['as' => 'post.admin.setting.slide.list', 'uses' => 'Admin\CommonController@postSlide']);
            Route::post('slide/delete/{id}', ['as' => 'post.admin.setting.slide.delete', 'uses' => 'Admin\CommonController@getSlideDel'])->where('id', '[0-9]+');
        });
    });
});
