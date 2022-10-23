<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="container container-tight my-5 px-lg-5">
    <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?=base_url("resource/favicon.ico")?>" height="66" alt=""></a>
        <br/><?= lang('Auth.login') ?>
    </div>

        <p><b><?= lang('Auth.checkYourEmail') ?></b>!</p>

        <p><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></p>

        </form>
</div>

<?= $this->endSection() ?>
