<?php if (!$user = $site->user()) { ?>
    <div class="uk-panel uk-panel-divider">

        <?php if (get('login') === 'failed')  { ?>
            <div class="uk-alert uk-alert-warning">
                <p dir="auto"><?php echo l::get('notification-login-failed') ?></p>
            </div>
        <?php } ?>
        
        <form dir="auto" action="<?php echo url('/login') ?>" method="POST" id="login" class="uk-form">
            <div class="uk-grid uk-grid-width-1-2">
                <div>
                  <label class="uk-width-1-1" for="email"><?php echo l::get('email-address') ?></label>
                  <input class="uk-width-1-1" type="text" id="email" name="email">
                </div>
                <div>
                  <label class="uk-width-1-1" for="password"><?php echo l::get('password') ?></label>
                  <input class="uk-width-1-1" type="password" id="password" name="password">
                </div>
            </div>
            <div class="uk-margin">
                <button class="uk-button uk-width-1-1" type="submit" name="login">
                    <?php echo l::get('login') ?>
                </button>
            </div>
            <div class="uk-text-small uk-grid uk-grid-width-1-2">
                <div>
                    <a href="<?php echo url('account/reset') ?>" title="<?php echo l::get('forgot-password') ?>"><?php echo l::get('forgot-password') ?></a>
                </div>
                <div class="uk-text-right">
                    <?php echo l::get('new-customer') ?>
                    <a href="<?php echo url('account/register') ?>" title="<?php echo l::get('register') ?>"><?php echo l::get('register') ?></a>
                </div>
            </div>
        </form>

        <script>
            // domready (c) Dustin Diaz 2014 - License MIT
            !function(e,t){typeof module!="undefined"?module.exports=t():typeof define=="function"&&typeof define.amd=="object"?define(t):this[e]=t()}("domready",function(){var e=[],t,n=document,r=n.documentElement.doScroll,i="DOMContentLoaded",s=(r?/^loaded|^c/:/^loaded|^i|^c/).test(n.readyState);return s||n.addEventListener(i,t=function(){n.removeEventListener(i,t),s=1;while(t=e.shift())t()}),function(t){s?setTimeout(t,0):e.push(t)}})

            // Add click handlers to the links to make the login form flash
            domready(function() {
                function flashForm(event) {
                    var form = document.getElementById('login');
                    form.scrollIntoView(true);
                    form.style.opacity = 0;
                    setTimeout(function(){ form.style.opacity = 1; }, 300);
                }
                var links = document.querySelectorAll('a[href="#user"]');
                for (var i = 0; i < links.length; i++) {
                    links[i].addEventListener("mouseup", flashForm, true);
                }
            });
        </script>
    </div>
<?php } ?>