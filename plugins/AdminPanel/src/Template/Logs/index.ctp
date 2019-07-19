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
                    <?= __('Log Aktifitas') ?>
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
                                <?= __('Log Aktifitas') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Aktifitas') ?>
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
                            <?= __('Periode Aktifitas') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>

                <!--begin: Search Form -->
                <form class="form-inline m-form m-form--fit m--margin-bottom-20">
                    <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                        <div class='input-group ' id='m_daterangepicker_6'>
                            <input type='text' name="date_range" value="<?= $start; ?> / <?= $end; ?>" class="form-control m-input" readonly placeholder="Select date range" id="date_range" />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <button class="btn btn-brand m-btn m-btn--icon" id="m_search">
                            <span>
                                <i class="la la-search"></i>
                                <span>Filter Date Periode</span>
                            </span>
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <?= __('Daftar Aktifitas') ?>
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

                <div class="m_datatable" >
                    <form  id="frm-example" method="POST">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="table-logs">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Message</th>
                                <th>Sebelum</th>
                                <th>Sesudah</th>
                            </tr>
                            </thead>
                        </table>
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
    // begin first table
    var table = $('#table-logs').DataTable({
        responsive: true,

        buttons: [
            'print',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: {
            url: "<?= $this->Url->build(['action' => 'index']); ?>",
            type: 'POST',
            data: function(d) {
                d.pagination = {perpage: 50};
                d._csrfToken = '<?= $this->request->getParam('_csrfToken'); ?>';
                d.date_range = $("#date_range").val();
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
            {data: 'created_at'},
            {data: 'issuer_id'},
            {data: 'action'},
            {data: 'data'},
            {data: 'data'},
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return row.created_at;
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return row.user ? row.user.first_name : 'System auto update';
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return row.message;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    var text = JSON.parse(row.data);
                    var message = '';
                    $.each(text.before, function(k,v){
                        message += 'Kolom "'+k+'" : '+v+', ' ;
                    })
                    return message;
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    var text = JSON.parse(row.data);
                    var message = '';
                    $.each(text.after, function(k,v){
                        message += 'Kolom "'+k+'" : '+v+', ' ;
                    })
                    return message;
                }
            },
        ],
    });

    $('#m_search').on('click', function(e) {
        e.preventDefault();
        $( table.column(0).header()).text( $("#report_type option:selected").text() );
        table.table().draw();
    });

    $('#m_reset').on('click', function(e) {
        e.preventDefault();
        $('.m-input').each(function() {
            $(this).val('');
        });
        table.table().draw();
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



