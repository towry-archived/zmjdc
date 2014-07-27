<div class="container">
  <div class="panel">
    <div class="row">
      <div id="login">
        <div class="padding-content padding-xx">
          <div class="logo-container">
            <a href="/"><img alt="logo-large" title="<?= i18n_text('z') ?>" class="large-logo" src="<?= asset_prefix() ?>/images/logo-lg-100.png" /></a>
          </div>
          <div id="flash_notice" class="alert hide"></div>
          <form accept-charset="UTF-8" action="" method="post" class="form form-aligned">
            <div class="hide">
              <input class="input" name="utf8" type="hidden" value="&#x2713;" />
              <input class="input" name="csrf_" type="hidden" value="<?= csrf_token() ?>" />
            </div>
            <div class="control-group">
              <label for="email"><?= i18n_text('input_email') ?></label>
              <input class="input" type="email" id="email" name="email" placeholder="name@example.com" />
            </div>
            <div class="control-group">
              <label for="passwd"><?= i18n_text('input_password') ?></label>
              <input class="input" type="password" id="passwd" name="passwd" placeholder="* * * *" />
            </div>
            <?php if (isset($need_captcha) && $need_captcha) : ?>
            <div class="control-group">
              <label for="captcha"><?= i18n_text('captcha') ?></label>
              <img alt="failed to load captch, please try again" src="/misc/captcha?id=<?= csrf_token() ?>" />
            </div>
            <div class="control-group">
              <label for="captcha_input"><?= i18n_text('captcha_input') ?></label>
              <input type="text" name="captcha" id="captcha_input" class="input" required />
            </div>
            <?php endif; ?>
            <div class="control-group">
              <label></label>
              <input type="submit" value="<?= i18n_text('login'); ?>" name="login-submit" class="button button-base" />
              <a id="forgot_pass" href="#"><?= i18n_text('forgot_password') ?>?</a>
              <div style="margin-top:15px">
                <?= i18n_text('need_account'); ?>? <a class href="/signup"><?= i18n_text('signup'); ?></a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  z.require('login.min.js');
</script>
