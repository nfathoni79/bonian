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
    '/admin-assets/app/js/lodash.min',
    '/admin-assets/vendors/custom/slugify/speakingurl.min',
    '/admin-assets/vendors/custom/slugify/slugify.min',
    '/admin-assets/vendors/custom/libs/validation-render',
]);
?>
<script>
    Dropzone.autoDiscover = false;

    function dropZoneRemoveFile(file) {
        if(confirm('Apakah anda yakin ingin menghapus gambar ini?')) {
            for (let thumbnailElement of file.previewElement.querySelectorAll("[data-dz-thumbnail]")) {
                $.ajax({
                    type: 'POST',
                    url: '<?= $this->Url->build(['action' => 'add']); ?>',
                    data: {action: "removeImage", image_id: $(thumbnailElement).attr('data-image-id'), _csrfToken : $('input[name=_csrfToken]').val()},
                    success: function (data) {
                        $(thumbnailElement).parents('.dz-preview').remove();
                    }
                });
            }
        }

    }

    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150
        });
        $('#slug').slugify('#name'); // Type as you slug

        var formEl = $("#m_form");


        var url_category = '<?= $this->Url->build(['action' => 'getCategory']); ?>';
        var url_attribute = '<?= $this->Url->build(['action' => 'getAttributeAndBrand']); ?>';
        var product;
        var sku_variant = {};


        var ajaxRequest = new ajaxValidation(formEl);
        ajaxRequest.setblockUI('#m_wizard');
        formEl.submit(function(e) {
            e.preventDefault();
            ajaxRequest.post(formEl.attr('action'), formEl.find(':input'), function(data, saved) {
                if (data.success) {
                    console.log(data, saved);
                    location.href = '<?= $this->Url->build(['action' => 'index']); ?>';
                }
            });
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

        $("#price-sale, #price").change(function() {
            var percent = 100;

            var reg_price = parseFloat($('#price').val().replace(/,/g, ''));
            var sale_price = parseFloat($('#price-sale').val().replace(/,/g, ''));
            percent = percent - ((sale_price / reg_price) * 100);
            if(isNaN(percent)) {
                percent = 0;
            }
            $('#price-discount').val(percent.toFixed(2)+' %');

        })

        $("#level3").change(function(e) {
            var val = $(this).val();
            $('#code-cat').val(val);
            $.ajax({
                type: 'POST',
                url: url_attribute,
                data: {categories: val, _csrfToken : $('input[name=_csrfToken]').val()},
                success: function (data) {
                    var attrForm = '';
                    $.each(data.attribute,function(k, v){
                        attrForm += '<div class="form-group m-form__group row">\n' +
                            '<label class="col-xl-2 col-form-label">'+v.name+'</label>\n' +
                            '<div class="col-xl-10 m-form__group-sub">\n' +
                            '<div class="m-checkbox-inline">';

                        $.each(v.children, function (ky, vl) {
                            attrForm += '<label class="m-checkbox m-checkbox--solid m-checkbox--brand">\n' +
                                '<input type="checkbox" name="ProductToAttributes['+k+'][]" value="'+vl.id+'"> '+vl.name+'\n' +
                                '<span></span>\n' +
                                '</label>';
                        })

                        attrForm += '</div>\n' +
                            '</div>\n' +
                            '</div>';
                    });

                    $('.dynamic-form-attribute').html(attrForm);

                    var attrBrand = '<option value="">-- Pilih Brand --</option>';
                    $.each(data.brand, function(k,v){
                        attrBrand += '<option value="'+k+'">'+v+'</option>';
                    })
                    $('#brand-id').html(attrBrand);
                    $('#brand-id').select2();
                }
            });
        });

        function replace_number_format(index, value) {
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
        }

        function onkeyup(event) {
            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(replace_number_format);
        }

        $('input.numberinput').keyup(onkeyup);
        $('input.numberinput').each(function(){
            $(this).val(replace_number_format);
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

        function rowCabangTemplate(y, item) {
            var rowcabang = '<div class="m-form__group form-group row cabang cabang-'+item+'-'+y+'">\n' +
                '<label class="col-xl-4 col-form-label"></label>\n' +
                '<div class="col-xl-3">\n' +
                '<select name="ProductOptionStocks['+item+'][branches]['+y+'][branch_id]" class="form-control select2  m-input " >'+optbranchs+'</select>\t\n' +
                '</div> \n' +
                '<div class="col-xl-3">\n' +
                '<input type="number" name="ProductOptionStocks['+item+'][branches]['+y+'][stock]"  class="form-control m-input" placeholder="Stok">\n' +
                '</div>\n' +
                '<div class="col-xl-1">\n' +
                '<a href="javascript:void(0);" style="width:40px; height: 40px;" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove-cabang" data-item="'+item+'" data-row="'+y+'"><i class="la la-minus"></i></a>\n' +
                '</div> \n' +
                '<div>';
            $('.multi-cabang-'+item).append(rowcabang);
        }


        async function initial() {
            optbranchs = await getList();
            optvalues = await getOptionValue();
            var i = <?= count($get_product_option_prices) + 1; ?>;

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
                        '<label class="col-xl-4 col-form-label">'+text+'  *</label>\n' +
                        '<div class="col-xl-6">\n' +
                        '<select name="ProductOptionValueLists['+i+']['+values+']" class="form-control select2 m-input sku-prefix select-'+text.toLowerCase()+'" id="ProductOptionValues'+i+''+text+'">'+opt+'</select>\n' +
                        '</div>\n' +
                        '<div class="col-xl-2">\n' +
                        '<a href="#" class="btn btn-info m-btn m-btn--icon m-btn--icon-only add-variant" style="width:40px; height: 40px;"  data-toggle="modal" data-target="#modal-attribute" data-variant="'+text.toLowerCase()+'"><i class="la la-plus"></i></a>\n' +
                        '</div>\n' +
                        '</div>';
                });


                var template = '<div class="m-accordion__item product-variant-item item-'+i+'">\n' +
                    '<div class="m-accordion__item-head" role="tab" id="m_accordion_2_item_'+i+'_head" data-toggle="collapse" href="#m_accordion_2_item_'+i+'_body" aria-expanded="    false">\n' +
                    '<span class="m-accordion__item-title">Varian Produk <a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove-row" data-item='+i+'>  <i class="la la-trash"></i></a> </span>\n' +
                    '<span class="m-accordion__item-mode"></span>\n' +
                    '</div>\n' +
                    '<div class="m-accordion__item-body collapse show" id="m_accordion_2_item_'+i+'_body" class=" " role="tabpanel" aria-labelledby="m_accordion_2_item_'+i+'_head" data-parent="#m_accordion_2">\n' +
                    '<div class="m-accordion__item-content"> \n' +
                    '<div class="row">\n' +
                    '<div class="col-xl-4">'+formTemplate+'</div>\n' +
                    '<div class="col-xl-4"> \n' +
                    '<div class="form-group m-form__group row">\n' +
                    '<label class="col-xl-4 col-form-label">Expired</label>\n' +
                    '<div class="col-xl-4"><input type="text" name="ProductOptionPrices['+i+'][expired]" class="form-control m-input datepicker" placeholder="Expired"></div> \n' +
                    '</div>  \n' +
                    '<div class="form-group m-form__group row">\n' +
                    '<label class="col-xl-4 col-form-label">SKU *</label>\n' +
                    '<div class="col-xl-6"><input type="text" name="ProductOptionPrices['+i+'][sku]" class="form-control m-input sku-number" placeholder="Sku" readonly="readonly"></div> \n' +
                    '</div>  \n' +
                    '<div class="form-group m-form__group row">\n' +
                    '<label class="col-xl-4 col-form-label">Harga Tambahan  *</label>\n' +
                    '<div class="col-xl-4"><input type="number" name="ProductOptionPrices['+i+'][price]" class="form-control m-input" placeholder="Harga"></div> \n' +
                    '</div>  \n' +
                    '<div class="m-form__group form-group row berat" style="display:none;">\n' +
                    '<label class="col-xl-4 col-form-label">Berat  *</label>\n' +
                    '<div class="col-xl-3"> \n' +
                    '<input type="number" name="ProductOptionStocks['+i+'][weight]" class="form-control m-input" placeholder="Berat (gram)">\n' +
                    '</div> \n' +
                    '</div>\n' +
                    '<div class="m-form__group form-group row dimensi" style="display:none;">\n' +
                    '<label class="col-xl-4 col-form-label">Dimensi  *</label>\n' +
                    '<div class="col-xl-2"><input type="number" name="ProductOptionStocks['+i+'][length]" class="form-control m-input" placeholder="Panjang"></div>\n' +
                    '<div class="col-xl-2"><input type="number" name="ProductOptionStocks['+i+'][width]"  class="form-control m-input" placeholder="Lebar"></div>\n' +
                    '<div class="col-xl-2"><input type="number" name="ProductOptionStocks['+i+'][height]" class="form-control m-input" placeholder="Tinggi"></div>\n' +
                    '</div>  \n' +
                    '<div class="m-form__group form-group row">\n' +
                    '<label class="col-xl-4 col-form-label">Stock Cabang  *</label>\n' +
                    '<div class="col-xl-3">\n' +
                    '<select name="ProductOptionStocks['+i+'][branches][0][branch_id]" class="form-control select2  m-input " >'+optbranchs+'</select>\n' +
                    '</div> \n' +
                    '<div class="col-xl-3">\n' +
                    '<input type="number" name="ProductOptionStocks['+i+'][branches][0][stock]"  class="form-control m-input" placeholder="Stok">\n' +
                    '</div>\n' +
                    '<div class="col-xl-1">\n' +
                    '<a href="javascript:void(0);" style="width:40px; height: 40px;" class="btn btn-info m-btn m-btn--icon m-btn--icon-only add-cabang" data-item='+i+'><i class="la la-plus"></i></a>\n' +
                    '</div> \n' +
                    '</div>  \n' +
                    '<div class="multi-cabang-'+i+'">\n' +
                    '</div>  \n' +
                    '</div>\n' +
                    '<div class="col-xl-4"> \n' +
                    '<div class="form-group m-form__group row">\n' +
                    '<div class="col-xl-12"> \n' +
                    '<div class="m-dropzone dropzone m-dropzone--primary" action="#" id="m-dropzone'+i+'" style="min-height:100px !important;">\n' +
                    '<div class="m-dropzone__msg dz-message needsclick">\n' +
                    '<h3 class="m-dropzone__msg-title">Drop files disini atau click untuk upload.</h3>\n' +
                    '<span class="m-dropzone__msg-desc">Upload sampai 10 file</span>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div> \n' +
                    '</div>  \n' +
                    '</div> \n' +
                    '</div> \n' +
                    '</div> \n' +
                    '</div>\n' +
                    '</div> ';

                if(formTemplate != ''){
                    var appendTemplate = $('.form-dynamic').append(template);
                    //after append reindex product variant options

                    appendTemplate.find('.sku-prefix').each(function(index) {
                        $(this).change(function(){
                            var parentIndex = $(this).parents('.product-variant-item').attr('data-index');
                            _.set(sku_variant, `${parentIndex}.${index}`, $(this).val());
                            $(this)
                                .parents('.product-variant-item')
                                .find('.sku-number')
                                .val($("#sku").val() + Number(_.get(sku_variant, `${parentIndex}`).join('')).toString(16).toUpperCase());
                        });
                    });

                    var arrows;
                    if (mUtil.isRTL()) {
                        arrows = {
                            leftArrow: '<i class="la la-angle-right"></i>',
                            rightArrow: '<i class="la la-angle-left"></i>'
                        }
                    } else {
                        arrows = {
                            leftArrow: '<i class="la la-angle-left"></i>',
                            rightArrow: '<i class="la la-angle-right"></i>'
                        }
                    }
                    $('.datepicker').datepicker({
                        startDate: '-0d',
                        rtl: mUtil.isRTL(),
                        todayHighlight: true,
                        orientation: "bottom left",
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        templates: arrows
                    });

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
                        rowCabangTemplate(y, item);

                        $('.remove-cabang').off('click').on('click',function() {
                            var items = $(this).data('item');
                            var row = $(this).data('row');
                            $('div').remove('.cabang-'+items+'-'+row);
                        });
                        $('.select2').select2();
                        y++;
                    });

                    appendTemplate.find('.select2').select2();

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
                            for (let thumbnailElement of file.previewElement.querySelectorAll("[data-dz-thumbnail]")) {
                                $(thumbnailElement).attr('data-image-id', response.data.image_id)
                                    .attr('data-image-name', response.data.name);
                            }
                        },
                        maxfilesexceeded: function(file) {
                            this.removeFile(file);
                        },
                        removedfile: dropZoneRemoveFile,
                        sending: function(file, xhr, formData) {
                            formData.append('_csrfToken', $('input[name=_csrfToken]').val());
                            formData.append('product_id', '<?= $product->get('id'); ?>');
                            formData.append('idx', $(file.previewElement).parents('.product-variant-item').attr('data-index'));

                        }
                    });

                    dropzones.push({index: i, dropzone: dropzone});

                }




                i++;
            })
        }

        initial();




        var frmAttr = $('#form-attribute');
        frmAttr.submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: frmAttr.attr('method'),
                url: frmAttr.attr('action'),
                data: frmAttr.serialize(),
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

        var frmBrand = $('#form-brand');
        frmBrand.submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: frmBrand.attr('method'),
                url: frmBrand.attr('action'),
                data: frmBrand.serialize(),
                success: function (data) {
                    if(data.is_error){
                        return false;
                    }

                    var code = $('#level3').val();
                    $("#brand-id").append('<option value="'+data.data.id+'">'+data.data.name+'</option>');
                    $('#form-brand').trigger('reset');
                    $('#modal-brand').modal('toggle');
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


        $('#product-tagging').select2({
            placeholder: "Tambah Tag Produk",
            tags: true
        }).on("change", function(e) {
            var isNew = $(this).find('[data-select2-tag="true"]');
            if(isNew.length && $.inArray(isNew.val(), $(this).val()) !== -1){
                //isNew.replaceWith('<option selected value="' + isNew.val() + '">' + isNew.val() + '</option>');
                console.log('New tag: ', isNew.val());
            }
        });

        $("#brand-id").change(function(){
            var brand_id = $(this).val();
            $.ajax({
                url: "<?= $this->Url->build(['action' => 'add']); ?>",
                cache: false,
                method: 'POST',
                data: {action: "getSku", brand_id: brand_id, product_id: "<?= $product->get('id'); ?>", _csrfToken: $('input[name=_csrfToken]').val()},
                success: function (response) {
                    if (typeof response.data != "undefined") {
                        let sku = $("#sku");
                        sku.val(response.data);
                        sku.trigger('change');
                    }
                }
            });
        });

        $("#sku").on('change', function(){
            var sku_number = $(this).val();
            for(var index in sku_variant) {
                $(`[data-index=${index}]`)
                    .find('.sku-number')
                    .val(sku_number + Number(sku_variant[index].join('')).toString(16).toUpperCase());
            }
        })

        $('#price-sale').trigger('change');
        //default for edit
        $('.select2.select-attribute').select2();
        var arrows;
        if (mUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }
        $('.datepicker').datepicker({
            startDate: '-0d',
            rtl: mUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            format: 'yyyy-mm-dd',
            autoclose: true,
            templates: arrows
        });

        new Dropzone("#m-dropzone-parent", {
            url: "<?= $this->Url->build(['action' => 'upload']); ?>",
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "image/*",
            paramName: "name",
            //autoProcessQueue: false,
            //autoQueue: false,
            init: function () {
                var thisDropzone = this;

                <?php if (array_key_exists(0, $product_images)) : ?>
                <?php foreach($product_images[0] as $k => $image) : ?>
                <?php
                $image_preview = [
                    'name' => $image->get('name'),
                    'size' => $image->get('size'),
                    'type' => $image->get('type'),
                    'image_id' => $image->get('id')
                ];
                ?>
                var previewImage = <?= json_encode($image_preview); ?>;
                thisDropzone.emit("addedfile", previewImage);
                thisDropzone.emit("success", previewImage, {data: previewImage});
                thisDropzone.emit("thumbnail", previewImage, "<?= $this->Url->build('/images/126x126/' . $image->get('name')); ?>")

                $(thisDropzone.previewsContainer).find('.dz-preview').addClass('dz-processing')
                    .addClass('dz-complete');
                <?php endforeach; ?>
                <?php endif; ?>

            },
            thumbnail: function (file, dataUrl) {
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
            success: function (file, response) {
                //console.log(file, response)
                for (let thumbnailElement of file.previewElement.querySelectorAll("[data-dz-thumbnail]")) {
                    $(thumbnailElement).attr('data-image-id', response.data.image_id)
                        .attr('data-image-name', response.data.name);
                }
            },
            maxfilesexceeded: function (file) {
                this.removeFile(file);
            },
            removedfile: dropZoneRemoveFile,
            sending: function (file, xhr, formData) {
                formData.append('_csrfToken', $('input[name=_csrfToken]').val());
                formData.append('product_id', '<?= $product->get('id'); ?>');
                formData.append('idx', '0');

            }
        });

        var count_cabang_y = 1;
        $('.add-cabang').on('click',function() {
            var item = $(this).data('item');
            count_cabang_y = $(this).parents('.m-accordion__item-body').find('.cabang').length + 1;
            rowCabangTemplate(count_cabang_y, item);

            $('.remove-cabang').off('click').on('click',function() {
                var items = $(this).data('item');
                var row = $(this).data('row');
                $('div').remove('.cabang-'+items+'-'+row);
            });
            $('.select2').select2();
            count_cabang_y++;
        });

        $('.remove-row').on('click', function() {
            var id_price = $(this).attr('data-option-price');
            if(id_price) {
                console.log(id_price);
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

                var elementDeletePrice = $('<input/>');
                elementDeletePrice.attr('name', 'OptionPriceToDelete[]')
                    .attr('value', id_price)
                    .attr('type', 'hidden');
                formEl.append(elementDeletePrice);

            }
        });



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
                                <?= __d('AdminPanel', 'Edit Produk') ?>
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
                            <?= __d('AdminPanel', 'Edit Produk') ?>
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

            <?= $this->Form->create($product,['class' => 'm-form m-form--label-align-left- m-form--state-', 'id' =>'m_form']);
            $default_class = 'form-control m-input';
            ?>
            <div class="m-portlet__body m-portlet__body--no-padding">
                <!--begin: Form Wizard-->

                <!--begin: Form Body -->
                <div class="m-portlet__body">

                    <div class="row">
                        <div class="col-sm-12">
                            <h6><?= __d('AdminPanel',  'Produk Kategori'); ?></h6>
                        </div>
                    </div>
                    <div class="m-form__seperator m-form__seperator--dashed"></div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group m-form__group row">
                                <?php /*<div class="col-lg-4 col-md-9 col-sm-12">
                                    <?= $this->Form->select('parent', $parent_categories, ['id' => 'level1', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                </div>

                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <?= $this->Form->select('level2', [], ['id' => 'level2', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                </div>

                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <?= $this->Form->select('product_category_id', [], ['id' => 'level3', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                </div>*/ ?>
                                <?php foreach($product_category_path as $key => $path) : ?>
                                    <span class="m-badge m-badge--metal m-badge--wide"><?= $path->get('name'); ?></span>
                                    <?php if ($key + 1 < count($product_category_path)) : ?>
                                        <span style="padding-left: 5px; padding-right: 5px;"> > </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h6><?= __d('AdminPanel',  'Informasi Produk'); ?></h6>
                        </div>
                    </div>
                    <div class="m-form__seperator m-form__seperator--dashed"></div>

                    <div class="row mt-3">
                        <div class="col-xl-6">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel', 'Nama Produk'); ?>*</label>
                                <div class="col-xl-9">
                                    <?php echo $this->Form->control('name',['label' => false,'class' => $default_class]);?>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel', 'Kata Kunci'); ?>*</label>
                                <div class="col-xl-9">
                                    <?php echo $this->Form->control('ProductMetaTags.keyword',['type' => 'textarea','value' => $meta_tags ? $meta_tags->get('keyword') : null, 'label' => false,'class' => $default_class, 'rows' => 1]);?>
                                    <span class="m-form__help">Penggunaan Kata kunci SEO wajib menggunakan "koma" contoh : kamera, kamera handphone, dll</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 offset-1">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Slug URL'); ?></label>
                                <div class="col-xl-9">
                                    <?php echo $this->Form->control('slug',['label' => false,'class' => $default_class,'readonly' => 'readonly']);?>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Deskripsi SEO'); ?></label>
                                <div class="col-xl-9">
                                    <?php echo $this->Form->control('ProductMetaTags.description',['type' => 'textarea', 'value' => $meta_tags ? $meta_tags->get('description') : null, 'label' => false,'class' => $default_class, 'rows' => 1]);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h6><?= __d('AdminPanel',  'Attribute Produk'); ?></h6>
                        </div>
                    </div>
                    <div class="m-form__seperator m-form__seperator--dashed"></div>
                    <div class="row mt-3">
                        <div class="col-xl-12 dynamic-form-attribute">
                            <?php /* $list_attributes */ ?>
                            <?php
                            /**
                             * @var \AdminPanel\Model\Entity\Attribute[] $list_attributes
                             */
                            foreach($list_attributes as $key => $val) : ?>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-2 col-form-label"><?= h($val->get('name')); ?></label>
                                <div class="col-xl-10 m-form__group-sub">
                                    <div class="m-checkbox-inline">
                                    <?php foreach($val->get('children') as $child) : ?>
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                            <?php echo $this->Form->checkbox("ProductToAttributes[$key][]", [
                                                'value' => $child->get('id'),
                                                'hiddenField' => false,
                                                'checked' => in_array($child->get('id'), $product_attribute_checked)
                                            ]); ?>
                                            <?= h($child->get('name')) ; ?>
                                            <span></span>
                                        </label>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>


                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h6><?= __d('AdminPanel',  'Informasi Detail'); ?></h6>
                        </div>
                    </div>
                    <div class="m-form__seperator m-form__seperator--dashed"></div>


                    <div class="row mt-3">
                        <div class="col-xl-4">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Brand'); ?>*</label>
                                <div class="col-xl-8">
                                    <?php echo $this->Form->control('brand_id', ['label' => false, 'empty' => 'Pilih Brand', 'class' => $default_class, 'disabled' => !empty($product->get('brand_id'))]);?>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel', 'Model'); ?>*</label>
                                <div class="col-xl-8">
                                    <?php echo $this->Form->control('model',['label' => false,'class' => $default_class]);?>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel', 'Sku'); ?>*</label>
                                <div class="col-xl-8">
                                    <?php echo $this->Form->control('sku',['label' => false,'class' => $default_class . ' disabled', 'readonly' => true]);?>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Status Stok'); ?></label>
                                <div class="col-xl-8">
                                    <?php echo $this->Form->control('product_stock_status_id', ['options' => $productStockStatuses,'label' => false, 'class' => $default_class . ' select-picker']);?>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Barcode'); ?></label>
                                <div class="col-xl-8">
                                    <?php echo $this->Form->control('barcode', ['type' => 'text','div' => false, 'label' => false,'class' => $default_class]);?>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-4">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-form-label"><?= __d('AdminPanel',  'Harga Reguler'); ?>*</label>
                                <div class="col-xl-4">
                                    <div class="input-group">
                                        <?php echo $this->Form->control('price',['type' => 'text','div' => false, 'label' => false,'class' => $default_class. ' numberinput']);?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-form-label"><?= __d('AdminPanel',  'Harga Jual'); ?>*</label>
                                <div class="col-xl-4">
                                    <div class="input-group">
                                        <?php echo $this->Form->control('price_sale', ['type' => 'text','div' => false, 'label' => false,'class' => $default_class. ' numberinput']);?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-form-label"><?= __d('AdminPanel',  'Diskon'); ?></label>
                                <div class="col-xl-3">
                                    <div class="input-group">
                                        <?php echo $this->Form->control('price_discount', ['div' => false, 'label' => false, 'class' => $default_class, 'disabled' => 'disabled']);?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-form-label"><?= __d('AdminPanel',  'Reward Point'); ?>*</label>
                                <div class="col-xl-6">
                                    <?php echo $this->Form->control('point',['type' => 'text', 'div' => false, 'label' => false,'class' => $default_class . ' numberinput']);?>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-xl-4 col-form-label"><?= __d('AdminPanel',  'Kode Supplier'); ?></label>
                                <div class="col-xl-6">
                                    <?php echo $this->Form->control('supplier_code', ['type' => 'text','div' => false, 'label' => false,'class' => $default_class]);?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Produk Tagging'); ?></label>
                                <div class="col-xl-9">
                                    <?php echo $this->Form->select('ProductTags', $product_tags, ['multiple' => true, 'value' => $product_tag_selected, 'class' => $default_class . ' m-select2', 'id' => 'product-tagging', 'style' => 'width: 100% !important;']); //['options' => $product_tags, 'default' => $product_tag_selected, 'label' => false, 'class' => $default_class . ' m-select2', 'id' => 'product-tagging', 'multiple' => true, 'style' => 'width: 100% !important;']);?>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Kurir'); ?>*</label>
                                <div class="col-xl-9 m-form__group-sub">
                                    <div class="m-checkbox-inline">
                                        <?php foreach($courriers as $k => $vals):?>
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                            <input type="checkbox" name="ProductToCourriers[]" value="<?php echo $k;?>" <?= in_array($k, $product_to_courriers) ? 'checked="checked"' : '';?> > <?php echo $vals;?>
                                            <span></span>
                                        </label>
                                        <?php endforeach;?>
                                    </div>
                                    <span class="m-form__help"><?= __d('AdminPanel',  'Pilihan Kurir'); ?></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Garansi'); ?></label>
                                <div class="col-xl-9">
                                    <?php echo $this->Form->control('product_warranty_id', ['options' => $product_warranties, 'label' => false, 'class' => $default_class . ' select-picker']);?>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Produk status'); ?></label>
                                <div class="col-xl-8">
                                    <?php echo $this->Form->control('product_status_id', ['options' => $productStatuses,'label' => false, 'class' => $default_class . ' select-picker']);?>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h6><?= __d('AdminPanel',  'Deskripsi Produk'); ?></h6>
                        </div>
                    </div>
                    <div class="m-form__seperator m-form__seperator--dashed"></div>
                    <div class="row mt-3">
                        <div class="col-xl-6">
                            <div class="form-group m-form__group">
                                <label class="col-form-label"><?= __d('AdminPanel',  'Highlight Produk'); ?></label>
                                <?php echo $this->Form->control('highlight',['label' => false,'class' => $default_class. ' summernote', 'rows' => 1, 'placeholder' => 'Highlight Produk']);?>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="form-group m-form__group">
                                <label class="col-form-label"><?= __d('AdminPanel',  'Profil Produk'); ?></label>
                                <?php echo $this->Form->control('profile',['label' => false,'class' => $default_class. ' summernote', 'rows' => 1]);?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <h6><?= __d('AdminPanel',  'Gambar Produk'); ?></h6>
                            <div class="m-form__seperator m-form__seperator--dashed"></div>
                            <div class="form-group m-form__group">
                                <div class="form-group m-form__group">
                                    <div class="m-dropzone dropzone m-dropzone--primary" action="#" id="m-dropzone-parent" style="min-height:190px !important;">
                                        <div class="m-dropzone__msg dz-message needsclick">
                                            <h3 class="m-dropzone__msg-title">Drop files disini atau click untuk upload.</h3>
                                            <span class="m-dropzone__msg-desc">Upload sampai 10 file</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h6><?= __d('AdminPanel',  'Varian Produk'); ?></h6>
                        </div>
                    </div>
                    <div class="m-form__seperator m-form__seperator--dashed"></div>

                    <div class="row mt-3">
                        <div class="col-xl-4">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-6 col-form-label">Opsi Pengiriman Berdasarkan?</label>
                                <div class="col-xl-6 m-form__group-sub">
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

                        </div>
                        <div class="col-xl-4">
                            <div class="form-group m-form__group row">
                                <label class="col-xl-3 col-form-label"><?= __d('AdminPanel',  'Combo Varian'); ?></label>
                                <div class="col-xl-9 m-form__group-sub">
                                    <div class="m-checkbox-inline">
                                        <?php foreach($options as $k => $vals):?>
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                            <input type="checkbox" name="options[]"  value="<?php echo $k;?>" <?php echo count($list_options) > 0 ? 'disabled="disabled"' : ''; ?> <?php echo in_array($k, $list_options) ? 'checked="checked"' : '' ?> class="option" data-text="<?php echo $vals;?>"> <?php echo $vals;?>
                                            <span></span>
                                        </label>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <a href="javascript:void(0);" class="btn btn-success m-btn m-btn--custom m-btn--icon add-attribute pull-right"><span><i class="la la-plus-circle"></i> Tambah Varian Produk</span></a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <div class="m-accordion m-accordion--bordered form-dynamic" id="m_accordion_2" role="tablist">
                                <?php echo $this->element('Products/partials/variant', [
                                        'data' => $get_product_option_prices,
                                        'dropdown' => $select_options,
                                        'branches' => $branches,
                                        'product_images' => $product_images,
                                        'product' => $product
                                ]); ?>
                            </div>
                        </div>
                    </div>



                </div>
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

<div class="modal fade" id="modal-brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Brand <span class="title-variant"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= $this->Form->create(null,['url' => ['action' => 'addBrands'],'class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form', 'id' => 'form-brand']); ?>
            <div class="modal-body">
                <?php echo $this->Form->hidden('code_cat', ['div' => false, 'label' => false, 'id' => 'code-cat']);?>
                <div class="form-group m-form__group row">
                    <label class="col-xl-4 col-form-label"><?= __d('AdminPanel',  'Nama Brand'); ?></label>
                    <div class="col-xl-8">
                        <?php echo $this->Form->control('name', ['div' => false, 'label' => false, 'class' => $default_class]);?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <?= $this->Form->submit(__('Simpan Brand'),['class' => 'btn btn-brand']) ?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

