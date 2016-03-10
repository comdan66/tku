<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Main extends Site_controller {

  public function index ($id = 0) {
    if (!($id && ($cam = Cam::find ('one', array ('conditions' => array ('is_enabled = ? AND id = ?', Cam::IS_ENABLED, $id))))))
      $cam = null;
    $title = ($cam ? $cam->title : '淡江大學') . '即時影像';
    
    $this->set_title ($title . " - OA's TKU 即時看！")
         ->add_js (base_url ('resource', 'javascript', 'jquery-timeago_v1.3.1', 'jquery.timeago.js'))
         ->add_js (base_url ('resource', 'javascript', 'jquery-timeago_v1.3.1', 'locales', 'jquery.timeago.zh-TW.js'))
               
         ->add_meta (array ('name' => 'robots', 'content' => 'index,follow'))
         ->add_meta (array ('name' => 'keywords', 'content' => "淡江大學, ioa.tw, 即時, OA's TKU 即時看！"))
         ->add_meta (array ('name' => 'description', 'content' => "淡江大學, ioa.tw, 即時, OA's TKU 即時看！"))

         ->add_meta (array ('property' => 'og:site_name', 'content' => "OA's TKU 即時看！"))
         ->add_meta (array ('property' => 'og:url', 'content' => current_url ()))
         ->add_meta (array ('property' => 'og:title', 'content' => $title . " - OA's TKU 即時看！"))
         ->add_meta (array ('property' => 'og:description', 'content' => $title . " - OA's TKU 即時看！"))
         ->add_meta (array ('property' => 'fb:admins', 'content' => Cfg::setting ('facebook', 'admins')))
         ->add_meta (array ('property' => 'fb:app_id', 'content' => Cfg::setting ('facebook', 'appId')))
         ->add_meta (array ('property' => 'og:locale', 'content' => 'zh_TW'))
         ->add_meta (array ('property' => 'og:locale:alternate', 'content' => 'en_US'))
         ->add_meta (array ('property' => 'og:type', 'content' => 'article'))
         ->add_meta (array ('property' => 'article:author', 'content' => Cfg::setting ('facebook', 'author', 'link')))
         ->add_meta (array ('property' => 'article:publisher', 'content' => Cfg::setting ('facebook', 'author', 'link')))
         ->add_meta (array ('property' => 'og:image', 'content' => $img = base_url ('resource', 'image', 'og', 'larger.png'), 'alt' => "OA's TKU 即時看！"))
         ->add_meta (array ('property' => 'og:image:type', 'tag' => 'larger', 'content' => 'image/' . pathinfo ($img, PATHINFO_EXTENSION)))
         ->add_meta (array ('property' => 'og:image:width', 'content' => '1200'))
         ->add_meta (array ('property' => 'og:image:height', 'content' => '630'))
         ->add_meta (array ('property' => 'article:modified_time', 'content' => $cam ? $cam->updated_at->format ('c') : date ('c')))
         ->add_meta (array ('property' => 'article:published_time', 'content' => $cam ? $cam->created_at->format ('c') : date ('c')))
                
         ->load_view (array (
        'title' => $title,
        'c' => $cam
      ));
  }
}
