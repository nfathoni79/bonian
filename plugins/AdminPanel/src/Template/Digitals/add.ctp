<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $page
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Produk Digital') ?>
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
                                <?= __('Produk Digital') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Tambah Produk Pulsa') ?>
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
                            <?= __('Tambah Produk Pulsa') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($digitalDetail,['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.form_mini']); ?>
            <div class="m-portlet__body col-lg-8 ">
                <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                echo $this->Form->control('code',['class' => $default_class, 'label' => 'Kode Produk']);
                echo $this->Form->control('name',['class' => $default_class, 'required' => false, 'label' => 'Nama Produk'],['fieldset' => false]);
                echo $this->Form->control('denom',['type' => 'text','class' => $default_class. ' numberinput', 'required' => false, 'label' => 'Denom', 'escape' => false],['fieldset' => false]);
                echo $this->Form->control('operator',[
                    'class' => $default_class,
                    'required' => false,
                    'options' => [
                        'Axis' => 'Axis',
                        'Indosat'=> 'Indosat',
                        'Smartfren'=> 'Smartfren',
                        'Telkomsel'=> 'Telkomsel',
                        'Tri'=> 'Tri',
                        'XL'=> 'XL'
                    ],
                    'empty' => 'Pilih Operator',
                ]);
                echo $this->Form->control('price',['type' => 'text','class' => $default_class. ' numberinput', 'required' => false, 'label' => 'Price', 'escape' => false],['fieldset' => false]);
                echo $this->Form->control('status',['class' => $default_class, 'required' => false, 'label' => 'Status', 'options' => ['0' => 'Close', '1' => 'Open']]);
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
    $(document).ready(function(){
        $('input.numberinput').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
        });
    })
</script>
