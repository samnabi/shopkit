<div class="uk-panel uk-panel-divider">
    <form dir="auto" class="uk-form uk-grid uk-grid-collapse" action="<?= url('/search') ?>" method="get">
        <div class="uk-width-3-5">
            <input class="uk-width-1-1" type="text" name="q" value="<?= get('q') ?>" placeholder="">
        </div>
        <div class="uk-width-2-5">
            <button class="uk-button uk-width-1-1" type="submit"><?= l::get('search') ?></button>
        </div>
    </form>
</div>