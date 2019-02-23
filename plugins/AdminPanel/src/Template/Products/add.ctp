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

        $('#slug').slugify('#name'); // Type as you slug

        var formEl = $("#m_form");

        var url = '<?= $this->Url->build(['action' => 'validationWizard']); ?>';
        var url_category = '<?= $this->Url->build(['action' => 'getCategory']); ?>';
        var product;


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

            //additional input hidden
            var elem_id = formEl.find('input[name=id]');
            if (elem_id.length > 0) {
                var len = Object(current).length++;
                current[len] = elem_id[0];
            }

            ajaxRequest.post(url + '/' + wizard.getStep(), current, function(data, saved) {
                if (data.success) {
                    if (typeof saved.data != 'undefined') {
                        product = saved.data; //to get product id use: product.id
                        if (formEl.find('input[name=id]').length == 0) {
                            var addInput = $('<input/>')
                                .attr('name', 'id')
                                .attr('value', product.id)
                                .attr('type', 'hidden');
                            formEl.append(addInput);
                        }
                    }

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

        function setChainCategory(target, parent_id) {
            $.ajax({
                type: 'POST',
                url: url_category,
                data: {parent_id: parent_id, _csrfToken : $('input[name=_csrfToken]').val()},
                success: function (data) {
                    $(target + ' option').remove();
                    var o = [];
                    for(var i in data) {
                        $(target).append($('<option/>').attr('value', i).text(data[i]));
                    }
                }
            });
        }

        $("#level1").change(function(e) {
           var val = $(this).val();
           if (val.length == 1) {
               setChainCategory('#level2', val[0]);
           } else {
               e.preventDefault();
           }
        });

        $("#level2").change(function(e) {
            var val = $(this).val();
            if (val.length == 1) {
                setChainCategory('#level3', val[0]);
            } else {
                e.preventDefault();
            }
        });

        function reindexProduct(formEl) {
            formEl.find('.product-variant-item').each(function(index) {
                $(this).attr('data-index', ++index);
            });
        }

        /*var optbranchs = getList();
        getList().then(function(value){
            optbranchs += value;
        });*/

        var optbranchs, optvalues; //initial on first
        var dropzones = [];
        async function initial() {
            optbranchs = await getList();
            optvalues = await getOptionValue();
            var i = 1;
            $('.add-attribute').on('click',function(){

                var radioValue = $("input[name='ShippingOption[]']:checked").val();
                $("input[name='ShippingOption[]']").attr('disabled', true);
                $("input[name='options[]']").attr('disabled', true);



                var formTemplate = '';



                $('.option:checked').each(function(){
                    var values = $(this).val();
                    var text = $(this).data('text');
                    if(text == ''){
                        return false;
                    }
                    var opt = '<option value="">-- Pilih '+text+' --</option>';
                    $.each(optvalues[text], function(k,v){
                        opt += '<option value="'+v.id+'">'+v.name+'</option>';
                    })
                    formTemplate += '<div class="form-group m-form__group row">\n' +
                        '<label class="col-xl-4 col-form-label">'+text+'</label>\n' +
                        '<div class="col-xl-6">\n' +
                        '<select name="ProductOptionValueLists['+i+']['+values+']" class="form-control select2 m-input select-'+text.toLowerCase()+'" id="ProductOptionValues'+i+''+text+'">'+opt+'</select>\n' +
                        '</div>\n' +
                        '<div class="col-xl-2">\n' +
                        '<a href="#" class="btn btn-info m-btn m-btn--icon m-btn--icon-only add-variant" style="width:40px; height: 40px;"  data-toggle="modal" data-target="#modal-attribute" data-variant="'+text.toLowerCase()+'"><i class="la la-plus"></i></a>\n' +
                        '</div>\n' +
                        '</div>';
                });


                var template = '<div class="m-accordion__item product-variant-item item-'+i+'">\n' +
                    '<div class="m-accordion__item-head" role="tab" id="m_accordion_2_item_'+i+'_head" data-toggle="collapse" href="#m_accordion_2_item_'+i+'_body" aria-expanded="    false">\n' +
                    '<span class="m-accordion__item-title">Varian Produk <a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove-row" data-item='+i+'><i class="la la-trash"></i></a></span>\n' +
                    '<span class="m-accordion__item-mode"></span>\n' +
                    '</div>\n' +
                    '<div class="m-accordion__item-body collapse show" id="m_accordion_2_item_'+i+'_body" class=" " role="tabpanel" aria-labelledby="m_accordion_2_item_'+i+'_head" data-parent="#m_accordion_2">\n' +
                    '<div class="m-accordion__item-content"> \n' +
                    '<div class="row">\n' +
                    '<div class="col-xl-4">'+formTemplate+'</div>\n' +
                    '<div class="col-xl-8"> \n' +
                    '<div class="form-group m-form__group row">\n' +
                    '<label class="col-xl-4 col-form-label">Gambar Produk</label>\n' +
                    '<div class="col-xl-8"> \n' +
                    '<div class="m-dropzone dropzone m-dropzone--primary" action="#" id="m-dropzone'+i+'">\n' +
                    '<div class="m-dropzone__msg dz-message needsclick">\n' +
                    '<h3 class="m-dropzone__msg-title">Drop files disini atau click untuk upload.</h3>\n' +
                    '<span class="m-dropzone__msg-desc">Upload sampai 10 file</span>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div> \n' +
                    '</div>  \n' +
                    '<div class="form-group m-form__group row">\n' +
                    '<label class="col-xl-4 col-form-label">Harga Tambahan</label>\n' +
                    '<div class="col-xl-4"><input type="number" name="ProductOptionPrices['+i+'][price]" class="form-control m-input" placeholder="Harga"></div> \n' +
                    '</div>  \n' +
                    '<div class="m-form__group form-group row berat" style="display:none;">\n' +
                    '<label class="col-xl-4 col-form-label">Berat</label>\n' +
                    '<div class="col-xl-2"> \n' +
                    '<input type="number" name="ProductOptionStocks['+i+'][weight]" class="form-control m-input" placeholder="Berat (gram)">\n' +
                    '</div> \n' +
                    '</div>\n' +
                    '<div class="m-form__group form-group row dimensi" style="display:none;">\n' +
                    '<label class="col-xl-4 col-form-label">Dimensi</label>\n' +
                    '<div class="col-xl-2"><input type="number" name="ProductOptionStocks['+i+'][length]" class="form-control m-input" placeholder="Panjang"></div>\n' +
                    '<div class="col-xl-2"><input type="number" name="ProductOptionStocks['+i+'][width]"  class="form-control m-input" placeholder="Lebar"></div>\n' +
                    '<div class="col-xl-2"><input type="number" name="ProductOptionStocks['+i+'][heigth]" class="form-control m-input" placeholder="Tinggi"></div>\n' +
                    '</div>  \n' +
                    '<div class="m-form__group form-group row">\n' +
                    '<label class="col-xl-4 col-form-label">Stock Cabang</label>\n' +
                    '<div class="col-xl-2">\n' +
                    '<select name="ProductOptionStocks['+i+'][branches][0][branch_id]" class="form-control select2  m-input " >'+optbranchs+'</select>\n' +
                    '</div> \n' +
                    '<div class="col-xl-2">\n' +
                    '<input type="number" name="ProductOptionStocks['+i+'][branches][0][stock]"  class="form-control m-input" placeholder="Stok">\n' +
                    '</div>\n' +
                    '<div class="col-xl-2">\n' +
                    '<a href="javascript:void(0);" style="width:40px; height: 40px;" class="btn btn-info m-btn m-btn--icon m-btn--icon-only add-cabang" data-item='+i+'><i class="la la-plus"></i></a>\n' +
                    '</div> \n' +
                    '</div>  \n' +
                    '<div class="multi-cabang-'+i+'">\n' +
                    '</div>  \n' +
                    '</div> \n' +
                    '</div> \n' +
                    '</div> \n' +
                    '</div>\n' +
                    '</div> ';

                if(formTemplate != ''){
                    var appendTemplate = $('.form-dynamic').append(template);
                    //after append reindex product variant options

                    reindexProduct(formEl);

                    if(radioValue == 'Berat'){
                        appendTemplate.find('.berat').show();
                    }else{
                        appendTemplate.find('.dimensi').show();
                    }

                    $('.remove-row').off('click').on('click',function() {
                        var item = $(this).data('item');
                        $('div').remove('.item-'+item);
                        var total = $('.m-accordion__item').length;
                        if (total == 0) {
                            $("input[name='ShippingOption[]']").attr('disabled', false);
                            $("input[name='options[]']").attr('disabled', false);
                        }

                        reindexProduct(formEl);
                        //remove dropzone index
                        for(var z in dropzones) {
                            if (dropzones[z].index == item) {
                                dropzones.splice(z, 1);
                            }
                        }
                        console.log(dropzones);

                    });
                    $('.add-variant').off('click').on('click',function() {
                        var variant = $(this).data('variant');
                        $('.title-variant').html(variant);
                        $('#code-attribute').val(variant);
                    });
                    var y = 1;
                    $('.add-cabang').off('click').on('click',function() {
                        var item = $(this).data('item');
                        var rowcabang = '<div class="m-form__group form-group row cabang-'+item+'-'+y+'">\n' +
                            '<label class="col-xl-4 col-form-label"></label>\n' +
                            '<div class="col-xl-2">\n' +
                            '<select name="ProductOptionStocks['+item+'][branches]['+y+'][branch_id]" class="form-control select2  m-input " >'+optbranchs+'</select>\t\n' +
                            '</div> \n' +
                            '<div class="col-xl-2">\n' +
                            '<input type="number" name="ProductOptionStocks['+item+'][branches]['+y+'][stock]"  class="form-control m-input" placeholder="Stok">\n' +
                            '</div>\n' +
                            '<div class="col-xl-2">\n' +
                            '<a href="javascript:void(0);" style="width:40px; height: 40px;" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove-cabang" data-item="'+item+'" data-row="'+y+'"><i class="la la-minus"></i></a>\n' +
                            '</div> \n' +
                            '<div>';

                        $('.multi-cabang-'+item).append(rowcabang);

                        $('.remove-cabang').off('click').on('click',function() {
                            var items = $(this).data('item');
                            var row = $(this).data('row');
                            $('div').remove('.cabang-'+items+'-'+row);
                        });
                        $('.select2').select2();
                        y++;
                    });

                    $('.select2').select2();

                    //process dropzone m-dropzone dropzone
                    var dropzone = new Dropzone("#m-dropzone" + i, {
                        url: "<?= $this->Url->build(['action' => 'upload']); ?>",
                        maxFiles: 10,
                        maxFilesize: 10, // MB
                        addRemoveLinks: true,
                        acceptedFiles: "image/*",
                        paramName: "name",
                        //autoProcessQueue: false,
                        //autoQueue: false,
                        thumbnail: function(file, dataUrl) {
                            if (file.previewElement) {
                                //$(file.previewElement.querySelectorAll('div.dz-progress')).hide()
                                file.previewElement.classList.remove("dz-file-preview");
                                for (let thumbnailElement of file.previewElement.querySelectorAll("[data-dz-thumbnail]")) {
                                    thumbnailElement.alt = file.name;
                                    thumbnailElement.src = dataUrl;
                                }

                                return setTimeout((() => file.previewElement.classList.add("dz-image-preview")), 1);
                            }

                        },
                        success: function(file, response) {
                            //console.log(file, response)
                        },
                        maxfilesexceeded: function(file) {
                            this.removeFile(file);
                        },
                        sending: function(file, xhr, formData) {
                            formData.append('_csrfToken', $('input[name=_csrfToken]').val());
                            formData.append('product_id', $('input[name=id]').val());
                            formData.append('idx', $(file.previewElement).parents('.product-variant-item').attr('data-index'));

                        }
                    });

                    dropzones.push({index: i, dropzone: dropzone});

                }




                i++;
            })
        }

        initial();




        var frm = $('#form-attribute');
        frm.submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                   if(data.is_error){
                       return false;
                   }

                   var code = $('#code-attribute').val();
                    $(".select-"+code).append('<option value="'+data.data.id+'">'+data.data.name+'</option>');
                    $('.select-'+code).trigger('change');
                    //update data optvalues
                    getOptionValue().then(function(data) {
                        optvalues = data;
                    });

                    $('#form-attribute').trigger('reset');
                    $('#modal-attribute').modal('toggle');

                },
            });
        });

        function getList(){
            return new Promise((resolve, reject) => {
                var optbranch = '<option value="">-- Pilih Cabang --</option>';
                $.ajax({
                    url: "<?= $this->Url->build(['action' => 'getListBranch']); ?>",
                    cache: false,
                    method: 'GET',
                    success: function (responseBranchs) {
                        $.each(responseBranchs, function(k,v){
                            optbranch += '<option value="'+k+'">'+v+'</option>';
                        });
                        resolve(optbranch);
                    },
                    always: function() {
                        resolve(optbranch);
                    }
                })
            });

        }

        function getOptionValue() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "<?= $this->Url->build(['action' => 'getoptionvalues']); ?>",
                    cache: false,
                    method: 'GET',
                    success: function (response) {
                        resolve(response);
                    }
                });
            });
        }
    })
</script>
<script>
    $('select.select-picker').selectpicker();
</script>


<?php $this->end(); ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __d('AdminPanel', 'Product') ?>
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
                                <?= __d('AdminPanel', 'Produk') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __d('AdminPanel', 'Daftar Produk') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __d('AdminPanel', 'Tambah Produk') ?>
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
                            <?= __d('AdminPanel', 'Tambah Produk') ?>
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
                <!--begin: Form Wizard-->
                <div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">
                    <!--begin: Message container -->
                    <div class="m-portlet__padding-x">
                        <!-- Here you can put a message or alert -->
                        <?php  echo $this->Flash->render(); ?>
                    </div>
                    <!--end: Message container -->
                    <!--begin: Form Wizard Head -->
                    <div class="m-wizard__head m-portlet__padding-x">
                        <!--begin: Form Wizard Progress -->
                        <div class="m-wizard__progress">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end: Form Wizard Progress -->
                        <!--begin: Form Wizard Nav -->
                        <div class="m-wizard__nav">
                            <div class="m-wizard__steps">
                                <div class="m-wizard__step m-wizard__step--current"  m-wizard-target="m_wizard_form_step_1">
                                    <a href="#"  class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-placeholder"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            1. <?= __d('AdminPanel', 'Pilih Kategori'); ?>
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa flaticon-menu-2"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            2. <?= __d('AdminPanel', 'Input Data'); ?>
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                                    <a href="#" class="m-wizard__step-number">
                                        <span><i class="fa  flaticon-layers"></i></span>
                                    </a>
                                    <div class="m-wizard__step-info">
                                        <div class="m-wizard__step-title">
                                            3. <?= __d('AdminPanel', 'Selesai'); ?>
                                        </div>
                                        <div class="m-wizard__step-desc">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Nav -->
                    </div>
                    <!--end: Form Wizard Head -->
                    <!--begin: Form Wizard Form-->
                    <div class="m-wizard__form">
                        <!--
                            1) Use m-form--label-align-left class to alight the form input lables to the right
                            2) Use m-form--state class to highlight input control borders on form validation
                            -->
                        <?=
                        $this->Form->create($product,['class' => 'm-form m-form--label-align-left- m-form--state-', 'id' =>'m_form']);
                        $default_class = 'form-control m-input';
                        ?>
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">
                                <!--begin: Form Wizard Step 1-->
                                <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4 col-md-9 col-sm-12">
                                                    <?= $this->Form->select('parent', $parent_categories, ['id' => 'level1', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                                </div>

                                                <div class="col-lg-4 col-md-9 col-sm-12">
                                                    <?= $this->Form->select('level2', [], ['id' => 'level2', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                                </div>

                                                <div class="col-lg-4 col-md-9 col-sm-12">
                                                    <?= $this->Form->select('product_category_id', [], ['id' => 'level3', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 1-->
                                <!--begin: Form Wizard Step 2-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="m-form__section">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">
                                                        <?= __d('AdminPanel',  'SEO Produk'); ?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel', 'Kata Kunci Pencarian'); ?></label>
                                                <div class="col-xl-9">
                                                    <?php echo $this->Form->control('ProductMetaTags.keyword',['type' => 'textarea','label' => false,'class' => $default_class, 'rows' => 4]);?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Deskripsi SEO'); ?></label>
                                                <div class="col-xl-9">
                                                    <?php echo $this->Form->control('ProductMetaTags.description',['type' => 'textarea','label' => false,'class' => $default_class, 'rows' => 4]);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-xl-12">
                                            <div class="m-form__section">
                                                <div class="m-form__heading">
                                                    <h3 class="m-form__heading-title">
                                                        <?= __d('AdminPanel',  'Informasi Produk'); ?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel', 'Nama Produk'); ?></label>
                                                <div class="col-xl-9">
                                                    <?php echo $this->Form->control('name',['label' => false,'class' => $default_class]);?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Slug URL'); ?></label>
                                                <div class="col-xl-9">
                                                    <?php echo $this->Form->control('slug',['label' => false,'class' => $default_class,'readonly' => 'readonly']);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mt-3">
                                        <div class="col-xl-6">

                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Highlight Produk'); ?></label>
                                                <div class="col-xl-9">
                                                    <?php echo $this->Form->control('highlight',['label' => false,'class' => $default_class, 'rows' => 4]);?>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Kondisi Produk'); ?></label>
                                                <div class="col-xl-9">
                                                    <?php echo $this->Form->control('condition',['label' => false,'class' => $default_class, 'rows' => 4]);?>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Profil Produk'); ?></label>
                                                <div class="col-xl-9">
                                                    <?php echo $this->Form->control('profile',['label' => false,'class' => $default_class, 'rows' => 4]);?>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel', 'Model'); ?></label>
                                                <div class="col-xl-4">
                                                    <?php echo $this->Form->control('model',['label' => false,'class' => $default_class]);?>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel', 'Sku'); ?></label>
                                                <div class="col-xl-4">
                                                    <?php echo $this->Form->control('sku',['label' => false,'class' => $default_class]);?>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Status Stok'); ?></label>
                                                <div class="col-xl-4">
                                                    <?php echo $this->Form->control('product_stock_status_id', ['options' => $productStockStatuses,'label' => false, 'class' => $default_class . ' select-picker']);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-xl-6">
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Harga Reguler'); ?></label>
                                                <div class="col-xl-5">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><?= __d('AdminPanel',  'IDR'); ?></span></div>
                                                        <?php echo $this->Form->control('price',['div' => false, 'label' => false,'class' => $default_class]);?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Harga Jual'); ?></label>
                                                <div class="col-xl-5">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><?= __d('AdminPanel',  'IDR'); ?></span></div>
                                                        <?php echo $this->Form->control('price_sale', ['div' => false, 'label' => false,'class' => $default_class, 'type' => 'number']);?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Diskon'); ?></label>
                                                <div class="col-xl-5">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text">%</span></div>
                                                        <?php echo $this->Form->control('price_discount', ['div' => false, 'label' => false, 'class' => $default_class, 'readonly' => true]);?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Reward Point'); ?></label>
                                                <div class="col-xl-5">
                                                    <?php echo $this->Form->control('point',['div' => false, 'label' => false,'class' => $default_class]);?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-xl-12">
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-2 col-form-label"><?= __d('AdminPanel',  'Kurir'); ?></label>
                                                <div class="col-xl-10 m-form__group-sub">
                                                    <div class="m-checkbox-inline">
                                                        <?php foreach($courriers as $k => $vals):?>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="ProductToCourriers[]" value="<?php echo $k;?>"> <?php echo $vals;?>
                                                            <span></span>
                                                        </label>
                                                        <?php endforeach;?>
                                                    </div>
                                                    <span class="m-form__help"><?= __d('AdminPanel',  'Pilihan Kurir'); ?></span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-2 col-form-label">Opsi Pengiriman Berdasarkan?</label>
                                                <div class="col-xl-10 m-form__group-sub">
                                                    <div class="m-radio-inline">
                                                        <label class="m-radio">
                                                            <input type="radio" name="ShippingOption[]" value="Berat" checked="checked"> Berat
                                                            <span></span>
                                                        </label>
                                                        <label class="m-radio">
                                                            <input type="radio" name="ShippingOption[]" value="Dimensi"> Dimensi
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-xl-2 col-form-label"><?= __d('AdminPanel',  'Atribut'); ?></label>
                                                <div class="col-xl-6 m-form__group-sub">
                                                    <div class="m-checkbox-inline">
                                                        <?php foreach($options as $k => $vals):?>
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                                            <input type="checkbox" name="options[]"  value="<?php echo $k;?>" class="option" data-text="<?php echo $vals;?>"> <?php echo $vals;?>
                                                            <span></span>
                                                        </label>
                                                        <?php endforeach;?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2">
                                                    <a href="javascript:void(0);" class="btn btn-success m-btn m-btn--custom m-btn--icon add-attribute"><span>Tambah Varian Produk</span></a>
                                                </div>
                                            </div>



                                            <div class="m-accordion m-accordion--bordered form-dynamic" id="m_accordion_2" role="tablist">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--end: Form Wizard Step 2-->


                                <!--begin: Form Wizard Step 3-->
                                <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            review
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 5-->


                            </div>
                            <!--end: Form Body -->
                            <!--begin: Form Actions -->
                            <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-5 m--align-left">
                                            <a href="javascript:void(0)" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                                <span>
                                <i class="la la-arrow-left"></i>&nbsp;&nbsp;
                                <span><?= __d('AdminPanel',  'Back'); ?></span>
                                </span>
                                            </a>
                                        </div>
                                        <div class="col-lg-5 m--align-right">
                                            <a href="javascript:void(0)" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
                                <span>
                                <i class="la la-check"></i>&nbsp;&nbsp;
                                <span><?= __d('AdminPanel',  'Submit'); ?></span>
                                </span>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next2">
                                <span>
                                <span><?= __d('AdminPanel',  'Continue'); ?></span>&nbsp;&nbsp;
                                <i class="la la-arrow-right"></i>
                                </span>
                                            </a>
                                        </div>
                                        <div class="col-lg-1"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end: Form Actions -->
                        <?= $this->Form->end(); ?>
                    </div>
                    <!--end: Form Wizard Form-->
                </div>
                <!--end: Form Wizard-->
            </div>



        </div>
    </div>
</div>



<div class="modal fade" id="modal-attribute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Atribut <span class="title-variant"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= $this->Form->create(null,['url' => ['action' => 'addOptions'],'class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form', 'id' => 'form-attribute']); ?>
            <div class="modal-body">
                <?php echo $this->Form->hidden('code_attribute', ['div' => false, 'label' => false, 'id' => 'code-attribute']);?>
                <div class="form-group m-form__group row">
                    <label class="col-xl-4 col-form-label"><?= __d('AdminPanel',  'Nama Atribut'); ?></label>
                    <div class="col-xl-8">
                        <?php echo $this->Form->control('name', ['div' => false, 'label' => false, 'class' => $default_class]);?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <?= $this->Form->submit(__('Simpan Atribut'),['class' => 'btn btn-brand']) ?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

