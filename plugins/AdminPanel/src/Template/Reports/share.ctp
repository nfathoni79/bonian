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
                        <a href="<?= $this->Url->build(['action' => 'share']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Share Statistik') ?>
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
                            <?= __('Share Statistik') ?>
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
                                    <input type="text" class="form-control" name="end"  autocomplete="off" value="<?= $this->request->getQuery('end');?>" />
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
            <div class="col-xl-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Share Statistik') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

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
            "title": "Total Share",
            "type": "column",
            "backgroundColor": "#3123123",
            "valueField": "plus"
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
</script>
<?php $this->end(); ?>



