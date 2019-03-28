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
                        <a href="<?= $this->Url->build(['action' => 'abandoned']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Best View Product Report') ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="m-content">

        <?= $this->Flash->render() ?>
        <div class="row">
            <div class="col-xl-6">

                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Top 10 Best View Product') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div id="m_amcharts_12" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Top Best View Product') ?>
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
                        <div class="m_datatable">

                            <table class="table table-striped- table-bordered table-hover table-checkable" id="table-best-view">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>SKU</th>
                                    <th>Model</th>
                                    <th>Viewed</th>
                                    <th>Percent</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<?php
$this->Html->css([
    '/admin-assets/vendors/custom/datatables/datatables.bundle.css',
    '/admin-assets/vendors/custom/amcharts/plugins/export/export.css'
], ['block' => true]);
$this->Html->script([
    '/admin-assets/vendors/custom/datatables/datatables.bundle',
    '/admin-assets/vendors/custom/amcharts/amcharts',
    '/admin-assets/vendors/custom/amcharts/serial',
    '/admin-assets/vendors/custom/amcharts/radar',
    '/admin-assets/vendors/custom/amcharts/pie',
    '/admin-assets/vendors/custom/amcharts/plugins/tools/polarScatter/polarScatter.min',
    '/admin-assets/vendors/custom/amcharts/plugins/animate/animate.min',
    '/admin-assets/vendors/custom/amcharts/plugins/export/export.min',
    '/admin-assets/vendors/custom/amcharts/themes/light.js',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>

    var chart = AmCharts.makeChart("m_amcharts_12", {
        "type": "pie",
        "theme": "light",
        "dataProvider": <?php echo json_encode($products);?>,
        "valueField": "view",
        "titleField": "name",
        "balloon": {
            "fixedPosition": true
        },
        "export": {
            "enabled": true
        }
    });


    var datatable = $('#table-best-view').DataTable({

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
            url: "<?= $this->Url->build(['action' => 'bestView']); ?>",
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
            {data: 'name'},
            {data: 'sku'},
            {data: 'model'},
            {data: 'view'},
            // {data: 'percent'},
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return row.name;
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return row.sku;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return row.model;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return row.view;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    return row.percent;
                }
            },
        ]

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



