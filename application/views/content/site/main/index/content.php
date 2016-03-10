<header>
  <a class='fi-m'></a>
  <div>sd</div>
  <label class='fi-mr'>
    <div>
      <a href=''>GitHub</a>
      <a href=''>臉書分享</a>
    </div>
  </label>
</header>

<aside>
  <div>ＴＫＵ</div>
  <a href='<?php echo base_url ();?>' class='fi-h'>首頁</a>
  <?php
  foreach ($cams = Cam::find ('all', array ('include' => array ('pic'), 'conditions' => array ('is_enabled = ?', Cam::IS_ENABLED))) as $cam) { ?>
    <a href='<?php echo base_url ($cam->id);?>' class='fi-m'><?php echo $cam->title;?></a>
<?php
  }
  ?>
</aside>
<div class='_c'></div>

<?php
  if ($c) { ?>
    <figure>
      <a href='<?php echo base_url ($c->id);?>'>
        <?php
          foreach (CamPic::find ('all', array ('limit' => 60, 'order' => 'id DESC', 'conditions' => array ('cam_id = ?', $c->id))) as $pic) { ?>
            <img alt="<?php echo $c->title;?> - OA's TKU 即時看！" src='<?php echo $pic->name->url ();?>' />
        <?php
          } ?>
      </a>
      <figcaption><?php echo $c->title;?></figcaption>
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
  