<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $product
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Product') ?>
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
                                <?= __('Product') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Product') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Add Product') ?>
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
                            <?= __('Add Product') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($product,['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form']); ?>
            <div class="m-portlet__body">

            <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                echo $this->Form->control('name',['class' => $default_class]);
                echo $this->Form->control('title',['class' => $default_class]);
                echo $this->Form->control('slug',['class' => $default_class]);
                echo $this->Form->control('model',['class' => $default_class]);
                echo $this->Form->control('code',['class' => $default_class]);
                echo $this->Form->control('sku',['class' => $default_class]);
                echo $this->Form->control('isbn',['class' => $default_class]);
                echo $this->Form->control('qty',['class' => $default_class]);
                echo $this->Form->control('product_stock_status_id', ['options' => $productStockStatuses, 'empty' => true, 'class' => $default_class]);
                echo $this->Form->control('shipping',['class' => $default_class]);
                echo $this->Form->control('price',['class' => $default_class]);
                echo $this->Form->control('price_discount',['class' => $default_class]);
                echo $this->Form->control('weight',['class' => $default_class]);
                echo $this->Form->control('product_weight_class_id', ['options' => $productWeightClasses, 'empty' => true, 'class' => $default_class]);
                echo $this->Form->control('product_status_id', ['options' => $productStatuses, 'class' => $default_class]);
                echo $this->Form->control('highlight',['class' => $default_class]);
                echo $this->Form->control('condition',['class' => $default_class]);
                echo $this->Form->control('profile',['class' => $default_class]);
                echo $this->Form->control('view',['class' => $default_class]);
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
</script>

