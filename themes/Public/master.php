<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<?= $viewMeta->render('meta') ?>
		<?= $viewMeta->render('title') ?>
		<?= asset_link('other/theme/css/tabler.css', 'css') ?>
		<?= asset_link('other/theme/inter.css', 'css') ?>
		<?= asset_link('other/theme/app.css', 'css') ?>
		<?= $this->renderSection('styles') ?>
		<?= $viewMeta->render('style') ?>
		<style>
		  :root {
			--tblr-font-sans-serif: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
		  }
		</style>
	</head>
	<body  class=" layout-fluid">
		<div class="page">
			<!-- Navbar -->
			<header class="navbar navbar-expand-md navbar-light d-print-none">
				<div class="container-xl">
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
						<span class="navbar-toggler-icon"></span>
					</button>
					<h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
						<a href=".">
							<img src="<?=base_url("resource/favicon.ico")?>" width="110" height="32" alt="Logo" class="navbar-brand-image">
							&nbsp; Agricultural Engineering Department
						</a>
					</h1>
					<div class="navbar-nav flex-row order-md-last">									
						<div class="d-none d-md-flex">
							<a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
								data-bs-placement="bottom">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
							</a>
							<a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
								data-bs-placement="bottom">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
							</a>
							<div class="nav-item dropdown d-none d-md-flex me-3">
								<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">									
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
									<span class="badge bg-red"></span>
								</a>
								<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
									<div class="card">
										<div class="card-header">
											<h3 class="card-title">Last updates</h3>
										</div>
										<div class="list-group list-group-flush list-group-hoverable">
											<div class="list-group-item">
												<div class="row align-items-center">
													<div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
													<div class="col text-truncate">
														<a href="#" class="text-body d-block">Example 1</a>
														<div class="d-block text-muted text-truncate mt-n1">
															Change deprecated html tags to text decoration classes (#29604)
														</div>
													</div>
													<div class="col-auto">
														<a href="#" class="list-group-item-actions">
															<!-- Download SVG icon from http://tabler-icons.io/i/star -->
															<svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
														</a>
													</div>
												</div>
											</div>
											<div class="list-group-item">
												<div class="row align-items-center">
													<div class="col-auto"><span class="status-dot d-block"></span></div>
													<div class="col text-truncate">
														<a href="#" class="text-body d-block">Example 2</a>
														<div class="d-block text-muted text-truncate mt-n1">
															justify-content:between ⇒ justify-content:space-between (#29734)
														</div>
													</div>
													<div class="col-auto">
														<a href="#" class="list-group-item-actions show">
															<!-- Download SVG icon from http://tabler-icons.io/i/star -->
															<svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="nav-item dropdown">
							<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
								<span class="avatar avatar-sm" style="background-image: url(<?=base_url("resource/favicon.ico")?>)"></span>
								<div class="d-none d-xl-block ps-2">
									<div>Paweł Kuna</div>
									<div class="mt-1 small text-muted">UI Designer</div>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
								<a href="#" class="dropdown-item">Status</a>
								<a href="#" class="dropdown-item">Profile</a>
								<a href="#" class="dropdown-item">Feedback</a>
								<div class="dropdown-divider"></div>
								<a href="./settings.html" class="dropdown-item">Settings</a>
								<a href="<?=base_url("logout")?>" class="dropdown-item">Logout</a>
							</div>
						</div>
					</div>
				</div>
			</header>
			<div class="navbar-expand-md">
				<div class="collapse navbar-collapse" id="navbar-menu">
					<div class="navbar navbar-light">
						<div class="container-xl">
							<ul class="navbar-nav">
								<li class="nav-item">
									<a class="nav-link" href="./index.html" >
										<span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
										</span>
										<span class="nav-link-title">
											Home
										</span>
									</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" href="./form-elements.html" >
										<span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 11 12 14 20 6" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
										</span>
										<span class="nav-link-title">
											Form elements
										</span>
									</a>
								</li>

								<li class="nav-item active dropdown">
									<a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
										<span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="5" rx="2" /><rect x="4" y="13" width="6" height="7" rx="2" /><rect x="14" y="4" width="6" height="7" rx="2" /><rect x="14" y="15" width="6" height="5" rx="2" /></svg>
										</span>
										<span class="nav-link-title">
											Layout
										</span>
									</a>
									<div class="dropdown-menu">
										<div class="dropdown-menu-columns">
											<div class="dropdown-menu-column">
												<a class="dropdown-item" href="./layout-horizontal.html">
													Horizontal
												</a>
												<a class="dropdown-item" href="./layout-boxed.html">
												  Boxed
												  <span class="badge badge-sm bg-green text-uppercase ms-2">New</span>
												</a>
												<a class="dropdown-item" href="./layout-vertical.html">
												  Vertical
												</a>
												<a class="dropdown-item" href="./layout-vertical-transparent.html">
												  Vertical transparent
												</a>
												<a class="dropdown-item" href="./layout-vertical-right.html">
												  Right vertical
												</a>
												<a class="dropdown-item" href="./layout-condensed.html">
												  Condensed
												</a>
												<a class="dropdown-item" href="./layout-combo.html">
												  Combined
												</a>
											</div>
											<div class="dropdown-menu-column">
												<a class="dropdown-item" href="./layout-navbar-dark.html">
												  Navbar dark
												</a>
												<a class="dropdown-item" href="./layout-navbar-sticky.html">
												  Navbar sticky
												</a>
												<a class="dropdown-item" href="./layout-navbar-overlap.html">
												  Navbar overlap
												</a>
												<a class="dropdown-item" href="./layout-rtl.html">
												  RTL mode
												</a>
												<a class="dropdown-item active" href="./layout-fluid.html">
												  Fluid
												</a>
												<a class="dropdown-item" href="./layout-fluid-vertical.html">
												  Fluid vertical
												</a>
											</div>
										</div>
									</div>
								</li>

							</ul>
							<div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
								<form action="./" method="get" autocomplete="off" novalidate>
									<div class="input-icon">
										<span class="input-icon-addon">
											<!-- Download SVG icon from http://tabler-icons.io/i/search -->
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
										</span>
										<input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="page-wrapper">
				<!-- Page header -->
				<div class="page-header d-print-none">
					<div class="container-xl">
						<div class="row g-2 align-items-center">
							<div class="col">
								<!-- Page pre-title -->
								<div class="page-pretitle">
									Overview
								</div>
								<h2 class="page-title">
									Fluid layout
								</h2>
							</div>
							<!-- Page title actions -->
							<div class="col-12 col-md-auto ms-auto d-print-none">
								<div class="btn-list">
									<span class="d-none d-sm-inline">
										<a href="#" class="btn">
											New view
										</a>
									</span>
									<a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
										<!-- Download SVG icon from http://tabler-icons.io/i/plus -->
										<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
										Create new report
									</a>
									<a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
										<!-- Download SVG icon from http://tabler-icons.io/i/plus -->
										<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Page body -->
				<div class="page-body">
					<div class="container-xl">

						<?= $this->renderSection('main') ?>

					</div>
				</div>
				<footer class="footer footer-transparent d-print-none">
					<div class="container-xl">
						<div class="row text-center align-items-center flex-row-reverse">
							<div class="col-lg-auto ms-lg-auto">
								<ul class="list-inline list-inline-dots mb-0">
									<li class="list-inline-item"><a href="./docs/index.html" class="link-secondary">Documentation</a></li>
									<li class="list-inline-item"><a href="./license.html" class="link-secondary">License</a></li>
									<li class="list-inline-item"><a href="https://github.com/tabler/tabler" target="_blank" class="link-secondary" rel="noopener">Source code</a></li>
									<li class="list-inline-item">
										<a href="https://github.com/sponsors/codecalm" target="_blank" class="link-secondary" rel="noopener">
											<!-- Download SVG icon from http://tabler-icons.io/i/heart -->
											<svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink icon-filled icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
											Sponsor
										</a>
									</li>
								</ul>
							</div>
							<div class="col-12 col-lg-auto mt-3 mt-lg-0">
								<ul class="list-inline list-inline-dots mb-0">
									<li class="list-inline-item">
										Copyright &copy; 2022
										<a href="." class="link-secondary">Tabler</a>.
										All rights reserved.
									</li>
									<li class="list-inline-item">
										<a href="./changelog.html" class="link-secondary" rel="noopener">
										v
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<script type="text/javascript">
			(function (factory) {
				typeof define === 'function' && define.amd ? define(factory) :
				factory();
			})((function () { 'use strict';

				var themeStorageKey = 'tablerTheme';
				var defaultTheme = 'light';
				var selectedTheme;
				var params = new Proxy(new URLSearchParams(window.location.search), {
				  get: function get(searchParams, prop) {
					return searchParams.get(prop);
				  }
				});
				if (!!params.theme) {
				  localStorage.setItem(themeStorageKey, params.theme);
				  selectedTheme = params.theme;
				} else {
				  var storedTheme = localStorage.getItem(themeStorageKey);
				  selectedTheme = storedTheme ? storedTheme : defaultTheme;
				}
				document.body.classList.remove('theme-dark', 'theme-light');
				document.body.classList.add("theme-".concat(selectedTheme));

			}));
		</script>
    
		<!-- Libs JS -->
		<?= asset_link('other/theme/js/tabler.js', 'js') ?>
		<?= $this->renderSection('scripts') ?>
		<?= $viewMeta->render('script') ?>
	</body>
</html>
