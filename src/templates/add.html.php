<div class="panel">
  <div class="header panel-header">
    <h2 class="panel-title"><?= $title ?></h2>
    <a id="menu" href="/" class="panel-lists">Menu</a>
    <ul id="menu-items">
      <li><a href="/add?focus=word"><?= i18n_text('add') ?></a></li>
      <li><a href="/account"><?= i18n_text('account') ?></a></li>
      <li><a href="/logout"><?= i18n_text('logout') ?></a></li>
    </ul>
  </div>
  <div class="main panel-main">
    <div class="row">
      <div id="add">
        <div class="padding-content padding-x">
          <div id="flash_notice" class="alert alert-info"><?= i18n_text('add_info') ?></div>
          <form action="" method="post"role="form">
            <div class="form-row">
              <label for="word"><?= i18n_text('word') ?></label>
              <input class="input" type="text" name="word" id="word" placeholder="<?= i18n_text('word') ?>" value="<?= _p('target'); ?>" required>
            </div>
            <div class="form-row">
              <label for="how"><?= i18n_text('howto') ?>?</label>
              <textarea name="how" id="how" rows="3" placeholder="<?= i18n_text('howto') ?>" style="min-height: 120px;" class="input" required><?= session('how_restore') ?></textarea>
            </div>
            <div class="form-row">
              <label for="captcha_input"><?= i18n_text('captcha_input') ?></label>
              <img style="display:block;" alt="failed to load captch, please try again" src="/misc/captcha?id=<?= csrf_token(); ?>&amp;h=30" />
              <input type="text" name="captcha" id="captcha_input" class="input" required />
            </div>
            <div class="form-row">
              <input class="input" type="hidden" name="csrf_" value="<?= csrf_token(); ?>">
              <input type="submit" name="submit-btn" value="<?= i18n_text('add') ?>" class="button button-primary control-lg">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div><!-- ./panel -->
<script type="text/javascript">
  $(function () {
    var c = z.util.objectQuery();
    if (c.focus) {
      $('#' + c.focus).focus();
    }
  });
</script>
