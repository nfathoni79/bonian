<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $banner
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
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Banner') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Tambah Banner') ?>
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
                            <?= __('Tambah Banner') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($banner,['class' => 'm-form m-form--label-align-left', 'id' => 'form-banner','type' => 'file']); ?>

            <div class="m-portlet__body">
                <?php
                    echo $this->Flash->render();
                    $default_class = 'form-control m-input';
                ?>
                <div class="m-form__section m-form__section--first">
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Kategori </label>
                        <div class="col-lg-4">
                            <?php echo $this->Form->control('product_category_id', ['label' => false, 'div' => false, 'options' => $productCategories, 'empty' => 'Pilih Kategori', 'class' => $default_class]);?>
                            <span class="m-form__help">Non Mandatory, Jika pilihan kategory di pilih maka banner akan di tampilkan pada produk list banner berdasarkan kategory.</span>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Posisi </label>
                        <div class="col-lg-4">
                            <?php
                                 echo $this->Form->control('position', ['options' => [
                                    'Home Top' => 'Home Top',
                                    'Home Bottom Left' => 'Home Bottom Left',
                                    'Home Bottom Right' => 'Home Bottom Right',
                                    'Product List By Category' => 'Product List By Category',
                                ], 'empty' => 'Pilih Posisi', 'label' => false, 'required' => false, 'div' => false, 'class' => $default_class]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Url Action </label>
                        <div class="col-lg-4">
                            <?php
                                echo $this->Form->control('url', ['label' => false, 'div' => false,'empty' => true, 'required' => false, 'class' => $default_class]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Gambar Banner </label>
                        <div class="col-lg-4">
                            <?php
                                echo $this->Form->control('name', ['label' => false, 'div' => false,'type' => 'file','empty' => true, 'required' => false, 'class' => $default_class]);
                            ?>
                            <span class="m-form__help">Minimum demention size : 796x235 px</span>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Status </label>
                        <div class="col-lg-1">
                            <?php
                                echo $this->Form->control('status', ['label' => false, 'div' => false, 'options' => [0 => 'Off', 1 => 'On' ], 'required' => false, 'class' => $default_class]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-10 ml-lg-auto">
                            <?= $this->Form->submit(__('Submit'),['class' => 'btn btn-brand']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<?php
$this->Html->script([
'/admin-assets/vendors/custom/libs/validation-render',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>
    $(document).ready(function () {
        var select = $('#product-category-id').val();
        if(select){
            $('#position').val("Product List By Category");
            $('#position').prop('disabled', true);
        }else{
            $('#position').val("");
            $('#position').prop('disabled', false);
        }

        $('#product-category-id').on('change',function(){
            var selected = $(this).val();
            if(selected){
                $('#position').val("Product List By Category");
                $('#position').prop('disabled', true);
            }else{
                $('#position').val("");
                $('#position').prop('disabled', false);
            }
        })
    })
</script>
<?php $this->end(); ?>
