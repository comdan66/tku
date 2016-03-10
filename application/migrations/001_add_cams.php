<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_cams extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `cams` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '網址',
        `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '標題',
        `pv` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Page View',
        `is_enabled` tinyint(1) unsigned NOT NULL DEFAULT 1 COMMENT '上下架，1 上架，0 下架',
        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        PRIMARY KEY (`id`),
        KEY `is_enabled_index` (`is_enabled`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `cams`;"
    );
  }
}