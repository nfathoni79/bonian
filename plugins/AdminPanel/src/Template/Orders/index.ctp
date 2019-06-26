<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $orders
 * nevix
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Orders') ?>
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
                                <?= __('Orders') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Orders') ?>
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
                            <?= __('List Orders') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

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
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="table-orders">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Voucher</th>
                                <th>Diskon Kupon</th>
                                <th>Diskon Voucher</th>
                                <th>Gross Total</th>
                                <th>Total</th>
                                <th>Payment Status</th>
                                <th>Payment Method</th>
                                <th>Shipping Destination</th>
                                <th>Created</th>
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

<?php $this->append('script'); ?>
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
<script>

    var datatable = $('#table-orders').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
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
        lengthChange: true,
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
                // d.sku = $("#sku").val();
                // d.stock = $("#stock").val();
                // d.publish = $("#publish").val();
                // d.created = $("#created").val();
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
            {data: 'id'},
            {data: 'invoice'},
            {data: 'Customers.first_name'},
            {data: 'Customers.email'},
            {data: 'Vouchers.name'},
            {data: 'discount_kupon'},
            {data: 'discount_voucher'},
            {data: 'gross_total'},
            {data: 'total'},
            {data: 'payment_status'},
            {data: 'id'},
            {data: 'id'},
            {data: 'created'},
            {data: 'id'},
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
                    return row.invoice;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return row.customer.first_name;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return row.customer.email;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    return row.voucher ? row.voucher.name : '-';
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    return parseInt(row.discount_kupon).format(0, 3, ',', '.');
                }
            },
            {
                targets: 6,
                render: function (data, type, row, meta) {
                    return parseInt(row.discount_voucher).format(0, 3, ',', '.');
                }
            },
            {
                targets: 7,
                render: function (data, type, row, meta) {
                    return parseInt(row.gross_total).format(0, 3, ',', '.');
                }
            },
            {
                targets: 8,
                render: function (data, type, row, meta) {
                    return parseInt(row.total).format(0, 3, ',', '.');
                }
            },
            {
                targets: 9,
                render: function (data, type, row, meta) {
                    let status = {
                        1: {'class': 'm-badge--default', 'name': 'Pending'},
                        2: {'class': ' m-badge--success', 'name': 'Success'},
                        3: {'class': ' m-badge--danger', 'name': 'Failed'},
                        4: {'class': ' m-badge--default', 'name': 'Expired'}
                    };
                    return row.payment_status && status[row.payment_status] ? '<span class="m-badge ' + status[row.payment_status].class + ' m-badge--wide">'
                        + status[row.payment_status].name
                        + '</span>' : '-';
                }
            },
            {
                targets: 10,
                render: function (data, type, row, meta) {
                    return row.transactions.length > 0 ? row.transactions[row.transactions.length - 1].payment_type : '-';
                }
            },
            {
                targets: 11,
                render: function (data, type, row, meta) {
                    // return row.created;
                    var doms = '';
                    doms += 'Nama Penerima : '+row.recipient_name+'<br>';
                    doms += 'Telepon : '+row.recipient_phone+'<br>';
                    return doms;
                }
            },
            {
                targets: 12,
                render: function (data, type, row, meta) {
                    return row.created;
                }
            },
            {
                targets: -1,
                render: function (data, type, row, meta) {
                    return '<a href="<?= $this->Url->build(['action' => 'edit']); ?>/'+ row.id +'"class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a><a href="javascript:delete_data('+row.id+');" onclick="return confirm(\'Are you sure delete #'+row.id+'\');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
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
</script>
<?php $this->end(); ?>



