<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $product
 */
?>


<?php $this->append('script'); ?>
<?php
    //echo $this->Html->script('/admin-assets/demo/default/custom/crud/wizard/wizard');
    echo $this->Html->script([
            '/admin-assets/vendors/custom/slugify/speakingurl.min',
            '/admin-assets/vendors/custom/slugify/slugify.min',
            '/admin-assets/vendors/custom/libs/validation-render',
    ]);
?>
<script>
    $(document).ready(function() {

        $('#slug').slugify('#title'); // Type as you slug

        var formEl = $("#m_form");

        var url = '<?= $this->Url->build(['action' => 'validationWizard']); ?>';


        var ajaxRequest = new ajaxValidation(formEl);
        ajaxRequest.setblockUI('#m_wizard');



        wizard = new mWizard('m_wizard', {
            startStep: 1
        });


        //== Validation before going to next page
        wizard.on('beforeNext', function(wizardObj) {
            //wizardObj.stop();
        });

        //override next2 with validation ajax
        $("[data-wizard-action=next2]").click(function() {
            var current = formEl.find('.m-wizard__form-step--current :input');
            ajaxRequest.post(url + '/' + wizard.getStep(), current, function(data) {
                if (data.success) {
                    wizard.goNext();
                }
            });
        });

        //== Change event
        wizard.on('change', function(wizard) {
            mUtil.scrollTop();
        });

        //== Change event
        wizard.on('change', function(wizard) {
            if (wizard.getStep() === 1) {
                //alert(1);
            }
        });



        $.ajax({
            url: "<?= $this->Url->build(['action' => 'getoptionvalues']); ?>",
            cache: false,
            method: 'GET',
            success: function(response){
                var options = response;
                var i = 1;
                $('.add-attribute').on('click',function(){


                    var formTemplate = '';
                    $('.option:checked').each(function(){
                        var values = $(this).val();
                        var text = $(this).data('text');

                        var opt = '<option value="">-- Select '+text+' --</option>';
                        $.each(response[text], function(k,v){
                            opt += '<option value="'+v.id+'">'+v.name+'</option>';
                        })
                        formTemplate += '\n' +
                            '\t\t\t<div class="form-group m-form__group row">\n' +
                            '\t\t\t\t<label class="col-xl-4 col-form-label">'+text+'</label>\n' +
                            '\t\t\t\t<div class="col-xl-8">\n' +
                            '\t\t\t\t\t<select name="ProductOptionValues['+i+']['+text.toLowerCase()+']" class="form-control m-input" id="ProductOptionValues'+i+''+text+'">'+opt+'</select>\n' +
                            '\t\t\t\t</div> \n' +
                            '\t\t\t</div>';
                    });

                    var template = '\n' +
                        '<div class="m-accordion__item item-'+i+'">\n' +
                        '<div class="m-accordion__item-head" role="tab" id="m_accordion_2_item_'+i+'_head" data-toggle="collapse" href="#m_accordion_2_item_'+i+'_body" aria-expanded="    false">\n' +
                        '<span class="m-accordion__item-title">Product Variant</span>\n' +
                        '<span class="m-accordion__item-mode"></span>\n' +
                        '</div>\n' +
                        '<div class="m-accordion__item-body collapse show" id="m_accordion_2_item_'+i+'_body" class=" " role="tabpanel" aria-labelledby="m_accordion_2_item_'+i+'_head" data-parent="#m_accordion_2">\n' +
                        '<div class="m-accordion__item-content"> \n' +
                        '<div class="row">\n' +
                        '<div class="col-xl-4">'+formTemplate+'</div>\n' +
                        '<div class="col-xl-8">\n' +
                        '<div class="form-group m-form__group row">\n' +
                        '<div class="col-xl-4"><input type="number" name="ProductOptionPrices['+i+'][price]" class="form-control m-input" placeholder="price"></div>\n' +
                        '<div class="col-xl-4"><input type="number" name="ProductOptionPrices['+i+'][stock]"  class="form-control m-input" placeholder="stock"></div>\n' +
                        '<div class="col-xl-4"><input type="number" name="ProductOptionPrices['+i+'][weight]" class="form-control m-input" placeholder="weight"></div>\n' +
                        '</div> \n' +
                        '<div class="form-group m-form__group row">\n' +
                        '<label class="col-xl-3 col-form-label">Dimension</label>\n' +
                        '<label class="col-xl-9">\n' +
                        '<div class="row">\n' +
                        '<div class="col-xl-3"><input type="number" name="ProductOptionPrices['+i+'][length]" class="form-control m-input" placeholder="length"></div>\n' +
                        '<div class="col-xl-3"><input type="number" name="ProductOptionPrices['+i+'][width]"  class="form-control m-input" placeholder="width"></div>\n' +
                        '<div class="col-xl-3"><input type="number" name="ProductOptionPrices['+i+'][heigth]" class="form-control m-input" placeholder="heigth"></div>\n' +
                        '<div class="col-xl-3"><a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove-row" data-item='+i+'><i class="la la-trash"></i></a></div>\n' +
                        '</div> \n' +
                        '</div> \n' +
                        '</div> \n' +
                        '</div> \n' +
                        '</div> \n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>\n';

                    $('.form-dynamic').append(template);
                    $('.remove-row').on('click',function(){
                        var item = $(this).data('item');
                        $('div').remove('.item-'+item);
                    })
                    i++;
                })


            }
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
                                                    Finish
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
                                                        <?php echo $this->Form->control('ProductMetaTags.description',['type' => 'textarea','label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
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
                                                <div class="form-group m-form__group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Reward Point</label>
                                                    <div class="col-xl-5 col-lg-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text">IDR</span></div>
                                                            <?php echo $this->Form->control('point',['div' => false, 'label' => false,'class' => $default_class]);?>
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
                                                            <?php foreach($courriers as $k => $vals):?>
                                                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                                <input type="checkbox" name="ProductToCourriers[]" value="<?php echo $k;?>"> <?php echo $vals;?>
                                                                <span></span>
                                                            </label>
                                                            <?php endforeach;?>
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
                                                    <div class="col-lg-6 m-form__group-sub">
                                                        <div class="m-checkbox-inline">
                                                            <?php foreach($options as $k => $vals):?>
                                                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                                <input type="checkbox" name="options[]"  value="<?php echo $k;?>" class="option" data-text="<?php echo $vals;?>"> <?php echo $vals;?>
                                                                <span></span>
                                                            </label>
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <a href="javascript:void(0);" class="btn btn-success m-btn m-btn--custom m-btn--icon add-attribute"><span>Add Product Variant</span></a>
                                                    </div>
                                                </div>

                                                <div class="m-accordion m-accordion--bordered form-dynamic" id="m_accordion_2" role="tablist">
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
                                                    <a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon" data-wizard-action="next2">
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

