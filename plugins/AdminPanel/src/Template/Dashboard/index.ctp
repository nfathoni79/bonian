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
                <div class="col-xl-6">
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
                <div class="col-xl-6">

                    <div class="m-portlet m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Diskusi Produk
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m_datatable">
                                <table class="table table-striped table-hover table-checkable" id="table-discuss">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Nama Produk</th>
                                        <th>Komentar</th>
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

    var datatable = $('#table-discuss').DataTable({

        processing: true,
        serverSide: true,
        // order: [[0, 'desc']],
        bLengthChange: false,
        searching: false,
        ajax: {
            url: "<?= $this->Url->build(['controller' => 'ProductDiscussion', 'action' => 'index']); ?>",
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
            {data: 'Product.name'},
            // {data: 'rating'},
            // {data: 'comment'},
            // {data: 'created'},
            // {data: 'status'},
            // {data: 'id'},
        ],
        //
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                render: function (data, type, row, meta) {
                    var primary_image = '<img src="<?= $this->Url->build('/admin-assets/app/media/img/products/no-image.png');?>" style="width: 50px;" />';
                    if (typeof row.product.product_images != 'undefined' && row.product.product_images.length > 0) {
                        primary_image = row.product.product_images[0].name;
                        for(var i in row.product.product_images) {
                            if (row.product.product_images[i].primary === 1) {
                                primary_image = row.product.product_images[i].name;
                            }
                        }
                        primary_image = '<img src="<?= $this->Url->build('/images/50x50/');?>' + primary_image + '" style="width: 50px;" />';
                    }
                    return primary_image;
                }
            },
            {
                targets: 1,
                orderable: false,
                render: function (data, type, row, meta) {
                    return '<a href="<?= $this->Url->build($_baseFront .'/products/detail/' );?>'+row.product.slug+'" target="_blank">'+row.product.name+'</a>';
                }
            },
            {
                targets: 2,
                orderable: false,
                render: function (data, type, row, meta) {
                    if(row.count_unread > 0){
                        return '<a href="<?= $this->Url->build(['controller' => 'productDiscussion', 'action' => 'detail']);?>/'+row.product.id+'" class="btn btn-outline-danger m-btn btn-sm  m-btn--icon m-btn--pill">\n' +
                            '<span>\n' +
                            '<i class="fa flaticon-alert"></i>\n' +
                            '<span>'+row.count_unread+' Komentar baru</span>\n' +
                            '</span>\n' +
                            '</a>';
                    }else{
                        return '<a href="<?= $this->Url->build(['controller' => 'productDiscussion', 'action' => 'detail']);?>/'+row.product.id+'" class="btn btn-outline-danger m-btn btn-sm  m-btn--icon m-btn--pill">\n' +
                        '<span>\n' +
                        '<i class="fa fa-comment"></i>\n' +
                        '<span>Lihat diskusi</span>\n' +
                        '</span>\n' +
                        '</a>';
                    }
                }
            },
            // {
            //     targets: 2,
            //     orderable: false,
            //     render: function (data, type, row, meta) {
            //         return '<span class="stars" data-rating="'+row.rating+'" data-num-stars="5" ></span>';
            //     }
            // },
            // {
            //     targets: 3,
            //     render: function (data, type, row, meta) {
            //         return row.comment;
            //     }
            // },
            // {
            //     targets: 4,
            //     render: function (data, type, row, meta) {
            //         return row.modified;
            //     }
            // },
            // {
            //     targets: 5,
            //     render: function (data, type, row, meta) {
            //         var status = {
            //             0: {'title': 'Belum ada penilaian','classes': 'm-badge--danger'},
            //             1: {'title': 'Sudah diberikan penulaian','classes': ' m-badge--success'},
            //         };
            //         return '<span class="m-badge ' + status[row.status].classes + ' m-badge--wide">' + status[row.status].title + '</span>';
            //     }
            // },
            // {
            //     targets: 6,
            //     render: function (data, type, row, meta) {
            //         return '<a href="javascript:delete_data('+row.id+');" onclick="return confirm(\'Are you sure delete reviews #'+row.id+'\');" class="m-btn btn btn-danger btn-sm" title="Delete"><i class="la la-trash-o"></i> Hapus dari daftar reviews</a>';
            //     }
            // },
        ]

    });
</script>
<?php $this->end(); ?>


