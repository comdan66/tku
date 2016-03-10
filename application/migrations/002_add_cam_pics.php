<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Migration_Add_cam_pics extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `cam_pics` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `cam_id` int(11) unsigned NOT NULL COMMENT 'Cam ID',

        `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '封面',

        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        PRIMARY KEY (`id`),
        KEY `cam_id_index` (`cam_id`),
        FOREIGN KEY (`cam_id`) REFERENCES `cams` (`id`) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `cam_pics`;"
    );
  }
}