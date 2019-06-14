<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(<?= $this->Url->build('/admin-assets/app/media/img/bg/bg-3.jpg'); ?>">
        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="#">
                        <?= $this->Html->image('/admin-assets/media/logos/logo-white.png'); ?>
                    </a>
                </div>
                <div class="m-login__signin">
                    <?= $this->Flash->render() ?>
                    <?= $this->Form->create(null, ['class' => 'm-login__form m-form']); ?>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input"   type="text" placeholder="Email" name="email" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Sign In
                            </button>
                        </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->