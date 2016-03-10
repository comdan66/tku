<header>
  <a class='fi-m'></a>
  <div><?php echo $title;?></div>
  <label class='fi-mr'>
    <div>
      <a href='https://www.facebook.com/comdan66' target='_blank'>網站作者</a>
      <a href='https://github.com/comdan66/tku' target='_blank'>GitHub</a>
      <a id='fb' data-url='<?php echo current_url ();?>'>臉書分享</a>
    </div>
  </label>
</header>

<aside>
  <div>ＴＫＵ</div>
  <a href='<?php echo base_url ();?>' class='fi-h'>首頁</a>
  <?php
  foreach ($cams = Cam::find ('all', array ('include' => array ('pic'), 'conditions' => array ('is_enabled = ?', Cam::IS_ENABLED))) as $cam) { ?>
    <a href='<?php echo base_url ($cam->id);?>' class='icon-pin_drop'><?php echo $cam->title;?></a>
<?php
  }
  ?>
</aside>
<div class='_c'></div>

<?php
  if ($c) { ?>
    <figure>
      <a href='<?php echo base_url ($c->id);?>'>
    <?php foreach (CamPic::find ('all', array ('limit' => 60, 'order' => 'id DESC', 'conditions' => array ('cam_id = ?', $c->id))) as $pic) { ?>
            <img data-time='<?php echo $pic->created_at->format ('Y-m-d H:i:s');?>' alt="<?php echo $c->title;?> - OA's TKU 即時看！" src='<?php echo $pic->name->url ();?>' />
    <?php } ?>
      </a>
      <figcaption>
        <div><?php echo $c->title;?></div>
        <time><?php echo $pic->created_at->format ('Y-m-d H:i:s');?><time>
      </figcaption>
    </figure>
<?php
  } else { ?>
    <article>
      <?php
      foreach ($cams as $cam) { ?>
        <figure>
          <a href='<?php echo base_url ($cam->id);?>'>
            <img alt="<?php echo $cam->title;?> - OA's TKU 即時看！" src='<?php echo $cam->pic->name->url ();?>' />
          </a>
          <figcaption><?php echo $cam->title;?></figcaption>
        </figure>
      <?php
      } ?>
    </article>
<?php
  }
  