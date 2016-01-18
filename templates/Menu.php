<nav class="uk-navbar uk-navbar-attached" style="position: relative; padding-top: 15px; padding-bottom: 15px;">
  <div class="uk-container uk-container-center">
    <a href="#uk-small-navbar" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
    <a class="uk-navbar-brand uk-hidden-small" href="/">
      <img class="uk-margin uk-margin-remove" src="/img/logo.svg" width="210" height="45" title="pubkey.sh" alt="pubkey.sh" />
    </a>
    <div class="uk-navbar-brand uk-navbar-center uk-visible-small">
      <a href="/"><img src="/img/logo.svg" width="135" height="45" title="pubkey.sh" alt="pubkey.sh" /></a>
    </div>
    <div class="uk-navbar-flip uk-hidden-small">
      <ul class="uk-navbar-nav">
<?= self::indent($menu, 4) ?>
      </ul>
    </div>
  </div>
</nav>
<div id="uk-small-navbar" class="uk-offcanvas">
  <div class="uk-offcanvas-bar">
    <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon">
      <li class="uk-nav-header">Navigation</li>
<?= self::indent($menu, 3) ?>
    </ul>
  </div>
</div>
