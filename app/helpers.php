<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 *  bootstrap 类选择器active状态选中辅助函数
 * @param $category_id
 * @return string
 */
function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

/**
 * 生成摘要辅助方法
 * @param $value
 * @param int $length
 * @return mixed
 */
function make_excerpt($value, $length=200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return Str::limit($excerpt, $length);
}