<!doctype html>
<html lang="en"><head>
    <?= $viewMeta->render('meta') ?>

    <?= $viewMeta->render('title') ?>
	
	<?= asset_link('other/bs5/css/bootstrap.css', 'css') ?>    
    <?= asset_link('admin/css/admin.css', 'css') ?>
    <?= asset_link('other/font-awesome/css/all.css', 'css') ?>
    <?= $this->renderSection('styles') ?>
    <?= $viewMeta->render('style') ?>
</head>
<body>

<aside id="alerts-wrapper">
{alerts}
</aside>

<?php if (site_offline()) : ?>
    <div class="alert alert-secondary alert-offline">
        Site is currently offline. Enable it
        <a href="<?= site_url(ADMIN_AREA .'/settings/general') ?>">here</a>.
    </div>
<?php endif ?>

<div class="main <?= site_offline() ? 'offline' : '' ?>" x-data="{open: true}" >
    <div class="h-100 d-flex align-items-stretch">
        <nav id="sidebars" class="sidebar" x-bind:class="{ 'collapsed': ! open }">
            <div class="sidebar-wrap  h-100 position-relative">
                <x-sidebar />

                <div class="nav-item position-absolute bottom-0 w-100">
                    <a href="#" class="nav-link sidebar-toggle" @click="open = !open">
                        <i class="fas fa-angle-double-left"></i>
                        <span>Collapse sidebar</span>
                    </a>
                </div>
            </div>
        </nav>

        <main class="ms-sm-auto flex-grow-1" style="overflow: auto">
            <?= $this->include('_header') ?>

            <div class="px-md-4 vh-100" style="margin-top: -48px; padding-top: 48px;">
                <?= $this->renderSection('main') ?>
            </div>
        </main>
    </div>
</div>

<?= asset_link('other/bs5/js/bootstrap.js', 'js') ?>
<?= asset_link('other/js/cdn.js', 'js') ?>
<?= asset_link('other/js/htmx.js', 'js') ?>
<?= asset_link('admin/js/admin.js', 'js') ?>
<?= $this->renderSection('scripts') ?>
<?= $viewMeta->render('script') ?>
<?= $viewMeta->render('rawScripts') ?>
</body></html>
