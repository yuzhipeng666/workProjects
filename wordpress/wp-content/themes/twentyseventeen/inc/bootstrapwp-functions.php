<?php
/**
 * Created by PhpStorm.
 * User: yuzhipeng
 * Date: 2018/8/27
 * Time: 下午5:09
 */

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
    add_menu_page( 'My Plugin Theme', '配置分类ID', 'administrator', 'Bwp_slug', 'display_function' );
}
//get_configureId();
function display_function(){
    include 'configure-id.php';
}




