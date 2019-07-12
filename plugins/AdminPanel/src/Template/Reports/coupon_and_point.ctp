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
                                <?= __('Coupon And Point Mutation Report') ?>
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
                            <?= __('Coupon And Point Mutation Report') ?>
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
                    <div class="form-group mb-2">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-md-3">Periode Filter</label>
                            <div class="col-md-9">
                                <div class="input-daterange input-group" id="m_datepicker_5">
                                    <input type="text" class="form-control m-input" name="start" autocomplete="off" value="<?= $this->request->getQuery('start'); ?>" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="end" autocomplete="off" value="<?= $this->request->getQuery('end');?>" />
                                </div>
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


        <div class="row">
            <div class="col-xl-6">

                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Coupon Summary Report') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div class="m_datatable">

                            <table class="table table-striped- table-bordered table-hover table-checkable" id="table-summary-coupon">
                                <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Item sales</th>
                                    <th>coupon</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Point Mutation Report') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="<?= $this->Url->build(['controller' => 'customers','action' => 'point']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-money"></i>
                                            <span><?= __('Pratinjau Mutasi Point') ?></span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div id="chartdiv"  style="height: 300px;"></div>

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
'/admin-assets/vendors/custom/amcharts/plugins/export/export.min',
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

    $('#m_datepicker_5').datepicker({
        rtl: mUtil.isRTL(),
        todayHighlight: true,
        templates: arrows,
        format: 'yyyy-mm-dd',
        orientation: "bottom",
    });

    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "none",
        "legend": {
            "horizontalGap": 10,
            "maxColumns": 1,
            "position": "bottom",
            "useGraphSettings": true,
            "markerSize": 10
        },
        "dataProvider": <?php echo json_encode($by_periods); ?>,
        "valueAxes": [{
            "stackType": "regular",
            "axisAlpha": 0.5,
            "gridAlpha": 0
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "Refund, Bonus Point, Bonus Point Generasi",
            "type": "column",
            "color": "#000000",
            "valueField": "plus"
        }, {
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 0.8,
            "labelText": "[[value]]",
            "lineAlpha": 0.3,
            "title": "Pembelanjaan, Pengurangan",
            "type": "column",
            "color": "#000000",
            "valueField": "minus"
        }],
        "rotate": true,
        "categoryField": "name",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "gridAlpha": 0,
            "position": "left"
        },
        "export": {
            "enabled": true
        }
    });

    var datatable = $('#table-summary-coupon').DataTable({

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
        //order: [[0, 'desc']],
        "ordering": false,
        "searching": false,
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
        columns: [
            {data: 'name'},
            {data: 'item_sales'},
            {data: 'coupon'}
            // {data: 'percent'},
        ],
        columnDefs: [
            {
                targets: 0,
                "orderable": false,
                render: function (data, type, row, meta) {
                    return row.name;
                }
            },
            {
                targets: 1,
                "orderable": false,
                render: function (data, type, row, meta) {
                    return row.item_sales;
                }
            },
            {
                targets: 2,
                "orderable": false,
                render: function (data, type, row, meta) {
                    return parseInt(row.coupon).format(0, 3, ',', '.');
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



