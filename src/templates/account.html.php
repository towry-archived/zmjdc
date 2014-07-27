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
          <p><a href="/account/edit"><?= i18n_text('editaccount') ?></a></p>
          <div class="table-responsive">
            <table class="table styled">
              <tbody>
                <tr>
                  <td class="key"><?= i18n_text('userid') ?>:</td>
                  <td class="value"><?= $user->id; ?></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('username') ?>:</td>
                  <td class="value">
                    <?= _v($user, 'fakename', i18n_text('noname')); ?>
                  </td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('is_good') ?>:</td>
                  <td class="value"><?= _p($user->goodcount, 0); ?></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('contrib') ?>:</td>
                  <td class="value"><a href="/contribute"><?= _p($user->contribcount, 0); ?></a></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('already_memory') ?></td>
                  <td class="value"><a href="/ignored"><?= _p($user->ignorecount, 0); ?></a></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('last_login') ?>:</td>
                  <td class="value"><?= timefy($user->last_login); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- ./panel -->

