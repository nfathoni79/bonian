<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $voucher
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Voucher') ?>
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
                                <?= __('Voucher') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Voucher') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Edit Voucher') ?>
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
                            <?= __('Edit Voucher') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($voucher,['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.form_mini']); ?>
            <div class="m-portlet__body">

                <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                echo $this->Form->control('code_voucher',['class' => $default_class, 'label' => 'Code Voucher']);
                echo $this->Form->control('date_start',['type' => 'text','class' => $default_class, 'id' => 'm_datetimepicker_start', 'label' => 'Tanggal Mulai']);
                echo $this->Form->control('date_end',['type' => 'text','class' => $default_class, 'id' => 'm_datetimepicker_end', 'label' => 'Tanggal Berakhir']);
                echo $this->Form->control('qty',['class' => $default_class, 'label' => 'Quantity']);
                echo $this->Form->control('type',['class' => $default_class, 'label' => 'Tipe', 'options' => ['1' => 'Diskon (%)', '2' => 'Potongan Harga']]);
                echo $this->Form->control('value',['class' => $default_class, 'label' => 'Nilai', 'placeholder' => ' value % (30), atau cashbak 1000000']);
                echo $this->Form->control('status',['class' => $default_class, 'label' => 'Status', 'options' => ['1' => 'Aktif', '2' => 'Tidak Aktif']]);
                ?>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <?= $this->Form->submit(__('Submit'),['class' => 'btn btn-brand']) ?>
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

