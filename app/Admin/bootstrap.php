<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Layout\Menu;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */


Admin::menu(function (Menu $menu) {
    $menu->add([
        [
            'id'            => '1', // 此id只要保证当前的数组中是唯一的即可
            'title'         => '设置',
            'icon'          => 'feather icon-grid',
            'uri'           => '',
            'parent_id'     => 0,
        ],
        [
            'id'            => '2', // 此id只要保证当前的数组中是唯一的即可
            'title'         => '基本设置',
            'icon'          => '',
            'uri'           => 'setting/basic',
            'parent_id'     => '1',
        ],
        [
            'id'            => '3', // 此id只要保证当前的数组中是唯一的即可
            'title'         => '支付设置',
            'icon'          => '',
            'uri'           => 'setting/pay',
            'parent_id'     => '1',
        ],
        [
            'id'            => '4', // 此id只要保证当前的数组中是唯一的即可
            'title'         => '公众号设置',
            'icon'          => '',
            'uri'           => 'setting/officialAccount',
            'parent_id'     => '1',
        ],

    ]);
});
