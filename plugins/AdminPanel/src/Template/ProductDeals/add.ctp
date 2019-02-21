<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productDeal
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Promosi Penjualan') ?>
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
                                <?= __('Promosi Penjualan') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Flash Sale') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Flash Sale') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Tambah Flash Sale') ?>
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
                            <?= __('Tambah Flash Sale') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($productDeal,['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.form_mini']); ?>
            <div class="m-portlet__body">

            <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                echo $this->Form->control('name',['class' => $default_class,'label' => 'Judul Promosi']);
            ?>
            <?php
                echo $this->Form->control('date_start',['type' => 'text','class' => $default_class, 'id' => 'm_datetimepicker_start', 'label' => 'Mulai Promosi']);
                echo $this->Form->control('date_end',['type' => 'text','class' => $default_class, 'id' => 'm_datetimepicker_end','label' => 'Selesai Promosi']);
                echo $this->Form->control('status',['options' => ['0' => 'Pending', '1' => 'Berjalan', '2' => 'Berakhir'],'class' => $default_class, 'id' => 'm_datetimepicker_end','label' => 'Status']);
            ?>
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

    $('#m_datetimepicker_start').datetimepicker({
        startDate: '-0d',
        todayHighlight: true,
        autoclose: true,
        pickerPosition: 'bottom-left',
        format: 'yyyy-mm-dd hh:ii',
    });
    $('#m_datetimepicker_end').datetimepicker({
        startDate: '-0d',
        todayHighlight: true,
        autoclose: true,
        pickerPosition: 'bottom-left',
        format: 'yyyy-mm-dd hh:ii',
    });
</script>

