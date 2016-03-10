<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Cli extends Site_controller {

  public function __construct () {
    parent::__construct ();
    
    if (!$this->input->is_cli_request ()) {
      echo 'Request 錯誤！';
      exit ();
    }
  }

  public function init () {
    $cams = array (
        'R28 公車站' => 'http://163.13.240.165/cam1.jpg',
        'R27 公車站' => 'http://163.13.240.165/cam2.jpg',
        '操場' => 'http://163.13.240.165/cam3.jpg',
        '籃球場' => 'http://163.13.240.165/cam4.jpg',
        '網球場' => 'http://163.13.240.165/cam9.jpg',
        '五虎崗球場' => 'http://163.13.240.165/cam7.jpg',
        '商管三樓電梯' => 'http://163.13.240.165/cam5.jpg',
        '郵局' => 'http://163.13.240.165/cam8.jpg',
      );
    foreach ($cams as $title => $url)
      Cam::transaction (function () use ($title, $url) {
        if (!verifyCreateOrm ($cam = Cam::create (array ('url' => $url, 'title' => $title, 'pv' => 0, 'is_enabled' => Cam::IS_ENABLED))))
          return false;
        return true;
      });
  }
  public function update () {
    $log = CrontabLog::start ('每 30 秒更新所有地點');
    $cams = Cam::find ('all', array ('select' => 'id, url'));

    $returns = array_map (function ($cam) {
      return array (
          'id' => $cam->id,
          'result' => CamPic::transaction (function () use ($cam) {
              if (!verifyCreateOrm ($pic = CamPic::create (array ('cam_id' => $cam->id, 'name' => ''))))
                return false;
              return $pic->name->put_url ($cam->url);
          }));
    }, $cams);

    if (count ($cams) != count (array_filter ($returns, function ($r) { return $r['result']; })))
      return $log->error ('未完全執行完更新！ Data: ' . json_encode ($returns));
    else
      return $log->finish (json_encode ($returns));
  }
}
