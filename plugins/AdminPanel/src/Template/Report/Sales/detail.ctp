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
                        <a href="<?= $this->Url->build(['action' => 'detail', 'prefix' => 'report']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Sales Report') ?>
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
                            <?= __('Sales Report') ?>
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
                            <input type="text" class="form-control m-input" placeholder="Search Invoice,Email or Customer Name" id="generalSearch">
                        </div>
                        <div class="col-md-4">
                            <a href="javascript:void(0)" class="btn btn-default btn-filtering">Advance Filtering</a>
                        </div>
                    </div>
                    <div class="advance" style="display:none;">
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">Product Type</label>
                            <div class="col-2">
                                <?php
                                echo $this->Form->control('type', [
                                    'type' => 'select',
                                    'options' => [
                                        '1' => 'Regular Produk',
                                        '2' => 'Produk Digital'
                                    ],
                                    'div' => false,
                                    'label' => false,
                                    'empty' => 'Product Type',
                                    'class' => 'form-control m-input',
                                    'id' => 'type'
                                ]);?>
                            </div>
                            <label for="example-text-input" class="col-2 col-form-label">Date</label>
                            <div class="col-3">
                                <div class='input-group ' id='m_daterangepicker_6'>
                                    <input type='text' name="created" value="<?= $start; ?> / <?= $end; ?>" class="form-control m-input" readonly placeholder="Select date range" id="date_range" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">Payment Status</label>
                            <div class="col-2">
                                <?php
                                echo $this->Form->control('status', [
                                    'type' => 'select',
                                    'options' => [
                                        '1' => 'Pending',
                                        '2' => 'Success',
                                        '3' => 'Failed',
                                        '4' => 'Expired',
                                        '5' => 'Refund',
                                        '6' => 'Cancel'
                                    ],
                                    'div' => false,
                                    'label' => false,
                                    'empty' => 'Payment Status',
                                    'class' => 'form-control m-input',
                                    'id' => 'status'
                                ]);?>
                            </div>
                        </div>
                        <div class="sdigital" style="display:none;">
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">Transaction Digital Status</label>
                                <div class="col-2">
                                    <?php
                                    echo $this->Form->control('digital_status', [
                                        'type' => 'select',
                                        'options' => [
                                            '0' => 'Pending',
                                            '1' => 'Success',
                                            '2' => 'Failed',
                                        ],
                                        'div' => false,
                                        'label' => false,
                                        'empty' => 'Transaction Digital Status',
                                        'class' => 'form-control m-input',
                                        'id' => 'digital_status'
                                    ]);?>
                                </div>
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
                                <th>Created</th>
                                <th>Invoice</th>
                                <th>Tipe</th>
                                <th>Customer Name</th>
                                <th>Payment Status</th>
                                <th>Payment Method</th>
                                <th>Shipping Status</th>
                                <th>Digital Status</th>
                                <th>AWB No.</th>
                                <th>Total Invoice</th>
                                <th>Point</th>
                                <th>Voucher</th>
                                <th>Coupon</th>
                                <th>Ship.Cost</th>
                                <th>Total Bayar</th>
                                <th>SKU ID</th>
                                <th>Flash Sale</th>
                                <th>Nama Produk</th>
                                <th>Sub SKU ID</th>
                                <th>QTY</th>
                                <th>Harga Produk</th>
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

    $('select.selectpicker').selectpicker();

    // predefined ranges
    var start = moment().subtract(29, 'days');
    var end = moment();

    $('#m_daterangepicker_6').daterangepicker({
        buttonClasses: 'm-btn btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',

        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function(start, end, label) {
        $('#m_daterangepicker_6 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
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

    $('#type').on('change',function(){
        if($(this).val() == '2'){
            $('.sdigital').show();
        }else{
            $('#digital_status').val('');
            $('.sdigital').hide();
        }
    });

    var datatable = $('#table-orders').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible',
                },
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
        ordering: false,
        ajax: {
            url: "<?= $this->Url->build(['action' => 'detail', 'controller' => 'sales', 'prefix' => 'report']); ?>",
            type: 'POST',
            data: function(d) {
                d.pagination = {perpage: 50};
                d._csrfToken = '<?= $this->request->getParam('_csrfToken'); ?>';
                d.general = $("#generalSearch").val();
                d.type = $("#type").val();
                d.created = $("#date_range").val();
                d.status = $("#status").val();
                d.dstatus = $("#digital_status").val();
            }
        },
        initComplete: function(settings, json) {

        },
        drawCallback: function(settings) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            // console.log(api.columns(':visible')[0].length);
            // console.log(api.columns(':visible'));
            var last = null;
            api.column(2, {page: 'current'}).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group">' +
                        '<td colspan="'+api.columns(':visible')[0].length+'">' + api.column(2, {page: 'current'}).data()[i] + '</td>' +
                        '</tr>',
                        // '<tr class="group"><td colspan="20">' + group + ' - ' +api.column(1, {page: 'current'}).data()[i]+'</td></tr>',
                        // '<tr role="row" class="even"><td><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" name="Products['+api.column(8, {page: 'current'}).data()[i]+'][id]" value="'+api.column(8, {page: 'current'}).data()[i]+'" class="m-checkable" id="parent-'+api.column(8, {page: 'current'}).data()[i]+'"><span></span></label></td><td>'+api.column(3, {page: 'current'}).data()[i]+'</td><td>'+api.column(4, {page: 'current'}).data()[i]+'</td><td>'+api.column(2, {page: 'current'}).data()[i]+'</td><td><div class="form-group m-form__group row"><span class="col-xl-12"> '+api.column(1, {page: 'current'}).data()[i]+' </span></div></td><td><div class="form-group m-form__group row"><label class="col-xl-6 col-form-label"> SKU ID '+api.column(2, {page: 'current'}).data()[i]+' : </label><div class="col-xl-6"><input type="text" class="form-control numberinput"  name="Products['+api.column(8, {page: 'current'}).data()[i]+'][price_sale]" value="'+(new Intl.NumberFormat('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0})).format(api.column(9, {page: 'current'}).data()[i])+'"/></div></div></td></tr>',
                    );
                    last = group;
                }
            });
        },
        columns: [
            {data: 'id'},
            {data: 'created'},
            {data: 'invoice'},
            {data: 'type'},
            {data: 'customer_name'},
            {data: 'payment_status'},
            {data: 'payment_type'},
            {data: 'shipping_status'},
            {data: 'digital_status'},
            {data: 'awb'},
            {data: 'total_invoice'},
            {data: 'point'},
            {data: 'voucher'},
            {data: 'coupon'},
            {data: 'shipping_cost'},
            {data: 'total'},
            {data: 'sku'},
            {data: 'flashsale'},
            {data: 'product_name'},
            {data: 'sub_sku'},
            {data: 'qty'},
            {data: 'price'},
        ],

        columnDefs: [

            // {
                // hide columns by index number
                // targets: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                // visible: false,
            // },
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return row.invoice;
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    let status = {
                        1: {'class': 'm-badge--default', 'name': 'Pending'},
                        2: {'class': ' m-badge--success', 'name': 'Success'},
                        3: {'class': ' m-badge--danger', 'name': 'Failed'},
                        4: {'class': ' m-badge--default', 'name': 'Expired'},
                        5: {'class': ' m-badge--danger', 'name': 'Refund'},
                        6: {'class': ' m-badge--danger', 'name': 'Cancel'},
                    };
                    return row.payment_status && status[row.payment_status] ? '<span class="m-badge ' + status[row.payment_status].class + ' m-badge--wide">'
                        + status[row.payment_status].name
                        + '</span>' : '-';
                }
            },
            {
                targets: 7,
                render: function (data, type, row, meta) {
                    let status = {
                        1: {'name': 'Menunggu Pembayaran'},
                        2: {'name': 'Di Proses'},
                        3: {'name': 'Di Kirim'},
                        4: {'name': 'Selesai'}
                    };
                    return row.shipping_status && status[row.shipping_status] ?  status[row.shipping_status].name  : '-';
                }
            },
            {
                targets: 8,
                render: function (data, type, row, meta) {
                    var status = {
                        0: {'class': 'm-badge--default', 'name': 'Pending'},
                        1: {'class': ' m-badge--success', 'name': 'Success'},
                        2: {'class': ' m-badge--danger', 'name': 'Failed'},
                    };
                    return typeof row.digital_status && status[row.digital_status] ? '<span class="m-badge ' + status[row.digital_status].class + ' m-badge--wide">'
                        + status[row.digital_status].name
                        + '</span>' : '-';
                }
            },
            {
                targets: 10,
                render: function (data, type, row, meta) {
                    return row.total_invoice ? parseInt(row.total_invoice).format(0, 3, ',', '.') : 0;
                }
            },
            {
                targets: 11,
                render: function (data, type, row, meta) {
                    return row.point ? parseInt(row.point).format(0, 3, ',', '.') : 0;
                }
            },
            {
                targets: 12,
                render: function (data, type, row, meta) {
                    return row.voucher ? parseInt(row.voucher).format(0, 3, ',', '.') : 0;
                }
            },
            {
                targets: 13,
                render: function (data, type, row, meta) {
                    return row.coupon ? parseInt(row.coupon).format(0, 3, ',', '.') : 0;
                }
            },
            {
                targets: 14,
                render: function (data, type, row, meta) {
                    return row.shipping_cost ? parseInt(row.shipping_cost).format(0, 3, ',', '.') : 0;
                }
            },
            {
                targets: 15,
                render: function (data, type, row, meta) {
                    return row.total ? parseInt(row.total).format(0, 3, ',', '.') : 0;
                }
            },
            {
                targets: 17,
                render: function (data, type, row, meta) {
                    return row.flashsale ? row.flashsale : '-';
                }
            },
            {
                targets: 18,
                render: function (data, type, row, meta) {
                    return (row.type == 'Product') ? row.product_name : row.digital_name;
                }
            },
            {
                targets: 20,
                render: function (data, type, row, meta) {
                    return (row.type == 'Product') ? row.qty : '1';
                }
            },
            {
                targets: 21,
                render: function (data, type, row, meta) {
                    return (row.type == 'Product') ? (row.price) ? parseInt(row.price).format(0, 3, ',', '.') : 0 :  parseInt(row.digital_price).format(0, 3, ',', '.') ;
                }
            },

        ]

    });

    $('#table-orders').on( 'column-visibility.dt', function ( e, settings, column, state ) {
        console.log(
            'Column '+ column +' has changed to '+ (state ? 'visible' : 'hidden')
        );
    } );
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



