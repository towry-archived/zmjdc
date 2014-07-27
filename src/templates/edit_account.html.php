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
      <div id="account-edit">
        <div class="padding-content padding-xx">
          <div id="flash_notice" class="alert alert-info"><?= i18n_text('account_edit_notice') ?>
          </div>
          <form accept-charset="UTF-8" action method="post" class="edit-account form" enctype="multipart/form-data" id="edit_<?= $user->id; ?>" role="form">
            <div class="hide">
              <input class="input" name="utf8" type="hidden" value="&#x2713;" />
              <input class="input" name="csrf_" type="hidden" value="<?= csrf_token(); ?>" />
            </div>
            <div class="form-row">
              <label for="username"><?= i18n_text('username') ?></label>
              <input class="input" id="username" name="username"  type="text" value="<?= $user->fakename; ?>" required />
            </div>
            <div class="form-row">
              <label for="password"><?= i18n_text('input_password') ?></label>
              <p class="well">* * * * * <a href="#" class="js-edit-password"><?= i18n_text('edit') ?></a></p>
              <input class="input well-related hide" id="password" name="password" type="password" placeholder="* * * *" />
            </div>
            <div class="form-row">
              <label for="email"><?= i18n_text('input_email') ?></label>
              <p class="well"><?= $user->email; ?> <a href="#" class="js-edit-email"><?= i18n_text('edit') ?></a></p>
              <input class="input well-related hide" id="email" name="email" type="email" value="<?= $user->email; ?>" required/>
            </div>
            <div class="form-row">
              <input type="submit" name="su" id="submit_btn" value="<?= i18n_text('save_change') ?>" class="button button-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  (function (){
    $('.js-edit-email').on('click', function (e) {
      e.preventDefault();

      $(this).parent().hide();
      $("#email").removeClass('hide').fadeIn('slow');
    });
    $('.js-edit-password').on('click', function (e) {
      e.preventDefault();

      $(this).parent().hide();
      $("#password").removeClass('hide').fadeIn('slow');
    });
    $('#edit_<?= $user->id ?>').on('submit', function (e) {
      var $username = $('#username', $(this)),
      $email = $('#email', $(this)),
      a, b;
      if ((a = $username.val() === "") || (b = $email.val() === "")) {
        e.preventDefault();

        var m = using('app/message');

        m('error', '<?= i18n_text('field_empty') ?>');

        a && $username.focus();
        b && $email.focus();

        return false;
      } else {
        return true;
      }
    });
  })();
</script>
