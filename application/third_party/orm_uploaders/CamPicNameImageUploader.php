<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class CamPicNameImageUploader extends OrmImageUploader {

  public function getVersions () {
    return array (
        '' => array ()
      );
  }
}