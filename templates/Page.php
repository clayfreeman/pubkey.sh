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
    <div class="uk-navbar uk-navbar-attached">
      <div class="uk-container uk-container-center">
        <a class="uk-navbar-brand" href="/">
          <object type="image/svg+xml" data="/img/logo.svg"></object>
        </div>
      </div>
    </div>
<?= $contents ?>
    <div class="uk-container uk-container-center">
      <div class="uk-block uk-margin-right uk-text-right uk-text-small">
        <a href="#">Source Code</a>
      </div>
    </div>
  </body>
</html>
