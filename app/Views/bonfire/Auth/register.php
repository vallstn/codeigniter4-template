<?php $this->extend('master'); ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>
<x-unsplash>
    <div class="container d-flex justify-content-center p-5">
        <x-auth-card>
            <div class="card-body">
                <h5 class="card-title mb-5"><?= lang('Auth.register') ?></h5>

                <form action="<?= url_to('register') ?>" method="post" x-data="{ showPassword: false, password: '' }">
                    <?= csrf_field() ?>
					
					<!-- First Name -->
                    <div class="mb-2">
                        <input type="text" class="form-control" name="first_name" autocomplete="first_name" placeholder="<?= lang('Auth.first_name') ?>" value="<?= old('first_name') ?>" required />
                    </div>
					
					<!-- Last Name -->
                    <div class="mb-2">
                        <input type="text" class="form-control" name="last_name" autocomplete="last_name" placeholder="<?= lang('Auth.last_name') ?>" value="<?= old('last_name') ?>" required />
                    </div>

                    <!-- Email -->
                    <div class="mb-2">
                        <input type="email" class="form-control" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                    </div>

                    <!-- Username -->
                    <div class="mb-2">
                        <input type="text" class="form-control" name="username" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required />
                    </div>
					
					<!-- phone -->
                    <div class="mb-2">
                        <input type="text" class="form-control" name="phone" autocomplete="phone" placeholder="<?= lang('Auth.mobile') ?>" value="<?= old('phone') ?>" required />
                    </div>
					
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

                    <div id="pass-suggestions"></div>

                    <div class="row mb-2">
                        <!-- Password -->
                        <div class="col pass-eye-parent">
                            <div class="pass-eye pass-eye-register" x-on:click="showPassword = !showPassword">
                                <i x-bind:class="showPassword ? 'fa-eye-slash' : 'fa-eye'" class="fa-regular"></i>
                            </div>
                            <input type="password" class="form-control" name="password" id="password" autocomplete="password"
                                placeholder="<?= lang('Auth.password') ?>" value=""
                                x-on:keyup="checkStrength(); debouncedCheckPasswordMatch()" x-model:value="password" x-bind:type="showPassword ? 'text' : 'password'" required
                            />
                        </div>
                        <!-- Password Meter -->
                        <div class="col-auto" style="margin-left: 0">
                            <div id="pass-meter">
                                <div class="segment segment-4"></div>
                                <div class="segment segment-3"></div>
                                <div class="segment segment-2"></div>
                                <div class="segment segment-1"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Password (Again) -->
                    <div class="row mb-5" x-show="!showPassword">
                        <div class="col">
                            <input x-bind:disabled="showPassword" type="password" class="form-control" name="password_confirm" id="pass_confirm" 
                                autocomplete="password_confirm" placeholder="<?= lang('Auth.passwordConfirm') ?>" required x-on:keyup="debouncedCheckPasswordMatch()"
                            />
                            <!--hidden input in case the first one is disabled-->
                            <input type="hidden" name="password_confirm" value="" x-bind:disabled="!showPassword" x-model:value="password">
                        </div>
                        <div class="col-auto pass-match-wrap">
                            <div class="pass-match" id="pass-match" style="display:none"><i class="fa-regular fa-circle-check"></i></div>
                            <div class="pass-not-match" id="pass-not-match" style="display:none"><i class="fa-regular fa-circle-xmark"></i></div>
                        </div>
                    </div>

                    <div class="d-grid col-23 mx-auto m-3">
                        <button type="submit" class="btn btn-primary btn-block btn-lg"><?= lang('Auth.register') ?></button>
                    </div>

                    <p class="text-center"><?= lang('Auth.haveAccount') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a></p>

                </form>
            </div>
        </x-auth-card>
    </div>
</x-unsplash>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= asset_link('auth/js/passStrength.js', 'js') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
<?= $this->endSection() ?>
