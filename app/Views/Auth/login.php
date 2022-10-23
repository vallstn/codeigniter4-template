<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="container container-tight my-5 px-lg-5">
	<div class="text-center mb-4">
		<a href="." class="navbar-brand navbar-brand-autodark"><img src="<?=base_url("resource/favicon.ico")?>" height="66" alt=""></a>
        <br/><?= lang('Auth.login') ?>
	</div>
	<form action="<?= route_to('login') ?>" method="post" autocomplete="off" novalidate>
		<?= csrf_field() ?>
		<!-- Email / Username-->
		<div class="mb-3">
			<label class="form-label"><?= lang('Auth.identity') ?></label>
			<input type="text" class="form-control" name="identity" id="identity" placeholder="<?= lang('Auth.identity') ?>" value="<?= old('identity') ?>" required autocomplete="off">
		</div>
		<!-- Password-->
		<div class="mb-2">
			<label class="form-label">
				<?= lang('Auth.password') ?>
				<span class="form-label-description">
			  <a href="<?= route_to('magic-link') ?>"><?= lang('Auth.forgotPassword') ?></a>
			</span>
			</label>
			<div class="input-group input-group-flat">
				<input type="password" class="form-control"  name="password" id="password" autocomplete="off" placeholder="<?= lang('Auth.password') ?>" value="" onchange="encr(this.value)" required  autocomplete="off">
			</div>
		</div>
		<?php if ($allowRemember) : ?>
		<div class="mb-2">
			<label class="form-check">
				<input type="checkbox" class="form-check-input" value="1" name="remember" id="remember" />
				<span class="form-check-label"><?= lang('Auth.rememberMe') ?></span>
			</label>
		</div>
		<?php endif ?>
		<!-- Email / Username-->
		<div class="mb-3">
			<?= $_SESSION['image']; ?>
			<input type="text" class="form-control" name="captcha" id="captcha" placeholder="<?= lang('Auth.captcha') ?>" value="" required autocomplete="off">
		</div>
		<div class="form-footer">
			<input type="hidden" id="salt" name="salt" class="form-control">
			<input type="hidden" id="captcha_id" name="captcha_id" value="<?= $_SESSION['captcha_id']; ?>" class="form-control">
			<button type="submit" class="btn btn-primary w-100"><?= lang('Auth.login') ?></button>
		</div>
	</form>
	<?php if (setting('Auth.allowRegistration')) : ?>
		<div class="text-center text-muted mt-3">
			<?= lang('Auth.needAccount') ?> <a href="<?= route_to('register') ?>"><?= lang('Auth.register') ?></a>
		</div>
	<?php endif ?>
</div>

<script type="text/javascript">
    function encr(passwd){

        var sessionValue = "<?= $_SESSION['salt']; ?>";
        let valueToEncrypt = passwd; // this could also be object/array/whatever
        let hook = sessionValue;
        let encrypted = CryptoJSAesJson.encrypt(valueToEncrypt, hook);
        document.getElementById("password").value = encrypted;
        document.getElementById("salt").value = hook;
    }
</script>
<?= $this->endSection() ?>
