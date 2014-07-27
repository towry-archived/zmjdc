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
      <div id="ignored">
        <div class="padding-content padding-x">
          <h3><?= i18n_text('already_memory') ?><span style="font-size: 14px; color: #888;margin-left: 10px;font-weight: 300;" href="/account/edit"><?= _p($count, 0); ?></span></h3>
          <ul id="data-list">
            <?php if (fulfilled('data')) : ?>
            <?php foreach($data as $sql) : ?>
            <li class="data-cell">
            <div class="cell-inner">
              <h3><a href="/word/{{word}}"><?= $slq->word; ?></a></h3>
              <div class="help-links clearfix">
                <a class="cell-needle js-ignore-remove" href="/ignored/remove?w=<?= $sql->id; ?>">remove</a>
              </div>
            </div>
            </li>
            <?php endforeach; ?>
            <?php else : ?>
            <li class="data-cell">
            <div class="cell-inner null-content">
              <p><?= i18n_text('empty_how') ?> <a href="/add?focus=word"><?= i18n_text('add') ?></a></p>
            </div>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div><!-- ./panel -->
