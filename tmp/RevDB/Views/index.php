<?= $this->extend('master') ?>


<?= $this->section('main') ?>
<?php foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" /> 
<?php endforeach; ?>

<?php foreach($js_files as $file): ?> 
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<!-- Beginning of main content -->
<div style='height:20px;'></div> 
<div style='padding: 10px;'>
	<?php echo $data; ?>
</div>
 <!-- End of main content -->

<?= $this->endSection() ?>