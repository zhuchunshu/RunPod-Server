<?php

use Illuminate\Support\Facades\Cache;

/**
 * 获取设置值
 * @param $name
 * @param null $default
 * @return string|null
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 * @throws \Psr\SimpleCache\InvalidArgumentException
 */
function get_options($name,$default=null):string|null{
    if(Cache::tags(['admin','options'])->has($name)){
        return Cache::tags(['admin','options'])->get($name);
    }
    if(!\App\Models\AdminOptionsModel::query()->where('name',$name)->exists()){
        return $default;
    }
    Cache::tags(['admin','options'])->put($name,\App\Models\AdminOptionsModel::query()->where('name',$name)->first()->value,86400);
    return Cache::tags(['admin','options'])->get($name);
}

/**
 * 设置设置值
 * @param array $data
 */
function set_options(array $data){
    foreach($data as $name=>$value){
        if(!\App\Models\AdminOptionsModel::query()->where('name',$name)->exists()){
            \App\Models\AdminOptionsModel::query()->create(['name' => $name, 'value' => $value]);
        }else{
            \App\Models\AdminOptionsModel::query()->where('name',$name)->update(['value' => $value]);
        }
        Cache::tags(['admin','options'])->put($name,$value,86400);
    }
}


/**
 * 清理设置缓存
 */
function clean_options_cache(){
    Cache::tags(['admin', 'options'])->flush();
}
