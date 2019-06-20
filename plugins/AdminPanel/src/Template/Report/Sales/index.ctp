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
                            <label>Tanggal:</label>
                            <div class='input-group ' id='m_daterangepicker_6'>
                                <input type='text' name="date_range" value="<?= $start; ?> / <?= $end; ?>" class="form-control m-input" readonly placeholder="Select date range" id="date_range" />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                            <label>Branch:</label>
                            <?= $this->Form->select('branch_id', $branches, ['empty' => '-', 'id' => 'branch_id', 'class' => 'form-control m-input selectpicker', 'data-col-index' => 3]); ?>
                        </div>
                        <div class="col-lg-2 m--margin-bottom-10-tablet-and-mobile">
                            <label>Report By:</label>
                            <?= $this->Form->select('report_type', [1 => 'Category', 2 => 'Brand', 3 => 'Period'], ['value' => 1, 'id' => 'report_type', 'class' => 'form-control selectpicker', 'data-col-index' => 3]); ?>
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
                            <th>Category</th>
                            <th>Item Sales</th>
                            <th>Gross Sales</th>
                            <th>Use Voucher</th>
                            <th>Net Sales</th>
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
    '/admin-assets/app/js/lib-tools.js',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>

    $(document).ready(function(){

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
    });

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
            data: function(d) {
                d.pagination = {perpage: 50};
                d._csrfToken = '<?= $this->request->getParam('_csrfToken'); ?>';
                d.date = Math.random();
                d.date_range = $("#date_range").val();
                d.branch_id = $("#branch_id").val();
                d.report_type = $("#report_type").val();
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
            {data: 'total'},
            {data: 'gross_sales'},
            {data: 'use_voucher'},
            {data: 'net_sales'},
        ],
        //
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return row.name;
                }
            },
            {
                targets: 1,
                className: 'text-right',
                orderable: false,
                render: function (data, type, row, meta) {
                    return parseInt(row.total).format(0, 3, ',', '.');
                }
            },
            {
                targets: 2,
                className: 'text-right',
                orderable: false,
                render: function (data, type, row, meta) {
                    return parseInt(row.gross_sales).format(0, 3, ',', '.');
                }
            },
            {
                targets: 3,
                className: 'text-right',
                orderable: false,
                render: function (data, type, row, meta) {
                    return row.use_voucher ? parseInt(row.use_voucher).format(0, 3, ',', '.') : 0;
                }
            },
            {
                targets: 4,
                className: 'text-right',
                orderable: false,
                render: function (data, type, row, meta) {
                    return parseInt(row.net_sales).format(0, 3, ',', '.');
                }
            },

        ]

    });



    $('#m_search').on('click', function(e) {
        e.preventDefault();
        $( datatable.column(0).header()).text( $("#report_type option:selected").text() );
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



