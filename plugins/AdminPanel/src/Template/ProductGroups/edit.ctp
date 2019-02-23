<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productGroup
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
                                <?= __('Group Sale') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Group Sale') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Edit Group Sale') ?>
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
                            <?= __('Edit Group Group') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>

            <?= $this->Form->create($productGroup,['id' => 'm_form','class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form']); ?>

            <div class="m-portlet__body">
                <?php
                    $this->Form->setConfig('errorClass', 'is-invalid');
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                ?>

                <?php  echo $this->Form->control('id',['type' => 'hidden','class' => $default_class]); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <?php  echo $this->Form->control('name',['class' => $default_class,'required' => false,'label' => 'Judul Promosi']); ?>
                            </div>
                            <div class="col-lg-6">
                                <?php  echo $this->Form->control('value',['class' => $default_class,'required' => false,'label' => 'Volume Group']); ?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <?php echo $this->Form->control('date_start',['type' => 'text','required' => false,'class' => $default_class, 'id' => 'm_datetimepicker_start', 'label' => 'Start']); ?>
                            </div>
                            <div class="col-lg-6">
                                <?php echo $this->Form->control('date_end',['type' => 'text','required' => false,'class' => $default_class, 'id' => 'm_datetimepicker_end', 'label' => 'End']); ?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <?php  echo $this->Form->control('status',['options' => ['0' => 'Pending', '1' => 'Berjalan', '2' => 'Berakhir'],'class' => $default_class,'label' => 'Status']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group m-form__group m--margin-top-10">
                    <div class="alert m-alert m-alert--default" role="alert">
                        Produk yang akan dijual dalam group sale <a href="javascript:void(0);" class="btn btn-success m-btn m-btn--custom m-btn--icon add-group-sale"><span><i class="la la-plus-circle"></i> Tambah Produk Flash Sale</span></a>
                    </div>
                </div>
                <div class="row mt-3 p-group-sale">
                    <?php foreach($ProductGroupDetail as $k => $vals):?>
                    <input type="hidden" name="ProductGroupDetails[<?php echo $k;?>][idx]" class="form-control form-control-danger m-input m-input--air" value="<?php echo $vals['id'];?>">
                    <div class="col-md-12 rowing-<?php echo $k;?>">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2">Nama Produk</label>
                            <div class="col-lg-4">
                                <div class="m-typeahead">
                                    <input type="text" name="ProductGroupDetails[<?php echo $k;?>][produk]" placeholder="Pencarian Produk" class="form-control form-control-danger m-input m-input--air k_typeahead" dir="ltr" data-row="<?php echo $k;?>" value="<?php echo $vals['product']['name'];?>">
                                    <a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--custom m-btn--icon delete-group-sale mt-3" data-row="<?php echo $k;?>" data-key="<?php echo $vals['id'];?>"><span><i class="la la-trash"></i> Hapus dari daftar produk</span></a>
                                </div>
                            </div>
                            <div class="col-lg-5 offset-1 info-detail-<?php echo $k;?>">
                                <div class="m-widget5 pull-left">
                                    <div class="m-widget5__item">
                                        <div class="m-widget5__content">
                                            <div class="m-widget5__pic"><img class="m-widget3__img" src="<?= $this->Url->build('/images/100x100'); ?>/<?php echo $vals['product']['images'];?>" alt=""></div>
                                            <div class="m-widget5__section">
                                                <h4 class="m-widget5__title"><?php echo $vals['product']['name'];?></h4>
                                                <span class="m-widget5__info"> Harga Reguler : <s>Rp. <?php echo $vals['product']['price'];?></s></span><br>
                                                <span class="m-widget5__info"> Harga Jual : Rp. <?php echo $vals['product']['price_sale'];?></span><br>
                                                <span class="m-widget5__info"> Sisa Stock :  <?php echo $vals['product']['stock'];?></span><br>
                                                <input type="hidden" name="ProductGroupDetails[<?php echo $k;?>][produk_id]" class="form-control form-control-danger m-input m-input--air" value="<?php echo $vals['product']['id'];?>">
                                                <input type="text" name="ProductGroupDetails[<?php echo $k;?>][price_sale]" class="form-control form-control-danger m-input m-input--air" placeholder="Harga Flash Sale" value="<?php echo $vals['price_sale'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>


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
<?php $this->append('script'); ?>
<?php
echo $this->Html->script([
'/admin-assets/vendors/custom/libs/validation-render',
]);
?>
<script>
    $('.delete-group-sale').click(function (event) {
        if (confirm('Are you sure you want to delete this?')) {
            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'ProductDeals', 'action' => 'deleteDetail']); ?>',
                type: "POST",
                data: {
                    id: $(this).data('key'),
                    _csrfToken : $('input[name=_csrfToken]').val()
                },
                success: function (data) {
                    if(!data.is_error){
                        location.reload();
                    }
                }
            });
        }
    });


    $('.add-group-sale').on('click',function(){


        var rows = $('.m-typeahead').length + 1;

        var template = '<div class="col-md-12 mt-5 rowing-'+rows+'">\n' +
            '<div class="form-group m-form__group row">\n' +
            '<label class="col-form-label col-lg-2">Nama Produk</label>\n' +
            '<div class="col-lg-4">\n' +
            '<div class="m-typeahead">\n' +
            '<input type="text" name="ProductDealDetails['+rows+'][produk]" placeholder="Pencarian Produk" class="form-control form-control-danger m-input m-input--air k_typeahead'+rows+'" dir="ltr" data-row="'+rows+'"><a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--custom m-btn--icon delete-group-sale mt-3" data-row="'+rows+'"> <span><i class="la la-trash"></i> Hapus dari daftar produk</span></a>\n' +
            '</div>\n' +
            '</div>\n' +
            '<div class="col-lg-5 offset-1 info-detail-'+rows+'">\n' +
            '</div>\n' +
            '</div>\n' +
            '</div>';
        $('.p-group-sale').append(template);
        $('.delete-group-sale').on('click',function(){
            $('div').remove('.rowing-'+$(this).data('row'));
        });
        var bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= $this->Url->build(['controller' =>'ProductDeals','action' => 'productExist']); ?>'
        });
        bestPictures.clearPrefetchCache();
        bestPictures.initialize();

        $('.k_typeahead'+rows).typeahead(null, {
            display: 'name',
            source: bestPictures,
            templates: {
                empty: [
                    '<div class="empty-message" style="padding: 10px 15px; text-align: center;">',
                    'Produk tidak ditemukan dalam daftar produk',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div><strong>{{name}}</strong> (SKU:{{sku}})</div>')
            },
        });
        $('.k_typeahead'+rows).on('typeahead:select', function(evt, item) {
            var row = $(this).data('row');

            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build(['controller' => 'ProductDeals','action' => 'productDetails']); ?>',
                data: {sku: item.sku, _csrfToken : $('input[name=_csrfToken]').val()},
                success: function (data) {
                    var template = '<div class="m-widget5 pull-left">\n' +
                        '<div class="m-widget5__item">\n' +
                        '<div class="m-widget5__content">\n' +
                        '<div class="m-widget5__pic"><img class="m-widget3__img" src="<?= $this->Url->build('/images/100x100'); ?>/'+data.product_images[0]['name']+'" alt=""></div>\n' +
                    '<div class="m-widget5__section">\n' +
                    '<h4 class="m-widget5__title">'+data.name+'</h4>\n' +
                    '<span class="m-widget5__info"> Harga Reguler : <s>Rp. ' + data.price +'</s></span><br>\n' +
                    '<span class="m-widget5__info"> Harga Jual : Rp. ' + data.price_discount +'</span><br>\n' +
                    '<span class="m-widget5__info"> Sisa Stock : Rp. ' + data.stock +'</span><br>\n' +
                    '<input type="hidden" name="ProductDealDetails['+row+'][produk_id]" class="form-control form-control-danger m-input m-input--air" value="'+data.id+'">\n'+
                    '<input type="text" name="ProductDealDetails['+row+'][price_sale]" class="form-control form-control-danger m-input m-input--air" placeholder="Harga Flash Sale">\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>';
                    $('.info-detail-'+row).html(template);
                }
            });
        })
    })

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



    var formEl = $("#m_form");
    var url = '<?= $this->Url->build(['action' => 'validateAjax']); ?>';
    var ajaxRequest = new ajaxValidation(formEl);
    ajaxRequest.setblockUI('.m-portlet m-portlet--mobile');


    $("#m_form").submit(function(e) {
        ajaxRequest.post(url, formEl.find(':input'), function(data,saved) {
            if (data.success) {
                location.reload();
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    function init(){

        var bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?= $this->Url->build(['controller' => 'ProductDeals','action' => 'productExist']); ?>'
        });
        bestPictures.clearPrefetchCache();
        bestPictures.initialize();

        $('.k_typeahead').typeahead(null, {
            display: 'name',
            source: bestPictures,
            templates: {
                empty: [
                    '<div class="empty-message" style="padding: 10px 15px; text-align: center;">',
                    'Produk tidak ditemukan dalam daftar produk',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div><strong>{{name}}</strong> (SKU:{{sku}})</div>')
            },
        });

        $('.k_typeahead').on('typeahead:select', function(evt, item) {
            var row = $(this).data('row');

            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build(['controller' => 'ProductDeals','action' => 'productDetails']); ?>',
                data: {sku: item.sku, _csrfToken : $('input[name=_csrfToken]').val()},
                success: function (data) {
                    var template = '<div class="m-widget5 pull-left">\n' +
                        '<div class="m-widget5__item">\n' +
                        '<div class="m-widget5__content">\n' +
                        '<div class="m-widget5__pic"><img class="m-widget3__img" src="<?= $this->Url->build('/images/100x100'); ?>/'+data.product_images[0]['name']+'" alt=""></div>\n' +
                    '<div class="m-widget5__section">\n' +
                    '<h4 class="m-widget5__title">'+data.name+'</h4>\n' +
                    '<span class="m-widget5__info"> Harga Reguler : <s>Rp. ' + data.price +'</s></span><br>\n' +
                    '<span class="m-widget5__info"> Harga Jual : Rp. ' + data.price_discount +'</span><br>\n' +
                    '<span class="m-widget5__info"> Sisa Stock : Rp. ' + data.stock +'</span><br>\n' +
                    '<input type="hidden" name="ProductDealDetails['+row+'][produk_id]" class="form-control form-control-danger m-input m-input--air" value="'+data.id+'">\n'+
                    '<input type="text" name="ProductDealDetails['+row+'][price_sale]" class="form-control form-control-danger m-input m-input--air" placeholder="Harga Flash Sale">\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>\n' +
                    '</div>';
                    $('.info-detail-'+row).html(template);
                }
            });
        })
    }

    init();

</script>

<?php $this->end(); ?>

