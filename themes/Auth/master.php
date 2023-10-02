<!doctype html>
<html lang="<?= service('request')->getLocale() ?>">
	<head>
		<?= $viewMeta->render('meta') ?>

		<?= $viewMeta->render('title') ?>
		
		<?= asset_link('portal/theme/css/tabler_min.css', 'css') ?>
		<?= asset_link('portal/auth/css/auth.css', 'css') ?>
		<?= asset_link('other/components/font-awesome/css/all.css', 'css') ?>
		<?= asset_link('portal/plugins/crypt/cryptojs-aes.js', 'js') ?>
		<?= asset_link('portal/plugins/crypt/cryptojs-aes-format.js', 'js') ?>
		<?= $this->renderSection('styles') ?>
		<?= $viewMeta->render('style') ?>
		
		<style>
		  @import url('<?php echo base_url().'css/inter.css'; ?>');
		  :root {
			--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
		  }
		  body {
			font-feature-settings: "cv03", "cv04", "cv11";
		  }
		</style>
	</head>
	<body  class="d-flex flex-column">
		<aside id="alerts-wrapper">
		{alerts}
		</aside>
				
		<header class="navbar navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
			<a class="nav-link" href="<?= site_url(ADMIN_AREA) ?>">
				<span class="nav-link-icon d-md-none d-lg-inline-block">
					<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
					<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
					<path d="M5 12l-2 0l9 -9l9 9l-2 0" />
					<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
					<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
				</span>
				<span class="nav-link-title">
					<?= setting('Site.siteName') ?? 'Bonfire' ?>
				</span>
			</a>			
		</header>

		<div class="container-fluid main">
			<main class="ms-sm-auto px-md-4">
				<?= $this->renderSection('main') ?>
			</main>
		</div>

		<?= asset_link('portal/theme/js/tabler_min.js', 'js') ?>
		<?= asset_link('portal/plugins/js/alpine_min.js', 'js') ?>
		<?= asset_link('portal/plugins/js/htmx_min.js', 'js') ?>		
		<?= $this->renderSection('scripts') ?>
		<?= $viewMeta->render('script') ?>
	</body>
</html>
