<?php
/**
 * Plugin Name: Advanced Emailing For WooCommerce
 * Plugin URI: http://rednao.com/getit
 * Description: Everything that you need in one place
 * Author: RedNao
 * Author URI: http://rednao.com
 * Version: 1.0.34
 * Text Domain: rnadvanceemailingwc
 * Domain Path: /languages/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 * Slug: advanced-email-for-woocommerce
 */


use rnadvanceemailingwc\core\Loader;

spl_autoload_register('rnadvanceemailingwc');
function rnadvanceemailingwc($className)
{
    if(strpos($className,'rnadvanceemailingwc\\')!==false)
    {
        $NAME=basename(\dirname(__FILE__));
        $DIR=dirname(__FILE__);
        $path=substr($className,19);
        $path=str_replace('\\','/', $path);
        require_once realpath($DIR.$path.'.php');
    }
}


function RNADEM(){
    return new \rnadvanceemailingwc\api\AdvanceEmailingApi();
}

$loader=new Loader(__FILE__,'rnadvanceemailingwc',93,25,array(
    'ItemId'=>809,
    'Author'=>'Edgar Rojas',
    'UpdateURL'=>'https://rednao.com',
    'FileGroup'=>'advancedemailingwc'
));
/*
 * add_action (
    'save_post_shop_order',
    function (int $postId, \WP_Post $post, bool $update): void
    {
        // Ignore order (post) creation
        if ($update !== true) {
            return;
        }

        // Here comes your code...
    },
    10,
    3
);
 */