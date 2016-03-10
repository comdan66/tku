<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Main extends Site_controller {

  public function index ($id = 0) {
    if (!($id && ($cam = Cam::find ('one', array ('conditions' => array ('is_enabled = ? AND id = ?', Cam::IS_ENABLED, $id))))))
      $cam = null;

    $this->load_view (array (
        'c' => $cam
      ));
  }
}
