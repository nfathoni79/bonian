<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productCategory
 */
?>
<?php $this->append('script'); ?>
<?php
echo $this->Html->script([
    '/admin-assets/vendors/custom/slugify/speakingurl.min',
    '/admin-assets/vendors/custom/slugify/slugify.min',
    '/admin-assets/vendors/custom/libs/validation-render',
]);
?>
<script>
    $(document).ready(function() {
        $('#slug').slugify('#title'); // Type as you slug
    })
</script>
<?php $this->end(); ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Kategori Produk') ?>
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
                                <?= __('Kategori Produk') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Kategori Produk') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Tambah Kategori') ?>
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
                            <?= __('Tambah Kategori') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($productCategory,['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form','type' => 'file']); ?>
            <div class="m-portlet__body">

            <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                echo $this->Form->control('parent_id', ['options' => $parentProductCategories, 'empty' => true, 'class' => $default_class]);
                echo $this->Form->control('name',['class' => $default_class, 'id' => 'title']);
                echo $this->Form->control('slug',['class' => $default_class, 'id' => 'slug']);
                echo $this->Form->control('description',['class' => $default_class]);
                echo $this->Form->control('path',['class' => $default_class, 'type' => 'file']);
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
<?php
$this->Html->script([
'/admin-assets/app/js/jquery.slug'
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>
    $('select').selectpicker();

    $("#name").slug({
        slug:'permalink', // class of input / span that contains the generated slug
        hide: false        // hide the text input, true by default
    });
</script>
<?php $this->end(); ?>