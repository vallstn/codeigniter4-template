<!doctype html>
<html lang="en"><head>
	<?= $viewMeta->render('meta') ?>
    <?= $viewMeta->render('title') ?>
    <?= asset_link('other/theme/css/tabler.css', 'css') ?>
    <?= asset_link('other/theme/inter.css', 'css') ?>
	<?= asset_link('other/theme/app.css', 'css') ?>
    <?= asset_link('other/theme/js/theme.js', 'js') ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>
<body  class="d-flex flex-column bg-white">
    <div class="row g-0 flex-fill">
	
        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <div class="bg-cover h-100 min-vh-100" style="background-image: url(<?=base_url("resource/bg_image.jpg")?>)"></div>
        </div>
		
		<div class="col-12 col-lg-6 col-xl-4 l2c-login border-top-wide border-primary d-flex flex-column justify-content-center">
			<aside id="alerts-wrapper">
				{alerts}
			</aside>
			<?= $this->renderSection('main') ?>
		</div>

    </div>
</body>
<?= asset_link('other/theme/js/tabler.js', 'js') ?>
<?= asset_link('other/crypt/cryptojs-aes.js', 'js') ?>
<?= asset_link('other/crypt/cryptojs-aes-format.js', 'js') ?>
<?= $this->renderSection('scripts') ?>
<?= $viewMeta->render('script') ?>
</body></html>
