<!DOCTYPE html>
<html class="uk-height-1-1">
  <head>
    <title><?= $title ?> | pubkey.sh</title>
    <!-- Define page contents and character set -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Load jQuery -->
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <!-- Load UIKit requirements -->
    <link rel="stylesheet" href="/uikit/css/uikit.almost-flat.min.css" />
    <script type="text/javascript" src="/uikit/js/uikit.min.js"></script>
  </head>
  <body class="uk-height-1-1">
    <?php if ($shownav == true) { ?><nav class="uk-navbar uk-navbar-attached" style="position: relative; padding-top: 15px; padding-bottom: 15px;">
      <div class="uk-container uk-container-center">
        <a class="uk-navbar-brand uk-hidden-small" href="/">
          <img class="uk-margin uk-margin-remove" src="/img/logo.svg" width="210" height="45" title="pubkey.sh" alt="pubkey.sh" />
        </a>
        <a class="uk-navbar-brand uk-navbar-center uk-visible-small">
          <img src="/img/logo.svg" width="135" height="45" title="pubkey.sh" alt="pubkey.sh" />
        </a>
        <div class="uk-navbar-flip uk-hidden-small">
          <ul class="uk-navbar-nav">
            <li><a href="/login">Login</a></li>
          </ul>
        </div>
        <a href="#uk-small-navbar" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
      </div>
    </nav>
    <div id="uk-small-navbar" class="uk-offcanvas">
      <ul class="uk-navbar-nav">
        <li><a href="/login">Login</a></li>
      </ul>
    </div><?php } ?>
<?= $contents ?>
  </body>
</html>
