<?= $this->extend('master') ?>
<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>
<?= $this->section('main') ?>

<div class="container container-tight my-5 px-lg-5">
    <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?=base_url("resource/favicon.ico")?>" height="66" alt=""></a>
        <br/><?= lang('Auth.register') ?>
    </div>
    <form action="<?= route_to('register') ?>" method="post" autocomplete="off" novalidate>
        <?= csrf_field() ?>
        <!-- Email -->
        <div class="mb-3">
            <label class="form-label"><?= lang('Auth.email') ?></label>
            <input type="email" class="form-control" name="email" id="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required autocomplete="off">
        </div>
        <!-- username -->
        <div class="mb-3">
            <label class="form-label"><?= lang('Auth.username') ?></label>
            <input type="text" class="form-control" name="username" id="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required autocomplete="off">
        </div>
        <!-- Password-->
        <div id="pass-suggestions"></div>
        <div class="mb-3">
            <label class="form-label"><?= lang('Auth.password') ?></label>
            <div class="row" >
                <div class="col" >
                    <input type="password" class="form-control" name="password" id="password" autocomplete="password"
                           placeholder="<?= lang('Auth.password') ?>"
                           onkeyup="checkStrength()" required
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
        </div>
        <div class="mb-3">
            <label class="form-label"><?= lang('Auth.passwordConfirm') ?></label>
            <div class="row">
                <div class="col">
                    <input type="password" class="form-control" name="password_confirm" id="password_confirm" autocomplete="password_confirm"
                           placeholder="<?= lang('Auth.passwordConfirm') ?>" required onkeyup="checkPasswordMatch()" />
                </div>
                <div class="col-auto pass-match-wrap">
                    <div class="pass-match" id="pass-match" style="display:none"><span>&check;</span></div>
                    <div class="pass-not-match" id="pass-not-match" style="display:none"><span>&times;</span></div>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <input type="hidden" id="salt" name="salt" class="form-control">
            <input type="hidden" id="captcha_id" name="captcha_id" value="<?= $_SESSION['captcha_id']; ?>" class="form-control">
            <button type="submit" class="btn btn-primary w-100"><?= lang('Auth.register') ?></button>
        </div>
    </form>
    <p class="text-center"><?= lang('Auth.haveAccount') ?> <a href="<?= route_to('login') ?>"><?= lang('Auth.login') ?></a></p>
</div>

<?= asset_link('other/js/passStrength.js', 'js') ?>
<script src="/zxcvbn.js"></script>
<?= $this->endSection() ?>
