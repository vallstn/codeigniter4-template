<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>
<x-unsplash>

    <div class="container d-flex justify-content-center p-5">
        <x-auth-card>
            <div class="card-body">
                <h5 class="card-title mb-5"><?= lang('Auth.login') ?></h5>

                <form action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Login Field -->
                    <div class="mb-2">
                        <input type="text" class="form-control" name="login"  placeholder="<?= lang('Auth.itentidy') ?>" value="<?= old('login') ?>" required />
                    </div>

                    <!-- Password -->
                    <div class="mb-2 pass-eye-parent" x-data="{ showPassword: false }">
                        <div class="pass-eye" x-on:click="showPassword = !showPassword">
                            <i x-bind:class="showPassword ? 'fa-eye-slash' : 'fa-eye'" class="fa-regular"></i>
                        </div>
                        <input type="password" class="form-control" name="password" id="password" autocomplete="off"  onchange="encr(this.value)"
                            placeholder="<?= lang('Auth.password') ?>" x-bind:type="showPassword ? 'text' : 'password'" required
                        />
                    </div>

                    <?php if ($allowRemember) : ?>
                        <div class="form-check my-4">
                            <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                <?= lang('Auth.rememberMe') ?>
                            </label>
                        </div>
                    <?php endif ?>
					
					<div class="mb-2">
						<label class="form-label">
							<?= lang('Auth.captcha') ?>	
						</label>
						<div class="card">
						<div class="input-group input-group-flat bg-dark-lt">
							<span id="Captcha-image"><img src="<?php echo $image; ?>" /></span> &nbsp; 
							<div hx-get="<?php echo base_url('refreshCaptcha');?>"  hx-target="#Captcha-image" hx-trigger="click" class="btn btn-icon btn-red">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
									<path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
									<path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
								</svg>
							</div> &nbsp; 
							<input type="text" class="form-control" name="captcha" id="captcha" placeholder="<?= lang('Auth.EnterCaptcha') ?>" value="" required autocomplete="off">
						</div>
						</div>
					</div>

                    <div class="d-grid col-12 mx-auto m-5">
                        <button type="submit" class="btn btn-primary btn-block btn-lg"><?= lang('Auth.login') ?></button>
                    </div>

                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                        <p class="text-center"><?= lang('Auth.forgotPassword') ?> <a href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
                    <?php endif ?>

                    <?php if (setting('Auth.allowRegistration')) : ?>
                        <p class="text-center"><?= lang('Auth.needAccount') ?> <a href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
                    <?php endif ?>

                </form>
            </div>
        </x-auth-card>
    </div>	

</x-unsplash>

	<script type="text/javascript">	
	
		function encr(passwd){
			
			var sessionValue = "<?= session('salt');?>";
			
			let valueToEncrypt = passwd; 
			let hook = sessionValue;
			let encrypted = CryptoJSAesJson.encrypt(valueToEncrypt, hook);
			document.getElementById("password").value = encrypted;
		}
		
	</script>

<?= $this->endSection() ?>
