<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $customer
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Pelanggan') ?>
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
                                <?= __('Pelanggan') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Pelanggan') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Edit Pelanggan') ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <?= __('Edit Pelanggan') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($customer,['class' => 'm-login__form m-form']); ?>
            <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
            ?>
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-2 col-form-label">Kode Refferal</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?= $customer['reffcode'];?></p>
                    </div>
                    <label class="col-2 col-form-label">Email</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?= $customer['email'];?></p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-2 col-form-label">Nama Lengkap</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?= $customer['first_name'];?> <?= $customer['last_name'];?></p>
                    </div>
                    <label class="col-2 col-form-label">Username</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?= $customer['username'];?></p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-2 col-form-label">Telepon</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?= $customer['phone'];?></p>
                    </div>
                    <label class="col-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?= $customer['dob'];?></p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-2 col-form-label">Platform Registered</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?= $customer['platforrm'];?></p>
                    </div>
                    <?php $group = $customerGroups->toArray(); ?>
                    <label class="col-2 col-form-label">Kategori Akun</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?= $group[$customer['customer_group_id']];?></p>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-2 col-form-label">Status Akun</label>
                    <div class="col-4">
                        <p class="form-control-static mt-2"><?php echo $this->Form->control('customer_status_id', ['options' => $customerStatuses, 'empty' => true, 'div' => false, 'label' => false]);?></p>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <?= $this->Form->submit(__('Simpan'),['class' => 'btn btn-brand']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
<script>
    $('select').selectpicker();
</script>

