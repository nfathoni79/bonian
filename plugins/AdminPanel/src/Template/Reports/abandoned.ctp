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
                                <?= __('Abandoned Cart Report') ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="m-content">


        <!--Begin::Section-->
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">



                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-5">

                        <!--begin:: Widgets/Stats2-1 -->
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">Abandoned Revenue</h3>
                                        <span class="m-widget1__desc">total of the revenue from all abandoned carts </span>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">IDR <?php echo $this->Number->precision($abandoneReveneu, 2);?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">Abandoned Carts</h3>
                                        <span class="m-widget1__desc">total of carts that did not result in an order.</span>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand"><?php echo $abandonedCart;?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">Abandon Rate</h3>
                                        <span class="m-widget1__desc">percentage of all carts that were abandoned</span>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand"><?php echo $this->Number->toPercentage($abandoneRate);?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">Orders</h3>
                                        <span class="m-widget1__desc">number of unique completed orders</span>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand"><?php echo $countOrders;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end:: Widgets/Stats2-1 -->
                    </div>
                    <div class="col-xl-7">

                        <!--begin:: Widgets/Daily Sales-->
                        <div class="m-widget14">
                            <div class="m-widget14__header m--margin-bottom-30">
                                <h3 class="m-widget14__title">
                                    Abandon Rate
                                </h3>
                                <span class="m-widget14__desc">
                                    Periode <?php echo $datestart;?> / <?php echo $dateend;?>
                                </span>
                            </div>

                            <form class="form-inline m-form m-form--fit m--margin-bottom-20">
                                <div class="form-group mb-2">
                                    <div class="form-group m-form__group row">
                                        <label class="col-form-label col-md-3">Periode Filter</label>
                                        <div class="col-md-9">
                                            <div class="input-daterange input-group" id="m_datepicker_5">
                                                <input type="text" class="form-control m-input" name="start" value="<?= $datestart;?>" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="end" value="<?= $dateend;?>" />
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

                            <div class="m-widget14__chart">
                                <div id="m_morris_2" style="height:250px;"></div>
                            </div>
                        </div>

                        <!--end:: Widgets/Daily Sales-->
                    </div>
                </div>
            </div>
        </div>


        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <?= __('Abandoned Cart Report') ?>
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

                <div class="m_datatable">

                    <table class="table table-striped- table-bordered table-hover table-checkable" id="table-abandoned">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Abandoned Carts</th>
                            <th>Abandoned Revenue</th>
                            <th>Abandoned Rate</th>
                            <th>Visits</th>
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
<?php
echo $this->Html->script([
'/admin-assets/app/js/lib-tools.js',
]);
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
    });

    // AREA CHART
    new Morris.Area({
        element: 'm_morris_2',
        data: <?php echo json_encode($newList);?>,
        xkey: 'date',
        ykeys: ['value'],
        labels: ['In percent (%)']
    });


    var datatable = $('#table-abandoned').DataTable({

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
            url: "<?= $this->Url->build(['action' => 'abandoned']); ?>",
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
            // {data: 'Customers.name'},
            // {data: 'rating'},
            // {data: 'comment'},
            // {data: 'created'},
            // {data: 'status'},
            // {data: 'id'},
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return row.product.name;
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return row.product.sku;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return row.abandoned_cart;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return parseInt(row.abandoned_revenue).format(0, 3, '.', ',');
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    return row.abandoned_rate+'%';
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    return row.product.view;
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



