<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title">
                    Dashboard
                </h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon m--hide">
                                        <i class="la la-gear"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        Registration Chart
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div id="m_morris_2" style="height:500px;"></div>
                        </div>
                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->Html->script([
'/admin-assets/vendors/custom/charts/morris-charts.js'
], ['block' => true]);
?>

<?php $this->append('script'); ?>
<?php $bulan = json_encode(array_values($result), true);
//[{"y":"2019-01","a":0,"b":0},{"y":"2019-02","a":0,"b":0},{"y":"2019-03","a":1,"b":1},{"y":"2019-04","a":0,"b":0},{"y":"2019-05","a":0,"b":0},{"y":"2019-06","a":0,"b":0}]
?>
<script>

    var count = <?php echo $bulan; ?>;

    var MorrisChartsDemo= {
        init:function() {
            new Morris.Area( {
                element:"m_morris_2",
                data:count, xkey:"y", ykeys:["a","b"], labels:["Android", "Website"]
                }
            )
        }
    }

</script>
<?php $this->end(); ?>


