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
  public function mail ($msgs = array ()) {
    if (!$msgs)
      $msgs = array (
          '錯誤原因' => '不明原因錯誤！',
          '錯誤時間' => date ('Y-m-d H:i:s'),
        );
    
    $html = "<article style='font-size:15px;line-height:22px;color:rgb(85,85,85)'><p style='margin-bottom:0'>Hi 管理員,</p><section style='padding:5px 20px'><p>剛剛發生了系統異常的狀況，以下是錯誤訊息：</p><table style='width:100%;border-collapse:collapse'><tbody>";
    foreach ($msgs as $title => $msg)
      $html .= "<tr><th style='width:100px;text-align:right;padding:11px 5px 10px 0;border-bottom:1px dashed rgba(200,200,200,1)'>" . $title . "：</th><td style='text-align:left;text-align:left;padding:11px 0 10px 5px;border-bottom:1px dashed rgba(200,200,200,1)'>" . $msg . "</td></tr>";
    $html .= "</tbody></table><br/><p style='text-align:right'>如果需要詳細列表，可以置<a href='" . base_url ('admin') . "' style='color:rgba(96,156,255,1);margin:0 2px'>管理後台</a>檢閱。</p></section></article>";
    
    $this->load->library ('OaMailGun');
    $mail = new OaMailGun ();
    $result = $mail->sendMessage (array (
              'from' => Cfg::setting ('mail_gun', 'user', 'system', 'name') . ' <' . Cfg::setting ('mail_gun', 'user', 'system', 'email') . '>',
              'to' => 'OA' . ' <comdan66@gmail.com>',
              'subject' => Cfg::setting ('mail_gun', 'user', 'system', 'subject'),
              'html' => $html
            ));
  }

  public function update () {
    $log = CrontabLog::start ('每 1 分鐘更新所有地點');
    $path = FCPATH . 'temp/hi.text';

    if (file_exists ($path))
      return $log->error ('上一次還沒完成！') && $this->mail (array (
          '錯誤原因' => '重複更新狀況！',
          '錯誤時間' => date ('Y-m-d H:i:s'),
        ));

    $this->load->helper ('file');
    write_file ($path, 'Hi!');

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
      $log->error ('未完全執行完更新！ Data: ' . json_encode ($returns));
    else
      $log->finish (json_encode ($returns));

    return @unlink ($path);
  }
}
