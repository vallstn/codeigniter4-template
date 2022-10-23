<?= $this->extend(setting('Auth.views')['email_layout']) ?>
<?= $this->section('message') ?>

<p>
    <a href="<?= site_url(route_to('verify-magic-link')) ?>?token=<?= $token ?>">
        <?= lang('Auth.login') ?>
    </a>
</p>

<?= $this->endSection() ?>
