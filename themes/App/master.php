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

    <div class="container">
        <main class="ms-sm-auto px-md-4 py-5">
            <?= $this->renderSection('main') ?>
        </main>
    </div>

    <footer class="border-top text-center p-5">
        <div class="environment">
            <p>Page rendered in {elapsed_time} seconds  &hearts;  Environment: <?= ENVIRONMENT ?></p>
        </div>
    </footer>

    <?= $viewMeta->render('script') ?>
</body></html>
