<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $product
 */
?>


<?php $this->append('script'); ?>
<?php echo $this->Html->script('/admin-assets/demo/default/custom/crud/wizard/wizard'); ?>
<script>
    $(document).ready(function(){
        $('.add-attribute').on('click',function(){
            var selected = $('#options').val();
            var text = $('#options option:selected').text();
            var disabled = $('#options option:selected').attr('disabled');
            if(disabled == 'disabled'){
                return false;
            }
            $('#options option[value="'+selected+'"]').attr("disabled", true);
            $('.dynamic-form').append('<div class="'+text.toLowerCase()+'"><div class="m-form__heading mt-5"><h3 class="m-form__heading-title pull-left">Attribute '+text+' <a href="#" class="btn btn-success btn-sm add-role" data-attribute="'+text.toLowerCase()+'" data-value="'+selected+'"><span>Add New Option '+text+'</span></a></h3><a href="#" class="btn btn-danger btn-sm remove-attribute pull-right" data-attribute="'+text.toLowerCase()+'" data-value="'+selected+'"><span>Remove Attribute</span></a><div class="clearfix"></div></div><div class="form-group m-form__group row"> <div class="col-xl-2"><input type="text" name="options_values_id" class="form-control m-input" placeholder="select options"></div> <div class="col-xl-2"><input type="text" name="price" class="form-control m-input" placeholder="price"></div><div class="col-xl-2"><input type="text" name="weight" class="form-control m-input" placeholder="weight"></div><div class="col-xl-2"><input type="text" name="stock"  class="form-control m-input" placeholder="stock"></div><div class="col-xl-1"><input type="text" name="width"  class="form-control m-input" placeholder="width"></div> <div class="col-xl-1"><input type="text" name="length" class="form-control m-input" placeholder="length"></div> <div class="col-xl-1"><input type="text" name="height" class="form-control m-input" placeholder="height"></div>  <div class="col-xl-1"><a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only"><i class="la la-trash"></i></a></div>  </div></div>');



            $('.remove-attribute').on('click',function(){
                var selected  = $(this).data('value');
                var text  = $(this).data('attribute');
                $('select#options option[value="'+selected+'"]').prop('disabled', false);
                $('div').remove('.'+text);
            })
        });
    })
</script>
<script>
    $('select').selectpicker();
</script>


<?php $this->end(); ?>
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
        <div class="m-portlet m-portlet--full-height">

            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <?= __('Add Product') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" data-toggle="m-tooltip" class="m-portlet__nav-link m-portlet__nav-link--icon" data-direction="left" data-width="auto" title="Get help with filling up this form">
                                <i class="flaticon-info m--icon-font-size-lg3"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m-portlet__body m-portlet__body--no-padding">
                <div class="m-wizard m-wizard--3 m-wizard--success" id="m_wizard">

                    <div class="m-portlet__padding-x">
                        <!-- Here you can put a message or alert -->
                        <?php  echo $this->Flash->render(); ?>
                    </div>

                    <div class="row m-row--no-padding">
                        <div class="col-xl-3 col-lg-12">

                            <!--begin: Form Wizard Head -->
                            <div class="m-wizard__head">

                                <!--begin: Form Wizard Progress -->
                                <div class="m-wizard__progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Progress -->
                                <!--begin: Form Wizard Nav -->
                                <div class="m-wizard__nav">
                                    <div class="m-wizard__steps">
                                        <div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1">
                                            <div class="m-wizard__step-info">
                                                <a href="#" class="m-wizard__step-number">
                                                    <span><span>1</span></span>
                                                </a>
                                                <div class="m-wizard__step-line">
                                                    <span></span>
                                                </div>
                                                <div class="m-wizard__step-label">
                                                   General
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                            <div class="m-wizard__step-info">
                                                <a href="#" class="m-wizard__step-number">
                                                    <span><span>2</span></span>
                                                </a>
                                                <div class="m-wizard__step-line">
                                                    <span></span>
                                                </div>
                                                <div class="m-wizard__step-label">
                                                   Inventory & pricing
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                                            <div class="m-wizard__step-info">
                                                <a href="#" class="m-wizard__step-number">
                                                    <span><span>3</span></span>
                                                </a>
                                                <div class="m-wizard__step-line">
                                                    <span></span>
                                                </div>
                                                <div class="m-wizard__step-label">
                                                    Shipping & Attributes
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4">
                                            <div class="m-wizard__step-info">
                                                <a href="#" class="m-wizard__step-number">
                                                    <span><span>4</span></span>
                                                </a>
                                                <div class="m-wizard__step-line">
                                                    <span></span>
                                                </div>
                                                <div class="m-wizard__step-label">
                                                    Advanced
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end: Form Wizard Nav -->
                            </div>

                        </div>
                        <div class="col-xl-9 col-lg-12">
                            <div class="m-wizard__form">
                                <?=
                                $this->Form->create($product,['class' => 'm-form m-form--label-align-left- m-form--state-', 'id' =>'m_form']);
                                $default_class = 'form-control m-input';
                                ?>
                                    <div class="m-portlet__body m-portlet__body--no-padding">

                                        <!--begin: Form Wizard Step 1-->
                                        <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Product Information</h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('name',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Title</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('title',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Slug</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('slug',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                            <div class="m-form__section">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">
                                                        Product Descriptions
                                                    </h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Highlight</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('highlight',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Condition</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('condition',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Profile</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('profile',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                            <div class="m-form__section">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">
                                                        SEO Setting
                                                    </h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Keyword</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('ProductMetaTags.keyword',['type' => 'textarea','label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Description</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('description',['type' => 'textarea','label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="m-form__section">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Attributes</h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Selector Attribute</label>
                                                    <div class="col-xl-3">
                                                        <?php echo $this->Form->control('options',['div' => false, 'label' => false,'options' => $options, 'class' => $default_class]);?>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon add-attribute">
                                                            <span>Add</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="dynamic-form"></div>

                                            </div>














                                        </div>

                                        <!--begin: Form Wizard Step 2-->
                                        <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Inventory</h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-form-label">* Model</label>
                                                    <div class="col-xl-3">
                                                        <?php echo $this->Form->control('model',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                    <label class="col-xl-2 offset-1 col-form-label">* Code</label>
                                                    <div class="col-xl-3">
                                                        <?php echo $this->Form->control('code',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-form-label">* Sku</label>
                                                    <div class="col-xl-3">
                                                        <?php echo $this->Form->control('sku',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                    <label class="col-xl-2 offset-1 col-form-label">* Isbn</label>
                                                    <div class="col-xl-3">
                                                        <?php echo $this->Form->control('isbn',['label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Stock Status</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <?php echo $this->Form->control('product_stock_status_id', ['options' => $productStockStatuses,'label' => false, 'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                            <div class="m-form__section">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Pricing</h3>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Regular Price</label>
                                                    <div class="col-xl-5 col-lg-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">IDR</span></div>
                                                            <?php echo $this->Form->control('price',['div' => false, 'label' => false,'class' => $default_class]);?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Sale Price</label>
                                                    <div class="col-xl-5 col-lg-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">IDR</span></div>
                                                            <?php echo $this->Form->control('price_sale',['div' => false, 'label' => false,'class' => $default_class]);?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Discount</label>
                                                    <div class="col-xl-9 col-lg-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">%</div>
                                                            <?php echo $this->Form->control('price_discount',['div' => false, 'label' => false,'class' => $default_class, 'disabled' => 'disabled']);?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Step 2-->


                                        <!--begin: Form Wizard Step 3-->
                                        <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                            <div class="m-form__section m-form__section--first">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Shippings</h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-12 m-form__group-sub">
                                                        <label class="form-control-label">Courrier </label>
                                                        <div class="m-checkbox-inline">
                                                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                                <input type="checkbox" name="account_communication[]" checked value="JNE"> JNE
                                                                <span></span>
                                                            </label>
                                                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                                <input type="checkbox" name="account_communication[]" checked value="JNT"> JNT
                                                                <span></span>
                                                            </label>
                                                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                                <input type="checkbox" name="account_communication[]" checked value="TIKI"> TIKI
                                                                <span></span>
                                                            </label>
                                                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                                <input type="checkbox" name="account_communication[]" checked value="POS"> POS
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        <span class="m-form__help">Select courriers options</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                            <div class="m-form__section">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">Attributes</h3>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-2 col-form-label">Selector</label>
                                                    <div class="col-xl-3">
                                                        <?php echo $this->Form->control('options',['div' => false, 'label' => false,'options' => $options, 'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--end: Form Wizard Step 3-->


                                    </div>

                                    <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                                        <div class="m-form__actions">
                                            <div class="row">
                                                <div class="col-lg-6 m--align-left">
                                                    <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                                                        <span><i class="la la-arrow-left"></i>&nbsp;&nbsp;<span>Back</span></span>
                                                    </a>
                                                </div>
                                                <div class="col-lg-6 m--align-right">
                                                    <a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
                                                        <span>
                                                            <i class="la la-check"></i>&nbsp;&nbsp;
                                                            <span>Submit</span>
                                                        </span>
                                                    </a>
                                                    <a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
                                                        <span>
                                                            <span>Continue</span>&nbsp;&nbsp;
                                                            <i class="la la-arrow-right"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?= $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

