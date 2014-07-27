<!-- vim: set expandtab sts=2 sw=2: -->
<div class="panel">
  <div class="header panel-header">
    <h2 class="panel-title"><?= _p('title'); ?></h2>
    <a id="menu" href="/" class="panel-lists">Menu</a>
    <ul id="menu-items">
      <li><a href="/add?focus=word"><?= i18n_text('add') ?></a></li>
      <li><a href="/account"><?= i18n_text('account') ?></a></li>
      <li><a href="/logout"><?= i18n_text('logout') ?></a></li>
    </ul>
  </div>
  <div class="main panel-main">
    <div class="row">
      <div id="simple-mean">
        <div class="padding-content padding-x">
          <?php if (fulfilled('xml')) : ?>
          <div class="pron">
            <span>[英]<b class="us-pron" lang="EN-US" xml:lang="EN-US"><?= $xml['ps']['en']; ?></b></span>
            <span>[美]<b class="en-pron" lang="EN-US" xml:lang="EN-US"><?= $xml['ps']['us']; ?></b></span>
          </div>
          <?php endif; ?>
          <h3><?= i18n_text('explan') ?></h3>
          <ul>
            <?php if (fulfilled('xml')) : ?>
            <?php foreach ($xml['acceptation'] as $sql) : ?>
            <li><strong><?= $sql['pos']; ?></strong><span><?= $sql['acc']; ?></span></li>
            <?php endforeach; ?>
            <?php else : ?>
            <li><div class="null-content"><?= i18n_text('no_simple_means') ?><a target="_blank" href="http://dict.baidu.com/s?wd=<?= _p('title'); ?>"><?= i18n_text('go_to_baidu') ?></a></div></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="how" class="border-top">
        <div class="padding-content padding-x">
          <h3><?= i18n_text('howto') ?></h3>
          <ul id="data-list">
            <?php if (fulfilled('data')) : ?>
            <?php foreach($data as $sql) : ?>
            <li class="data-cell">
            <div class="cell-inner">
              <div class="cell-text"><?= $sql->how; ?></div>
              <div class="cf toolkit">
                <ul class="cell-info">
                  <li><span><?= i18n_text('contributor') ?>:</span><a href="/user/<?= $sql->uid; ?>"><?= _v($sql, 'fakename', i18n_text('no_name')); ?></a></li>
                </ul>
              </div>
            </div>
            <div class="vote-cell">
              <?php if ($sql->vuid && $sql->vuid === $guid) : ?>
                <?php if ($sql->vote === '1') : ?>
                <ul class="votes voted-up">
                <?php elseif ($sql->vote === '-1') : ?>
                <ul class="votes voted-down">
                <?php else : ?>
                <ul class="votes">
                <?php endif; ?>
              <?php else : ?>
                <ul class="votes">
              <?php endif; ?>
                <li class="vote vote-up">
                <a class="vote-anchor" data-id="<?= $sql->id; ?>" href="/rate?a=1&amp;m=<?= $sql->id; ?>"><span class="arrow arrow-up"></span><span class="count"><?= _v($sql, 'vup', 0); ?></span></a>
                </li>
                <li class="vote vote-down">
                <a class="vote-anchor" data-id="<?= $sql->id; ?>" href="/rate?a=-1&amp;m=<?= $sql->id; ?>"><span class="arrow arrow-down"></span></a>
                </li>
              </ul>
            </div>
            </li>
            <?php endforeach; ?>
            <?php else: ?>
            <li class="data-cell">
            <div class="cell-inner null-content">
              <p><?= i18n_text('empty_how') ?> <a href="/add?focus=word"><?= i18n_text('add') ?></a></p>
            </div>
            </li>
            <?php endif; ?>
          </ul>
          <?php if (isset($count) && $count) : ?>
          <div class="page-nav">
            <?php navigator($count, 2); ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div><!-- ./panel -->
<script type="text/javascript">
  z.require('words.min.js'); 
</script>
