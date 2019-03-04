<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $brands
 * nevix
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Manajemen Harga') ?>
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
                                <?= __('Manajemen Harga') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Harga Varian') ?>
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
                            <?= __('Daftar Harga Varian') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_modal_1">
                                <span>
                                    <i class="la la-upload"></i>
                                    <span><?= __('Import Harga') ?></span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build('/files/csv/prices.csv'); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-download"></i>
                                    <span><?= __('Contoh CSV Harga') ?></span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item"></li>
                        <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                Actions
                            </a>
                            <div class="m-dropdown__wrapper" style="z-index: 101;">
                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 36px;"></span>
                                <div class="m-dropdown__inner">
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__content">
                                            <ul class="m-nav">
                                                <li class="m-nav__section m-nav__section--first">
                                                    <span class="m-nav__section-text">Export Tools</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_print">
                                                        <i class="m-nav__link-icon la la-print"></i>
                                                        <span class="m-nav__link-text">Print</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_copy">
                                                        <i class="m-nav__link-icon la la-copy"></i>
                                                        <span class="m-nav__link-text">Copy</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_excel">
                                                        <i class="m-nav__link-icon la la-file-excel-o"></i>
                                                        <span class="m-nav__link-text">Excel</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_csv">
                                                        <i class="m-nav__link-icon la la-file-text-o"></i>
                                                        <span class="m-nav__link-text">CSV</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_pdf">
                                                        <i class="m-nav__link-icon la la-file-pdf-o"></i>
                                                        <span class="m-nav__link-text">PDF</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>

                <div class="m_datatable" >
                    <?= $this->Form->create(null,['action' => 'validate','class' => 'm-form m-form--fit m-form--label-align-right','id' => 'frm-example']); ?>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="table-prices">
                        <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Produk</th>
                            <th>SKU</th>
                            <th>SKU Produk</th>
                            <th>Produk / Varian</th>
                            <th>Manajemen Harga</th>
                            <th>id</th>
                            <th>price</th>
                        </tr>
                        </thead>
                    </table>
                    <button class="btn m-btn m-btn--gradient-from-primary m-btn--gradient-to-info mt-5">Simpan</button></p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
$this->Html->css([
'/admin-assets/vendors/custom/datatables/datatables.bundle.css'
], ['block' => true]);
$this->Html->script([
'/admin-assets/vendors/custom/datatables/datatables.bundle',
'/admin-assets/vendors/custom/libs/validation-render',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>

    // begin first table
    var table = $('#table-prices').DataTable({
        responsive: true,
        autoWidth: false,
        buttons: [
            'print',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= $this->Url->build(); ?>",
            type: 'POST',
            data: {
                pagination: {
                    perpage: 50,
                },
                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
            },
        },
        drawCallback: function(settings) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            var last = null;
            api.column(2, {page: 'current'}).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td colspan="10">' + group + ' - ' +api.column(1, {page: 'current'}).data()[i]+'</td></tr>',
                        '<tr role="row" class="even"><td><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" name="Products['+api.column(6, {page: 'current'}).data()[i]+'][id]" value="'+api.column(6, {page: 'current'}).data()[i]+'" class="m-checkable" id="parent-'+api.column(6, {page: 'current'}).data()[i]+'"><span></span></label></td><td>'+api.column(2, {page: 'current'}).data()[i]+'</td><td><div class="form-group m-form__group row"><span class="col-xl-12"> '+api.column(1, {page: 'current'}).data()[i]+' </span></div></td><td><div class="form-group m-form__group row"><label class="col-xl-5 col-form-label"> SKU ID '+api.column(2, {page: 'current'}).data()[i]+' : </label><div class="col-xl-4"><input type="text" class="form-control numberinput"  name="Products['+api.column(6, {page: 'current'}).data()[i]+'][price_sale]" value="'+(new Intl.NumberFormat('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0})).format(api.column(7, {page: 'current'}).data()[i])+'"/></div></div></td></tr>',
                    );
                    last = group;
                }
            });
        },
        initComplete: function(settings, json) {
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

            $('input.child').on('change',function(){
                $( "#parent-"+$(this).data('parent')).prop('checked', true);
            })

        },
        columns: [
            {data: 'id'},
            {data: 'product.name'},
            {data: 'product.sku'},
            {data: 'sku'},
            {data: 'sku'},
            {data: 'sku'},
            {data: 'product_id'},
            {data: 'product.price_sale'},
        ],
        columnDefs: [
            {
                // hide columns by index number
                targets: [1,2,6,7],
                visible: false,
            },

            {
                orderable: false,
                targets: 0,
                render: function (data, type, row, meta) {
                    return '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">\n' +
                        '<input type="checkbox" name="Products['+row.product.id+'][ProductOptionPrices]['+row.id+'][id]" value="'+row.id+'" class="m-checkable child" data-parent="'+row.product.id+'">\n' +
                        '<span></span>\n' +
                        '</label>';
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return row.product.name;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return row.product.sku;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return row.sku;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    var tmp = '';
                    // $.each(row.product_option_prices, function(k,v){
                        var info = '';
                        $.each(row.product_option_value_lists,function (kk, vv) {
                            info += vv.option.name+' : '+ vv.option_value.name+', ';
                        })
                        tmp += '<div class="form-group m-form__group row"> \n' +
                            '<span class="col-xl-12"> '+info+'</span>\n' +
                            '</div>';
                    // }) ;
                    return tmp;
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    var tmp = '';
                    var info = '';
                    $.each(row.product_option_value_lists,function (kk, vv) {
                        info += vv.option.name+' : '+ vv.option_value.name+', ';
                    })

                    tmp += '<div class="form-group m-form__group row"> \n' +
                        '<label class="col-xl-5 col-form-label"> SKU ID '+row.sku+' : </label>\n' +
                        '<div class="col-xl-4"><input type="text" class="form-control numberinput"  name="Products['+row.product.id+'][ProductOptionPrices]['+row.id+'][price]" value="'+(new Intl.NumberFormat('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0})).format(row.price)+'"/></div>\n' +
                        '</div>';
                    return tmp;
                }
            },
        ],
    });


    // Handle form submission event
    $('#frm-example').on('submit', function(e){
        // Prevent actual form submission
        e.preventDefault();

        var formEl = $("#frm-example");

        // $('input[type="hidden"]', formEl).remove();

        var ajaxRequest = new ajaxValidation(formEl);
        ajaxRequest.setblockUI('.m-portlet__body');
        var datax = formEl.find('input.numberinput, input.m-checkable');
        // var datax = table.$('input,select,textarea');
        ajaxRequest.post("<?= $this->Url->build(['action' => 'validate']); ?>", datax, function(data, saved) {
            if (data.success) {
                location.href = '';
            }
        });
    });


    $('#export_print').on('click', function(e) {
        e.preventDefault();
        table.button(0).trigger();
    });

    $('#export_copy').on('click', function(e) {
        e.preventDefault();
        table.button(1).trigger();
    });

    $('#export_excel').on('click', function(e) {
        e.preventDefault();
        table.button(2).trigger();
    });

    $('#export_csv').on('click', function(e) {
        e.preventDefault();
        table.button(3).trigger();
    });

    $('#export_pdf').on('click', function(e) {
        e.preventDefault();
        table.button(4).trigger();
    });


</script>
<?php $this->end(); ?>



