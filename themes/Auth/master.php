<!doctype html>
<html lang="en"><head>
	<?= $viewMeta->render('meta') ?>

    <?= $viewMeta->render('title') ?>
    
    <?= asset_link('other/bs5/css/bootstrap.css', 'css') ?>
	<?= asset_link('auth/css/auth.css', 'css') ?>
    <?= asset_link('other/font-awesome/css/all.css', 'css') ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>
<body>

<aside id="alerts-wrapper">
{alerts}
</aside>

<header class="navbar navbar-light bg-none flex-md-nowrap p-0 shadow-sm">
    <a class="px-3 d-block fs-3 text-dark text-decoration-none col-md-3 col-lg-2 me-0" href="/<?= ADMIN_AREA ?>">
        <?= setting('Site.siteName') ?? 'Learn2Code' ?>
    </a>
</header>

<div class="container-fluid main">
    <main class="ms-sm-auto px-md-4">
        <?= $this->renderSection('main') ?>
    </main>
</div>

<?= asset_link('other/bs5/js/bootstrap.js', 'js') ?>
<?= asset_link('other/crypt/cryptojs-aes.js', 'js') ?>
<?= asset_link('other/crypt/cryptojs-aes-format.js', 'js') ?>
<?= $this->renderSection('scripts') ?>
<?= $viewMeta->render('script') ?>
</body></html>
