<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title">
                    Diskusi Produk
                </h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-xl-12">

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
                                <table class="table table-striped table-bordered table-hover table-checkable" id="table-discuss">
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

<?php $this->append('script'); ?>
<script>


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
            {data: 'Product.id'},
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
                    return '<a href="<?= $this->Url->build($_baseFront .'products/detail/' );?>'+row.product.slug+'" target="_blank">'+row.product.name+'</a>';
                }
            },
            {
                targets: 2,
                orderable: false,
                render: function (data, type, row, meta) {
                    if(row.count_unread > 0){
                        return '<a href="<?= $this->Url->build(['action' => 'detail']);?>/'+row.product.id+'" class="btn btn-outline-danger m-btn btn-sm  m-btn--icon m-btn--pill">\n' +
                            '<span>\n' +
                            '<i class="fa flaticon-alert"></i>\n' +
                            '<span>'+row.count_unread+' Komentar baru</span>\n' +
                            '</span>\n' +
                            '</a>';
                    }else{
                        return '';
                    }
                }
            },
        ]

    });
</script>
<?php $this->end(); ?>


