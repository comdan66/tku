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
         ->load_view (array (
        'title' => $title,
        'c' => $cam
      ));
  }
}
