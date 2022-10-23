<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="container container-tight my-5 px-lg-5">
    <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?=base_url("resource/favicon.ico")?>" height="66" alt=""></a>
        <br/><?= lang('Bonfire.magicLinkInfo') ?>
    </div>
    <form action="<?= route_to('magic-link') ?>" method="post" autocomplete="off" novalidate>
        <?= csrf_field() ?>
        <!-- Email -->
        <div class="mb-3">
            <input type="email" class="form-control" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                   value="<?= old('email', auth()->user()->email ?? null) ?>" required />
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100"><?= lang('Auth.useMagicLink') ?></button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
