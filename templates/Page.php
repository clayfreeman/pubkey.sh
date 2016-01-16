<!DOCTYPE html>
<html class="uk-height-1-1 uk-notouch">
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
    <?php if ($shownav == true) { ?><nav class="uk-navbar uk-navbar-attached" style="padding-top: 15px; padding-bottom: 15px;">
      <div class="uk-container uk-container-center">
        <a class="uk-navbar-brand" href="/">
          <img class="uk-height-1-1" style="padding-top: 7px; padding-bottom: 7px;" src="/img/logo.svg" alt />
        </a>
        <ul class="uk-align-right uk-hidden-small uk-margin-remove uk-navbar-nav">
          <li><a href="/login">Login</a></li>
        </ul>
      </div>
    </nav><?php } ?>
<?= $contents ?>
  </body>
</html>
