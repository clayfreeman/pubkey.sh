<div class="uk-vertical-align uk-text-center uk-height-1-1">
  <div class="uk-vertical-align-middle" style="width: 300px;">
    <a href="/"><img class="uk-margin-bottom" src="/img/logo.svg" alt /></a>
    <form class="uk-panel uk-panel-box uk-form" method="POST">
      <?php if (strlen(trim($error)) > 0) { ?><div class="uk-alert uk-alert-danger" data-uk-alert>
        <a class="uk-alert-close uk-close" href></a>
        <?= htmlspecialchars(trim($error), ENT_HTML401 | ENT_QUOTES) ?>
      </div><?php } ?>
      <div class="uk-form-row">
        <input class="uk-width-1-1 uk-form-large" name="username" placeholder="Username" type="text" />
      </div>
      <div class="uk-form-row">
        <input class="uk-width-1-1 uk-form-large" name="password" placeholder="Password" type="password" />
      </div>
      <div class="uk-form-row">
        <button class="uk-width-1-1 uk-button uk-button-primary uk-button-large">Login</button>
      </div>
      <div class="uk-form-row uk-text-small">Lost Password?</div>
    </form>
  </div>
</div>
