<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $productStockMutations
 * nevix
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Report') ?>
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
                                <?= __('Report') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index', 'prefix' => 'report']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Product low stock report') ?>
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
                            <?= __('Product low stock report') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
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

                <!--begin: Search Form -->
                <form class="m-form m-form--fit m--margin-bottom-20">
                    <div class="row m--margin-bottom-20">
                        <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                            <label>Stok kurang dari:</label>
                            <input type="text" class="form-control m-input" placeholder="10" data-col-index="6">
                        </div>
                        <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                            <label>Branch:</label>
                            <?= $this->Form->select('branch.id', $branches, ['empty' => '-', 'class' => 'form-control m-input', 'data-col-index' => 3]); ?>
                        </div>
                    </div>

                    <div class="m-separator m-separator--md m-separator--dashed"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-brand m-btn m-btn--icon" id="m_search">
												<span>
													<i class="la la-search"></i>
													<span>Search</span>
												</span>
                            </button>
                            &nbsp;&nbsp;
                            <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
												<span>
													<i class="la la-close"></i>
													<span>Reset</span>
												</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="m_datatable">

                    <table class="table table-striped- table-bordered table-hover table-checkable" id="table-review">
                        <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Nama Produk</th>
                            <th>Sub SKU</th>
                            <th>Cabang</th>
                            <th>Variant</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Supplier</th>
                            <th>Stock</th>
                            <th>Harga Jual</th>
                        </tr>
                        </thead>
                    </table>
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
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<?php
echo $this->Html->script([
'/admin-assets/app/js/lib-tools.js',
]);
?>
<script>



    var datatable = $('#table-review').DataTable({

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
        order: [[0, 'desc']],
        ajax: {
            url: "<?= $this->Url->build(['action' => 'index', 'prefix' => 'report']); ?>",
            type: 'POST',
            data: {
                pagination: {
                    perpage: 50,
                },
                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
            },
        },
        initComplete: function(settings, json) {

        },
        columns: [
            {data: 'Products.sku'},
            {data: 'Products.name'},
            {data: 'ProductOptionPrices.sku'},
            {data: 'Branches.name'},
            {data: 'category'},
            {data: 'variant'},
            {data: 'Brands.name'},
            {data: 'Products.supplier_code'},
            {data: 'stock'},
            {data: 'products.price_sale'},
            // {data: 'comment'},
            // {data: 'created'},
        ],
        //
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return row.product.sku;
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return row.product ? row.product.name : '-';
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
                    return row.branch ? row.branch.name : '-';
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    return row.variant ? row.variant : '-';
                }
            },
            {
                targets: 5,
                orderable: false,
                render: function (data, type, row, meta) {
                    return row.product.product_to_categories[0].product_category.name;
                }
            },
            {
                targets: 6,
                render: function (data, type, row, meta) {
                    return row.product.brand ? row.product.brand.name : '';
                }
            },
            {
                targets: 7,
                render: function (data, type, row, meta) {
                    return row.product ? row.product.supplier_code : '-';
                }
            },
            {
                targets: 9,
                render: function (data, type, row, meta) {
                    return row.product ? parseInt(row.product.price_sale).format(0, 3, '.', ',') : '-';
                }
            },
        ]

    });

    var filter = function() {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        datatable.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
    };

    var asdasd = function(value, index) {
        var val = $.fn.dataTable.util.escapeRegex(value);
        datatable.column(index).search(val ? val : '', false, true);
    };

    $('#m_search').on('click', function(e) {
        e.preventDefault();
        var params = {};
        $('.m-input').each(function() {
            var i = $(this).data('col-index');
            if (params[i]) {
                params[i] += '|' + $(this).val();
            }
            else {
                params[i] = $(this).val();
            }
        });
        $.each(params, function(i, val) {
            // apply search params to datatable
            datatable.column(i).search(val ? val : '', false, false);
        });
        datatable.table().draw();
    });

    $('#m_reset').on('click', function(e) {
        e.preventDefault();
        $('.m-input').each(function() {
            $(this).val('');
            datatable.column($(this).data('col-index')).search('', false, false);
        });
        datatable.table().draw();
    });


    $('#export_print').on('click', function(e) {
        e.preventDefault();
        datatable.button(0).trigger();
    });

    $('#export_copy').on('click', function(e) {
        e.preventDefault();
        datatable.button(1).trigger();
    });

    $('#export_excel').on('click', function(e) {
        e.preventDefault();
        datatable.button(2).trigger();
    });

    $('#export_csv').on('click', function(e) {
        e.preventDefault();
        datatable.button(3).trigger();
    });

    $('#export_pdf').on('click', function(e) {
        e.preventDefault();
        datatable.button(4).trigger();
    });
</script>
<?php $this->end(); ?>



