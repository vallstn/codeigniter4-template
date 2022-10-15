<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>
<x-unsplash>

    <div class="container d-flex justify-content-center p-5">
        <x-auth-card>
            <div class="card-body">
                <h5 class="card-title mb-5"><?= lang('Auth.login') ?></h5>

                <form action="<?= route_to('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <!-- Email / Username-->
                    <div class="mb-2">
                        <input type="text" class="form-control" name="identity" id="identity" placeholder="<?= lang('Auth.identity') ?>" value="<?= old('identity') ?>" required />
                    </div>
                    <!-- Password -->
                    <div class="mb-2">
                        <input type="password" class="form-control" name="password" id="password" autocomplete="off" placeholder="<?= lang('Auth.password') ?>" value="" onchange="encr(this.value)" required />
                    </div>				
					<div class="mb-2">
						<?= $_SESSION['image']; ?>
                        <input type="text" class="form-control" name="captcha" id="captcha" placeholder="<?= lang('Auth.captcha') ?>" value="" required />
                    </div>
                    <?php if ($allowRemember) : ?>
                        <div class="form-check my-4">
                            <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                <?= lang('Auth.rememberMe') ?>
                            </label>
                        </div>
                    <?php endif ?>					
                    <div class="d-grid col-12 mx-auto m-5">
						<input type="hidden" id="salt" name="salt" class="form-control">
						<input type="hidden" id="captcha_id" name="captcha_id" value="<?= $_SESSION['captcha_id']; ?>" class="form-control">
                        <button type="submit" class="btn btn-primary btn-block btn-lg"><?= lang('Auth.login') ?></button>
                    </div>

                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                        <p class="text-center"><?= lang('Auth.forgotPassword') ?> <a href="<?= route_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
                    <?php endif ?>

                    <?php if (setting('Auth.allowRegistration')) : ?>
                        <p class="text-center"><?= lang('Auth.needAccount') ?> <a href="<?= route_to('register') ?>"><?= lang('Auth.register') ?></a></p>
                    <?php endif ?>

                </form>
            </div>
        </x-auth-card>
    </div>
</x-unsplash>

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