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
                            <div class="col-2">
                                <input type="text" name="created" class="form-control m-input" autocomplete="off" id="created">
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
                                <th>AWB No.</th>
                                <th>Total Invoice</th>
                                <th>Point</th>
                                <th>Voucher</th>
                                <th>Coupon</th>
                                <th>Ship.Cost</th>
                                <th>Total Bayar</th>
                                <th>SKU ID</th>
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

    var _exportData = function ( dt, inOpts )
    {

        var config = $.extend( true, {}, {
            rows:           null,
            columns:        '',
            grouped_array_index: [],
            modifier:       {
                search: 'applied',
                order:  'applied'
            },
            orthogonal:     'display',
            stripHtml:      true,
            stripNewlines:  true,
            decodeEntities: true,
            trim:           true,
            format:         {
                header: function ( d ) {
                    return strip( d );
                },
                footer: function ( d ) {
                    return strip( d );
                },
                body: function ( d ) {
                    return strip( d );
                }
            }

        }, inOpts );

        var strip = function ( str ) {
            if ( typeof str !== 'string' ) {
                return str;
            }

            // Always remove script tags
            str = str.replace( /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '' );

            if ( config.stripHtml ) {
                str = str.replace( /<[^>]*>/g, '' );
            }

            if ( config.trim ) {
                str = str.replace( /^\s+|\s+$/g, '' );
            }

            if ( config.stripNewlines ) {
                str = str.replace( /\n/g, ' ' );
            }

            if ( config.decodeEntities ) {
                _exportTextarea.innerHTML = str;
                str = _exportTextarea.value;
            }

            return str;
        };


        var header = dt.columns( config.columns ).indexes().map( function (idx) {
            var el = dt.column( idx ).header();
            return config.format.header( el.innerHTML, idx, el );
        } ).toArray();

        var footer = dt.table().footer() ?
            dt.columns( config.columns ).indexes().map( function (idx) {
                var el = dt.column( idx ).footer();
                return config.format.footer( el ? el.innerHTML : '', idx, el );
            } ).toArray() :
            null;

        var rowIndexes = dt.rows( config.rows, config.modifier ).indexes().toArray();
        var selectedCells = dt.cells( rowIndexes, config.columns );
        var cells = selectedCells
            .render( config.orthogonal )
            .toArray();
        var cellNodes = selectedCells
            .nodes()
            .toArray();

        var grouped_array_index     = config.grouped_array_index;                     //customised
        var no_of_columns           = header.length;
        var no_of_rows              = no_of_columns > 0 ? cells.length / no_of_columns : 0;
        var body                    = new Array( no_of_rows );
        var body_data               = new Array( no_of_rows );                                //customised
        var body_with_nodes         = new Array( no_of_rows );                          //customised
        var body_with_nodes_static  = new Array( no_of_rows );                          //customised
        var cellCounter             = 0;

        for (var i = 0, ien = no_of_rows; i < ien; i++)
        {
            var rows            = new Array( no_of_columns );
            var rows_with_nodes = new Array( no_of_columns );

            for ( var j=0 ; j<no_of_columns ; j++ )
            {
                rows[j]             = config.format.body( cells[ cellCounter ], i, j, cellNodes[ cellCounter ] );
                rows_with_nodes[j]  = config.format.body( cellNodes[ cellCounter ], i, j, cells[ cellCounter ] ).outerHTML;
                cellCounter++;
            }

            body[i]                     = rows;
            body_data[i]                = rows;
            body_with_nodes[i]          = $.parseHTML('<tr class="even">'+rows_with_nodes.join("")+'</tr>');
            body_with_nodes_static[i]   = $.parseHTML('<tr class="even">'+rows_with_nodes.join("")+'</tr>');
        }

        /******************************************** GROUP DATA *****************************************************/
        var row_array                       = dt.rows().nodes();
        var row_data_array                  = dt.rows().data();
        var iColspan                        = no_of_columns;
        var sLastGroup                      = "";
        var inner_html                      = '',
            grouped_index;
        var individual_group_array          = [],
            sub_group_array                 = [],
            total_group_array               = [];
        var no_of_splices                   = 0;  //to keep track of no of element insertion into the array as index changes after splicing one element

        for (var i = 0, row_length = body_with_nodes.length; i < row_length; i++)
        {
            sub_group_array[i]              = [];
            individual_group_array[i]       = [];

            var sGroup                      = '';

            for(var k = 0; k < grouped_array_index.length; k++)
            {
                sGroup                          = row_data_array[i][grouped_array_index[k]];
                inner_html                      = row_data_array[i][grouped_array_index[k]];
                grouped_index                   = k;
                individual_group_array[i][k]    = row_data_array[i][grouped_array_index[k]];
                sub_group_array[i][k]           = sGroup;
            }

            total_group_array[i] = sGroup;


            console.log("grouped_index",grouped_index);

            if ( sGroup !== sLastGroup )
            {
                var table_data              = [];
                var table_data_with_node    = '';

                for(var $column_index = 0;$column_index < iColspan;$column_index++)
                {
                    if($column_index === 0)
                    {
                        table_data_with_node        += '<td style="border-left:none;border-right:none">'+inner_html+'</td>';
                        table_data[$column_index]   = inner_html + " ";
                    }
                    else
                    {
                        table_data_with_node        += '<td style="border-left:none;border-right:none"></td>';
                        table_data[$column_index]   = '';
                    }
                }

                body_with_nodes.splice(i + no_of_splices, 0, $.parseHTML('<tr class="group group_'+grouped_index+' grouped-array-index_'+grouped_array_index[grouped_index]+'">'+table_data_with_node+'</tr>'));
                body_data.splice(i + no_of_splices, 0, table_data);
                no_of_splices++;
                sLastGroup = sGroup;
            }
        }

        return {
            header: header,
            footer: footer,
            body:   body_data
        };
    };

    var datatable = $('#table-orders').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'pageLength',
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible',
                    grouped_array_index: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
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
            url: "<?= $this->Url->build(['action' => 'detail', 'controller' => 'sales', 'prefix' => 'report']); ?>",
            type: 'POST',
            data: function(d) {
                d.pagination = {perpage: 50};
                d._csrfToken = '<?= $this->request->getParam('_csrfToken'); ?>';
                d.general = $("#generalSearch").val();
                d.type = $("#type").val();
                d.created = $("#created").val();
                d.status = $("#status").val();
            }
        },
        initComplete: function(settings, json) {

        },
        drawCallback: function(settings) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            var last = null;
            api.column(2, {page: 'current'}).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group">' +
                        '<td>Invoice </td><td>' + group + '</td>' +
                        '<td>Customer ' + api.column(4, {page: 'current'}).data()[i] + '</td>' +
                        '<td>Total Invoice Rp.' + parseInt(api.column(9, {page: 'current'}).data()[i]).format(0, 3, ',', '.') + '</td>' +
                        '<td colspan="2">Total Bayar Rp.' + parseInt(api.column(14, {page: 'current'}).data()[i]).format(0, 3, ',', '.') + '</td>' +
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
            {data: 'awb'},
            {data: 'total_invoice'},
            {data: 'point'},
            {data: 'voucher'},
            {data: 'coupon'},
            {data: 'shipping_cost'},
            {data: 'total'},
            {data: 'sku'},
            {data: 'product_name'},
            {data: 'sub_sku'},
            {data: 'qty'},
            {data: 'price'},
        ],

        columnDefs: [

            {
                // hide columns by index number
                targets: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                visible: false,
            },
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
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
                targets: 9,
                render: function (data, type, row, meta) {
                    return parseInt(row.total_invoice).format(0, 3, ',', '.');
                }
            },
            {
                targets: 10,
                render: function (data, type, row, meta) {
                    return parseInt(row.point).format(0, 3, ',', '.');
                }
            },
            {
                targets: 11,
                render: function (data, type, row, meta) {
                    return parseInt(row.voucher).format(0, 3, ',', '.');
                }
            },
            {
                targets: 12,
                render: function (data, type, row, meta) {
                    return parseInt(row.coupon).format(0, 3, ',', '.');
                }
            },
            {
                targets: 13,
                render: function (data, type, row, meta) {
                    return parseInt(row.shipping_cost).format(0, 3, ',', '.');
                }
            },
            {
                targets: 14,
                render: function (data, type, row, meta) {
                    return parseInt(row.total).format(0, 3, ',', '.');
                }
            },
            {
                targets: 19,
                render: function (data, type, row, meta) {
                    return parseInt(row.price).format(0, 3, ',', '.');
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



