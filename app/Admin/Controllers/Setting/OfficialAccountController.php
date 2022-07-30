<?php

namespace App\Admin\Controllers\Setting;

use App\Admin\Controllers\AuthController;
use App\Models\AdminOptionsModel;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;

class OfficialAccountController extends AuthController
{
    public function index(Content $content){
        return $content->title('公众号设置')
            ->description('website wechat officialAccount setting')
            ->body($this->form());
    }

    protected function form(){
        return Form::make(new AdminOptionsModel(),function(Form $form){
            $form->action('setting/officialAccount');
            $form->disableListButton();
            $form->title('微信公众号设置');
            $form->disableResetButton();
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();

            $form->column(4,function(Form $form){
                $form->text('app_id','AppId')->required()->value(get_options('wechat_app_id'));
            });
            $form->column(4,function(Form $form){
               $form->text('secret','secret')->required()->value(get_options('wechat_secret'));
            });
            $form->column(4,function(Form $form){
                $form->text('token','token')->required()->value(get_options('wechat_token'));
            });
            $form->column(4,function(Form $form){
                $form->text('aes_key','aes_key')->value(get_options('wechat_aes_key'));
            });
            $form->column(4,function(Form $form){
                $form->url('redirect_url','登陆回调链接')->value(get_options("wechat_redirect_url",route('wechat.redirect')));
            });
        });
    }

    public function update(Request $request): \Dcat\Admin\Http\JsonResponse
    {
        $data = [];
        foreach($request->all() as $name => $value){
            if($name!=='_token'){
                $data['wechat_'.$name]=$value;
            }
        }
        set_options($data);
        return $this->response()->success('更新成功!');
    }

}
