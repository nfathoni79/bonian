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
                                <?= __('Top Purchased Products') ?>
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
                            <?= __('Top Purchased Products') ?>
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
                                    <input type="text" class="form-control m-input" name="start" value="<?= $start; ?>" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="end" value="<?= $end;?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2" style="width: 210px;">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-md-4">Limit</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="limit" style="width:85%;"  value="<?= $this->request->getQuery('limit', 10);?>" />
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
            <div class="col-lg-6">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Top Purchased Products By Category') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div id="m_amcharts_13" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Top Purchased Products By Brand') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div id="m_amcharts_14" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Top Purchased Products By Period') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div id="m_amcharts_15" style="height: 500px;"></div>
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

    $(document).ready(function(){
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



        var chart = AmCharts.makeChart("m_amcharts_13", {
            "type": "pie",
            "theme": "light",
            "dataProvider": [],
            "valueField": "size",
            "titleField": "sector",
            "startDuration": 0,
            "innerRadius": 80,
            "pullOutRadius": 20,
            "marginTop": 30,
            "titles": [{
                "text": "Top Purchased Products By Category"
            }],
            "allLabels_": [{
                "y": "49%",
                "align": "center",
                "size": 15,
                "text": "2018-10-17 \n To ",
                "color": "#555"
            }, {
                "y": "55%",
                "align": "center",
                "size": 15,
                "text": "2019-03-29",
                "color": "#555"
            }],
            "listeners": [{
                "event": "init",
                "method": function(e) {
                    var chart = e.chart;

                    chart.animateData(<?= json_encode($by_categories); ?>, {
                        duration: 1000,
                        complete: function() {

                        }
                    });


                }
            }],
            "export": {
                "enabled": true
            }
        });

        AmCharts.makeChart("m_amcharts_14", {
            "type": "pie",
            "theme": "light",
            "dataProvider": [],
            "valueField": "size",
            "titleField": "sector",
            "startDuration": 0,
            "innerRadius": 80,
            "pullOutRadius": 20,
            "marginTop": 30,
            "titles": [{
                "text": "Top Purchased Products By Brand"
            }],
            "allLabels_": [{
                "y": "49%",
                "align": "center",
                "size": 15,
                "text": "2018-10-17 \n To ",
                "color": "#555"
            }, {
                "y": "55%",
                "align": "center",
                "size": 15,
                "text": "2019-03-29",
                "color": "#555"
            }],
            "listeners": [{
                "event": "init",
                "method": function(e) {
                    var chart = e.chart;

                    chart.animateData(<?= json_encode($by_brands); ?>, {
                        duration: 1000,
                        complete: function() {

                        }
                    });


                }
            }],
            "export": {
                "enabled": true
            }
        });


        //"dataProvider": <?= json_encode($by_periods); ?>,
        var chart = AmCharts.makeChart( "m_amcharts_15", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "autoMargins": false,
                "borderAlpha": 0.2,
                "equalWidths": false,
                "horizontalGap": 10,
                "markerSize": 10,
                "useGraphSettings": true,
                "valueAlign": "left",
                "valueWidth": 0
            },
            "dataProvider": <?= json_encode($by_periods); ?>,
            "valueAxes": [{
                "stackType": "100%",
                "axisAlpha": 0,
                "gridAlpha": 0,
                "labelsEnabled": false,
                "position": "left"
            }],
            "graphs": [
                <?php foreach($list_of_products as $product_id => $product_name) : ?>
                {
                    "balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
                    "fillAlphas": 0.9,
                    "fontSize": 11,
                    "labelText": "[[percents]]%",
                    "lineAlpha": 0.5,
                    "title": "<?= $product_name; ?>",
                    "type": "column",
                    "valueField": "<?= $product_id; ?>"
                },
                <?php endforeach; ?>
            ],
            "marginTop": 30,
            "marginRight": 0,
            "marginLeft": 0,
            "marginBottom": 40,
            "autoMargins": false,
            "categoryField": "name",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "gridAlpha": 0
            },
            "export": {
                "enabled": true
            }

        } );



    });


</script>
<?php $this->end(); ?>



