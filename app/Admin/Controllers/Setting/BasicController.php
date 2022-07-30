<?php

namespace App\Admin\Controllers\Setting;

use App\Admin\Controllers\AuthController;
use App\Models\AdminOptionsModel;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Form;
use Illuminate\Http\Request;

class BasicController extends AuthController
{
    public function index(Content $content)
    {
        return $content
            ->title('基本设置')
            ->description('website basic setting')
            ->body($this->form());
    }

    protected function form()
    {
        return Form::make(new AdminOptionsModel(), function(Form $form){
            $form->action('setting/basic');
            $form->disableListButton();
            $form->title('基本设置');
            $form->disableResetButton();
            $form->disableViewCheck();
            $form->disableEditingCheck();
            $form->disableCreatingCheck();

            $form->column(6,function ( $form) {
                $form->text('网站名')->value(get_options('basic_网站名'))->required();
                $form->text('备案号')->value(get_options('basic_备案号'));
                $form->text('公安备案号')->value(get_options('basic_公安备案号'));
            });
            $form->column(6,function ( $form) {
                $form->text('客服链接')->value(get_options('basic_客服链接'));
                $form->email('邮箱')->value(get_options('basic_邮箱'))->required();
                $form->url('群链接')->value(get_options('basic_群链接'));
            });
            $form->column(12,function($form){
                $form->textarea('网站描述')->value(get_options('basic_网站描述'))->required();
            });
        });

    }

    public function update(Form $form,Request $request){
        $data = [];
        foreach($request->all() as $name => $value){
            if($name!=='_token'){
                $data['basic_'.$name]=$value;
            }
        }
        set_options($data);
        return $this->response()->success('更新成功!');
    }
}
