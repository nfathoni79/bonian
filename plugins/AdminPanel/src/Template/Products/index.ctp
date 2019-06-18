
<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('Products',['action' => 'import','class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form','type' => 'file']); ?>

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

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Products') ?>
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
                                <?= __('Products') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Products') ?>
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
                            <?= __('List Products') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_modal_1">
                                <span>
                                    <i class="la la-upload"></i>
                                    <span><?= __('Import Product') ?></span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build('/files/csv/product.csv'); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-download"></i>
                                    <span><?= __('Contoh CSV Product') ?></span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span><?= __('New Product') ?></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">General Search</label>
                        <div class="col-4">
                            <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                        </div>
                        <div class="col-md-4">
                            <a href="javascript:void(0)" class="btn btn-default btn-filtering">Advance Filtering</a>
                        </div>
                    </div>
                    <div class="advance" style="display:none;">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">Main SKU</label>
                            <div class="col-4">
                                <input type="text" class="form-control m-input" placeholder="SKU" id="sku">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">Stock Status</label>
                            <div class="col-2">
                                <?php
                                echo $this->Form->control('Stock', [
                                    'type' => 'select',
                                    'options' => [
                                        '1' => 'In Stock',
                                        '2' => 'Out of Stock'
                                    ],
                                    'div' => false,
                                    'label' => false,
                                    'empty' => 'Stock Status',
                                    'class' => 'form-control m-input',
                                    'id' => 'stock'
                                ]);?>
                            </div>
                            <label for="example-text-input" class="col-2 col-form-label">Publish Status</label>
                            <div class="col-2">
                                <?php
                                echo $this->Form->control('Publish', [
                                    'type' => 'select',
                                    'options' => [
                                        '1' => 'Publish',
                                        '2' => 'Unpublish'
                                    ],
                                    'div' => false,
                                    'label' => false,
                                    'empty' => 'Publish Status',
                                    'class' => 'form-control m-input',
                                    'id' => 'publish'
                                ]);?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">Creation Date</label>
                            <div class="col-2">
                                <input type="text" name="created" class="form-control m-input" autocomplete="off" id="created">
                            </div>
                        </div>
                    </div>

                    <div class="m-separator m-separator--md m-separator--dashed"></div>
                    <div class="row">
                        <div class="col-lg-11  offset-md-1">
                            <button class="btn btn-brand m-btn m-btn--icon" id="m_search">
                                    <span>
                                        <i class="la la-search"></i>
                                        <span>Search</span>
                                    </span>
                            </button>
                            <button class="btn btn-secondary m-btn m-btn--icon" id="m_reset">
                                    <span>
                                        <i class="la la-close"></i>
                                        <span>Reset</span>
                                    </span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="m_datatable">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="table-product-list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Stock Status</th>
                                    <th>Harga Jual</th>
                                    <th>Publish Status</th>
                                    <th>View</th>
                                    <th>Creation</th>
                                    <th>Point</th>
                                    <th>Categories</th>
                                    <th>Supplier</th>
                                    <th>Brand</th>
                                    <th>Sub SKU</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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

<?php
$this->Html->css([
    '/admin-assets/vendors/custom/datatables/datatables.bundle.css'
], ['block' => true]);
$this->Html->script([
    '/admin-assets/vendors/custom/datatables/datatables.bundle',
    '/admin-assets/vendors/custom/datatables/buttons.colVis.min',
    '/admin-assets/app/js/lib-tools.js',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>

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


    $('.btn-filtering').on('click',function(){
        $(this).hide();
        $('.advance').show();
    })

    $('#created').datepicker({
        rtl: mUtil.isRTL(),
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows,
        format: 'yyyy-mm-dd'
    });

    var datatable = $('#table-product-list').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],
        searching: false,
        lengthMenu: [10, 25, 50, 100, 1000],
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: "<?= $this->Url->build(['action' => 'index']); ?>",
            type: 'POST',
            data: function(d) {
                d.pagination = {perpage: 50};
                d._csrfToken = '<?= $this->request->getParam('_csrfToken'); ?>';
                // d.date = Math.random();
                d.general = $("#generalSearch").val();
                d.sku = $("#sku").val();
                d.stock = $("#stock").val();
                d.publish = $("#publish").val();
                d.created = $("#created").val();
            }
        },
        initComplete: function(settings, json) {

        },
        drawCallback_: function( settings ) {
            var api = this.api();
            console.log(api, settings);
            // Output the data for the visible rows to the browser's console
            //console.log( api.rows( {page:'current'} ).data() );
        },
        columns: [
            {data: 'Products.id'},
            {data: 'Products.ProductImages.name'},
            {data: 'Products.name'},
            {data: 'Products.sku'},
            {data: 'Products.ProductStockStatus.name'},
            {data: 'Products.price_sale'},
            {data: 'Products.ProductStatus.name'},
            {data: 'Products.view'},
            {data: 'Products.created'},
            {data: 'Products.id'},
            {data: 'Products.point'},
            {data: 'Products.ProductToCategories.0.ProductCategory.name'},
            {data: 'Products.supplier_code'},
            {data: 'Products.Brand.name'},
            {data: 'Products.id'},
        ],
        //
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    var primary_image = '<a href="<?= $this->Url->build(['action' => 'edit']); ?>/'+ row.id +'"><img src="<?= $this->Url->build('/admin-assets/app/media/img/products/no-image.png');?>" style="width: 50px;" /></a>';
                    if (typeof row.product_images != 'undefined' && row.product_images.length > 0) {
                        primary_image = row.product_images[0].name;
                        for(var i in row.product_images) {
                            if (row.product_images[i].primary === 1) {
                                primary_image = row.product_images[i].name;
                            }
                        }
                        primary_image = '<a href="<?= $this->Url->build(['action' => 'edit']); ?>/'+ row.id +'"><img src="<?= $this->Url->build('/images/50x50/');?>' + primary_image + '" style="width: 50px;" /></a>';
                    }
                    return primary_image;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return row.name;
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
                    var status = {
                        1: {'class': 'm-badge--success'},
                        2: {'class': ' m-badge--danger'},
                    };
                    return '<span class="m-badge ' + status[row.product_stock_status_id].class + ' m-badge--wide">' + row.product_stock_status.name + '</span>';
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    return parseInt(row.price_sale).format(0, 3, '.', ',');
                }
            },
            {
                targets: 6,
                render: function (data, type, row, meta) {
                    var status = {
                        1: {'class': 'm-badge--success'},
                        2: {'class': ' m-badge--danger'},
                    };
                    return '<span class="m-badge ' + status[row.product_status_id].class + ' m-badge--wide">' + row.product_status.name + '</span>';
                }
            },
            {
                targets: 7,
                render: function (data, type, row, meta) {
                    return row.view;
                }
            },
            {
                targets: 8,
                render: function (data, type, row, meta) {
                    return row.created;
                }
            },
            {
                targets: 9,
                visible: false,
                render: function (data, type, row, meta) {
                    return row.point;
                }
            },
            {
                targets: 10,
                visible: false,
                render: function (data, type, row, meta) {
                    return row.product_to_categories[0].product_category.name;
                }
            },
            {
                targets: 11,
                visible: false,
                render: function (data, type, row, meta) {
                    return row.supplier_code;
                }
            },
            {
                targets: 12,
                visible: false,
                render: function (data, type, row, meta) {
                    return row.brand.name;
                }
            },
            {
                targets: 13,
                visible: false,
                render: function (data, type, row, meta) {
                    var domDraw = '';
                    $.each(row.product_option_prices, function(k,v){
                        domDraw += ' SUB SUK : '+ v.sku+'<br>';
                        domDraw += ' Harga Tambahan : Rp.'+ parseInt(v.price).format(0, 3, '.', ',')+'<br>';
                        var variant = '';
                        $.each(v.product_option_value_lists, function(kk,vv){
                            variant += ' '+vv.option.name +'('+vv.option_value.name+')';
                        })
                        domDraw += ' Variant : '+ variant+'<br>';
                        var stockCabang = '';
                        $.each(v.product_option_stocks, function(kk,vv){
                            stockCabang += ' '+vv.branch.name +'('+vv.stock+')';
                        })
                        domDraw += ' Stock Cabang : '+ stockCabang+'<br><hr>';
                    })
                    return domDraw;
                }
            },
            {
                targets: -1,
                render: function (data, type, row, meta) {
                    return '<a href="<?= $this->Url->build(['action' => 'edit']); ?>/'+ row.id +'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a><a href="javascript:delete_data('+row.id+');" onclick="return confirm(\'Are you sure delete #'+row.id+'\');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
                }
            },

        ]

    });



    $('#m_search').on('click', function(e) {
        e.preventDefault();
        $( datatable.column(0).header()).text( $("#stock option:selected").text() );
        datatable.table().draw();
    });

    $('#m_reset').on('click', function(e) {
        e.preventDefault();
        $('.m-input').each(function() {
            $(this).val('');
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