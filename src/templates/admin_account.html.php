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
      <div id="account">
        <div class="padding-content padding-x">
          <p>
          <a href="/account/edit">edit</a>
          </p>
          <ul id="data-list">
            <?php if (fulfilled('data')) : ?>
            <?php foreach ($data as $sql) : ?>
            <li class="data-cell data-<?= $sql->id; ?>">
            <div class="cell-inner">
              <div class="cell-text"><?= $sql->how; ?></div>
              <div class="cf toolkit">
                <a class="js-allow" href="/api/memory/allow?m=<?= $sql->id; ?>">allow</a>
                <a class="js-notallow" href="/api/memory/notallow?m=<?= $sql->id; ?>">ignore</a>
              </div>
            </div>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  z.require('admin.min.jsr', '/admin/assets/');
</script>
