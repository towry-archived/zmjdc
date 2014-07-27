<div class="panel">
  <div class="header panel-header">
    <h2 class="panel-title"><?= i18n_text('z'); ?></h2>
    <a id="menu" href="/" class="panel-lists">Menu</a>
    <ul id="menu-items">
      <li><a href="/add?focus=word"><?= i18n_text('add'); ?></a></li>
      <li><a href="/account"><?= i18n_text('account'); ?></a></li>
      <li><a href="/logout"><?= i18n_text('logout'); ?></a></li>
    </ul>
  </div>
  <div class="main panel-main">
    <div class="row">
      <div id="search-form">
        <form action="/search" method="get" class="form">
          <label>
            <input type="search" name="s" id="s" class="input control-lg">
            <input type="submit" value="<?= i18n_text('search'); ?>" class="button button-primary control-lg">
          </label>
        </form>
      </div>
    </div>
    <div class="row">
      <div id="latest" class="border-top">
        <div class="padding-content padding-x">
          <h3><?= i18n_text('latest_add'); ?></h3>
          <ul id="data-latest">
            <?php foreach ($data as $sql) : ?>
            <li><a href="/word/<?= $sql->word; ?>"><?= $sql->word ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  z.require('home.min.js');
</script>
