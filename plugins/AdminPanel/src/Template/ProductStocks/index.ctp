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
                    <?= __('Manajemen Stock') ?>
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
                                <?= __('Manajemen Stock') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Stock') ?>
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
                            <?= __('Daftar Stock') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_modal_1">
                                <span>
                                    <i class="la la-upload"></i>
                                    <span><?= __('Import Stock') ?></span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build('/files/csv/stock.csv'); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-download"></i>
                                    <span><?= __('Contoh CSV Stock') ?></span>
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
                    <form  id="frm-example" method="POST">
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="table-stocks">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU ID</th>
                                <th>SUB SKU</th>
                                <th>Product</th>
                                <th>SKU Name</th>
                                <th>Warehouse</th>
                                <th>Inventory In Stock</th>
                                <th>Stock</th>
                                <th>Mutasi Stock</th>
                                <th>Order Useable Quantity</th>
                                <th>Resync WH</th>
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

<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="titleModal"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body contentModal">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal-->
<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Stock Mutation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('ProductStocks',['action' => 'import','class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form','type' => 'file']); ?>

                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-4">Cari FIle</label>
                    <div class="col-lg-8">
                        <?php
                             echo $this->Form->control('files',['class' => 'form-control', 'type' => 'file','div' => false, 'label' => false,]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <?= $this->Form->submit(__('Import'),['class' => 'btn btn-brand']) ?>
            </div>
            <?= $this->Form->end(); ?>
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

    function delete_data(id) {
        $.post( "<?= $this->Url->build(['action' => 'delete']); ?>/" + id, { _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>' } )
            .done(function( data ) {
                location.href = '<?= $this->Url->build();?>';
            });
    }

    function view_data(id) {
        $('#modalView').modal('show');
        $('.titleModal').html('Provinces View');
        $('.contentModal').load( "<?= $this->Url->build(['action' => 'view']); ?>/" + id);
    }
    // begin first table
    var table = $('#table-stocks').DataTable({
        responsive: true,

        buttons: [
            'print',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
        lengthMenu: [10, 25, 50, 100, 1000],
        processing: true,
        serverSide: true,
        order: [[1, 'desc']],
        ajax: {
            url: "<?= $this->Url->build(['action' => 'index']); ?>",
            type: 'POST',
            data: {
                pagination: {
                    perpage: 50,
                },
                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
            },
        },
        columns: [
            {data: 'id'},
            {data: 'Products.sku'},
            {data: 'ProductOptionPrices.sku'},
            {data: 'Products.name'},
            {data: 'skuname'},
            {data: 'branch_id'},
            {data: 'inventory'},
            {data: 'stock'},
            {data: 'order'},
        ],
        columnDefs: [
            {
                targets: 0,
                width: '30px',
                className: 'dt-right',
                orderable: false,
                render: function (data, type, row, meta) {

                    var ret ='<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">\n' +
                        '<input type="checkbox" name="ProductOptionStocks['+row.id+'][id]" value="'+row.id+'" class="m-checkable">\n' +
                        '<input type="hidden" name="ProductOptionStocks['+row.id+'][product_id]" value="'+row.product.id+'">';

                        $.each(row.product.product_images, function(k,v){
                            ret +=  '<input type="hidden" name="ProductOptionStocks['+row.id+'][image]" value="'+v.name+'">';
                            return false;
                        });
                        var combo = '';
                        $.each(row.value_lists, function (k,v) {
                            combo += v.option +' : '+v.values+ '<br>';
                        })
                        ret += '<input type="hidden" name="ProductOptionStocks['+row.id+'][name]" value="'+row.product.name+'">\n' +
                        '<input type="hidden" name="ProductOptionStocks['+row.id+'][slug]" value="'+row.product.slug+'">\n' +
                        '<input type="hidden" name="ProductOptionStocks['+row.id+'][variant]" value="'+combo+'">\n' +
                        '<span></span>\n' +
                        '</label>';

                    return ret;
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return row.product ? row.product.sku : '-';
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return row.product_option_price.sku;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return row.product.name;
                }
            },
            {
                targets: 4,
                orderable: false,
                render: function (data, type, row, meta) {
                    var combo = '';
                    $.each(row.value_lists, function (k,v) {
                        combo += v.option +' : '+v.values+ '<br>';
                    })
                    return combo;
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    return row.branches;
                }
            },
            {
                targets: 6,
                orderable: false,
                render: function (data, type, row, meta) {
                    return row.stock > 0 ? 'In Stock' : 'Out Of Stock';
                }
            },
            {
                targets: 7,
                render: function (data, type, row, meta) {
                    return row.stock;
                }
            },
            {
                targets: 8,
                orderable: false,
                render: function (data, type, row, meta) {
                    return '<div class="m-form__group form-group mt-2">\n' +
                        '<div class="m-radio-inline">\n' +
                        '<label class="m-radio">\n' +
                        '<input type="radio" name="ProductOptionStocks['+row.id+'][tipe]" value="penambahan" class="mutasi" data-row="'+row.id+'"> Penambahan\n' +
                        '<span></span>\n' +
                        '</label>\n' +
                        '<label class="m-radio">\n' +
                        '<input type="radio" name="ProductOptionStocks['+row.id+'][tipe]" value="pengurangan" class="mutasi" data-row="'+row.id+'"> Pengurangan\n' +
                        '<span></span>\n' +
                        '</label>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '<div class="m-form__group form-group row row-val-'+row.id+'" style="display:none;">\n' +
                        '<div class="col-xl-12"><input type="number" class="form-control" name="ProductOptionStocks['+row.id+'][stock]" placeholder="Jumlah Stock"/></div>\n' +
                        '<div class="col-xl-12"><input type="text" class="form-control"  name="ProductOptionStocks['+row.id+'][description]" placeholder="Deskripsi"/></div>\n' +
                        '</div>';
                }
            },
            {
                targets: 9,
                render: function (data, type, row, meta) {
                    return row.stock;
                }
            },
            {
                targets: 10,
                orderable: false,
                render: function (data, type, row, meta) {
                    return '<button type="button" class="m-btn btn btn-primary"><i class="la la-refresh"></i></button>';
                }
            }
        ],
    });

    $("#table-stocks").on('change', 'input.mutasi',function(){
        $('.row-val-'+$(this).data('row')).show()
    })


    // Handle form submission event
    $('#frm-example').on('submit', function(e){
        // Prevent actual form submission
        e.preventDefault();

        var formEl = $("#frm-example");

        // $('input[type="hidden"]', formEl).remove();

        var ajaxRequest = new ajaxValidation(formEl);
        ajaxRequest.setblockUI('.m-portlet__body');
        var datax = table.$('input,select,textarea');
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



