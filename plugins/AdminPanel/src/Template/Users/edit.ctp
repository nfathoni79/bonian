<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Pengaturan Pengguna
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Pengaturan Pengguna
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Daftar Pengguna
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Edit Pengguna
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Edit Pengguna
                            <!-- <small>
                                data loaded from remote data source
                            </small> -->
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>
            <!--begin::Form-->
            <?= $this->Form->create($user, ['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form']); ?>
                <div class="m-portlet__body">
                    <?php
                    echo $this->Flash->render();
                    $default_class = 'form-control form-control-danger m-input m-input--air';
                    echo $this->Form->controls([
                            'email' => ['class' => $default_class,'label' => 'Alamat Email'],
                            'username' => ['class' => $default_class,'label' => 'Username'],
                            'first_name' => ['class' => $default_class,'label' => 'Nama Depan'],
                            'last_name' => ['class' => $default_class,'label' => 'Nama Belakang'],
                            'password' => ['class' => $default_class, 'required' => false, 'value' => '','label' => 'Password'],
                            'repeat_password' => ['type' => 'password', 'class' => $default_class, 'required' => false, 'value' => '','label' => 'Konfirmasi Password'],
                            'group_id' => ['class' => $default_class, 'empty' => 'Pilihan','label' => 'Jenis Pengguna'],
                            'user_status_id' => ['class' => $default_class, 'empty' => 'Pilihan', 'options' => $user_status,'label' => 'Status Pengguna'],
                    ], ['fieldset' => false])
                    ?>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-brand">
                                    Simpan
                                </button>
                                <button type="submit" class="btn btn-secondary">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?= $this->Form->end(); ?>
            <!--end::Form-->
        </div>
    </div>
</div>
<!-- end:: Body -->
<script>
    $('select').selectpicker();
</script>
