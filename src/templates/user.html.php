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
      <div id="account">
        <div class="padding-content padding-x">
          <div class="table-responsive">
            <table class="table styled">
              <tbody>
                <tr>
                  <td class="key"><?= i18n_text('userid') ?>:</td>
                  <td class="value"><?= $guser->id; ?></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('username') ?>:</td>
                  <td class="value"><?= _v($guser, 'fakename', i18n_text('noname')); ?></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('is_good') ?>:</td>
                  <td class="value"><?= _v($guser, 'goodcount', 0); ?></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('contrib') ?>:</td>
                  <td class="value"><a href="/user/<?= $guser->id; ?>/contribute"><?= _v($guser, 'contribcount', 0); ?></a></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('already_memory') ?></td>
                  <td class="value"><a href="/user/<?= $guser->id; ?>/ignored"><?= _v($guser, 'ignorecount', 0); ?></a></td>
                </tr>
                <tr>
                  <td class="key"><?= i18n_text('last_login') ?>:</td>
                  <td class="value"><?= timefy($guser->last_login); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- ./panel -->

