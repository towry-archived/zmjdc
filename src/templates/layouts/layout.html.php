<!DOCTYPE html>
<html lang="zh-CN" class="no-js">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
    <meta name="copyright" content="zmjdc.com">
    <meta name="keywords" content="怎么记,单词,这个单词,英文,英语">
    <meta name="description" content="<?= _p('site_des', i18n_text('description')); ?>">
    <title><?php if (isset($title)) { echo $title . ' - ' . i18n_text('z'); } else { echo i18n_text('z'); } ?></title>
    <link rel="shortcut icon" href="<?= asset_prefix() ?>/images/favicon.ico">
    <link href="<?= asset_prefix() ?>/stylesheets/base.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <meta name="csrf_" content="<?= csrf_token(); ?>">
    <script type="text/javascript">
      //<![CDATA[
      window.z = window.z || {};z.require = function (a, p) {var d,c; $(function (){return d = document.createElement('script'), c = (c = document.getElementsByTagName('script'))[c.length-1], d.type="text/javascript",d.async=1,d.src=(p?p:"<?= asset_prefix() ?>/javascripts/")+a,c.parentNode.lastChild===c?c.parentNode.appendChild(d):c.parentNode.insertBefore(d,c.nextSibling);});};
      //]]
    </script>
    <script type="text/javascript" src="http://cdn.staticfile.org/jquery/1.9.1/jquery.min.js"></script>
  </head>
  <body>
    <div id="header">
      <div class="container">
        <h1 id="logo"><a href="/"><?= i18n_text('z'); ?></a></h1>
        <ul id="navigation">
          <li><a href="/"><?= i18n_text('home'); ?></a></li>
          <li><a href="/add?focus=word"><?= i18n_text('add'); ?></a></li>
          <?php if (auth_is()) : ?>
          <li><a href="/account"><?= i18n_text('account'); ?></a></li>
          <li><a href="/logout"><?= i18n_text('logout'); ?></a></li>
          <?php else: ?>
          <li><a href="/login"><?= i18n_text('login'); ?></a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <div id="main">
      <div class="container">
        <?= content() ?>
      </div>
    </div>
    <div id="footer" class="divider">
      <div class="container">
        <ul id="info-list">
          <li>&copy; 2014 <a href="/">ZMJDC.COM</a></li>
          <li><a href="/about"><?= i18n_text('about') ?></a></li>
        </ul>
      </div>
    </div>
    <div id="flash_notice_wrapper">
      <div id="flash_notice" class="alert hide"></div>
    </div>
    <!--[if IE 6]>
    <script src="//letskillie6.googlecode.com/svn/trunk/2/zh_CN.js"></script>
    <![endif]--> 
    <script type="text/javascript" src="http://cdn.staticfile.org/Cookies.js/0.3.1/cookies.min.js"></script>
    <script type="text/javascript" src="<?= asset_prefix(); ?>/javascripts/application.min.js"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-50340750-1', 'zmjdc.com');
      ga('send', 'pageview');
    </script>
  </body>
</html>
<!-- vim: set expandtab sts=2 sw=2: -->
