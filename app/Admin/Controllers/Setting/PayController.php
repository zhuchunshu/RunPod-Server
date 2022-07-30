<?php

namespace App\Admin\Controllers\Setting;

use App\Admin\Controllers\AuthController;
use App\Models\AdminOptionsModel;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Traits\HasUploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PayController extends AuthController
{
    use HasUploadedFile;

    public function index(Content $content){
        return $content->title('支付设置')
            ->description('website pay setting')
            ->body($this->form());
    }

    protected function form(){
        return new Form(new AdminOptionsModel(),function(Form $form){
            $form->action('setting/pay');
            $form->disableListButton();
            $form->title('支付设置');
            $form->disableResetButton();
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();

            $form->column(6,function(Form $form){
                $form->text('微信商户号')->required()->value(get_options('pay_微信商户号'));
                $form->text('微信商户秘钥')->required()->value(get_options('pay_微信商户秘钥'));
                $form->text('微信公钥序列号')->required()->value(get_options('pay_微信公钥序列号'));
                $form->url('微信支付回调地址')->value(get_options('pay_微信支付回调地址',route('pay.notify')));
                $form->text('微信公众号appid')->value(get_options('pay_微信公众号appid'));
            });

            $form->column(6,function(Form $form){
                $form->file('微信商户私钥')->disk('admin')->url("setting/pay/upload")->autoUpload()->value(get_options('pay_微信商户私钥'));
                $form->file('微信商户公钥证书')->disk('admin')->url('setting/pay/upload')->autoUpload()->value(get_options('pay_微信商户公钥证书',null));
            });
        });
    }

    public function upload(){
        $disk = $this->disk('admin');

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            // 删除文件并响应
            File::delete(\request()->input('key'));
            AdminOptionsModel::query()->where('name','pay_'.request()->input('_column'))->delete();
            clean_options_cache();
            return $this->responseDeleted();
        }

        // 获取上传的文件
        $file = $this->file();

        // 获取上传的字段名称
        $column = $this->uploader()->upload_column;

        $dir = 'payFile';
        $newName = $column.'-'.Str::random().'.'.$file->getClientOriginalExtension();

        $result = $disk->putFileAs($dir, $file, $newName);

        $path = storage_path('app/public/admin/'."{$dir}/$newName");

        return $result
            ? $this->responseUploaded($path, $disk->url($path))
            : $this->responseErrorMessage('文件上传失败');
    }

    public function update(Request $request){
        $data = [];
        foreach($request->all() as $name => $value){
            if($name!=='_token'){
                $data['pay_'.$name]=$value;
            }
        }
        set_options($data);
        return $this->response()->success('更新成功!');
    }

}
