<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $products
 * nevix
 */
?>
<!-- <div class="m-list-pics m-list-pics--sm m--padding-left-20" style="width:110px;">
    <a href="#"><img src="/zolaku/images/50x50/fb0182b9a6eb45a5a10a8eb5e64b359e.jpg" title=""></a>
    <a href="#"><img src="/zolaku/images/50x50/fb0182b9a6eb45a5a10a8eb5e64b359e.jpg" title=""></a>
    <a href="#"><img src="/zolaku/images/50x50/fb0182b9a6eb45a5a10a8eb5e64b359e.jpg" title=""></a>

</div> -->
<!--begin::Modal-->
<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('Products',['action' => 'import','class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form','type' => 'file']); ?>

                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-4">Cari FIle</label>
                    <div class="col-lg-8">
                        <?php
                             echo $this->Form->control('files',['class' => 'form-control', 'type' => 'file','div' => false, 'label' => false,]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <?= $this->Form->submit(__('Import'),['class' => 'btn btn-brand']) ?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Products') ?>
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
                                <?= __('Products') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Products') ?>
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
                            <?= __('List Products') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_modal_1">
                                <span>
                                    <i class="la la-upload"></i>
                                    <span><?= __('Import Product') ?></span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build('/files/csv/product.csv'); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-download"></i>
                                    <span><?= __('Contoh CSV Product') ?></span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span><?= __('New Product') ?></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-8">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m_datatable" id="table-productss"></div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="titleModal"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body contentModal">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $this->append('script'); ?>
<?php
echo $this->Html->script([
            '/admin-assets/app/js/lib-tools.js',
    ]);
?>
<script>

    function delete_data(id) {
        $.post( "<?= $this->Url->build(['action' => 'delete']); ?>/" + id, { _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>' } )
            .done(function( data ) {
                location.href = '<?= $this->Url->build();?>';
            });
    }

    function view_data(id) {
        $('#modalView').modal('show');
        $('.titleModal').html('Provinces View');
        $('.contentModal').load( "<?= $this->Url->build(['action' => 'view']); ?>/" + id);
    }

    var DatatableRemoteAjaxDemo = function() {
        var demo = function() {
            var datatable = $('#table-productss').mDatatable({
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method: 'POST',
                            url: '<?= $this->Url->build(); ?>',
                            cache: false,
                            params: {
                                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
                            },
                            map: function(raw) {
                                var dataSet = raw;
                                if (typeof raw.data !== 'undefined') {
                                    dataSet = raw.data;
                                }
                                return dataSet;
                            },
                        },
                    },
                    pageSize: 10,
                    serverPaging: true,
                    serverFiltering: true,
                    serverSorting: true,
                },
                layout: {
                    scroll: true,
                    height: 550,
                    footer: false
                },
                sortable: true,
                pagination: true,
                toolbar: {
                    items: {
                        pagination: {
                            pageSizeSelect: [10, 20, 30, 50, 100],
                        },
                    },
                },
                search: {
                    input: $('#generalSearch'),
                },
                order: [[ 0, "desc" ]],
                columns: [
                    {
                        field: 'id',
                        title: '#',
                        sortable: false,
                        width: 40,
                        selector: false,
                        textAlign: 'center',
                        template: function(row, index, datatable) {
                            var p = datatable.getPageSize();
                            var c = (datatable.getCurrentPage() - 1) * p;
                            return (index + 1) + c;
                        }
                    },
                    {
                        field: '#',
                        title: 'Image',
                        sortable: false,
                        template: function(row) {
                            // return row.name;
                            var primary_image = '<a href="<?= $this->Url->build(['action' => 'edit']); ?>/'+ row.id +'"><img src="<?= $this->Url->build('/admin-assets/app/media/img/products/no-image.png');?>" style="width: 50px;" /></a>';
                            if (typeof row.product_images != 'undefined' && row.product_images.length > 0) {
                                primary_image = row.product_images[0].name;
                                for(var i in row.product_images) {
                                    if (row.product_images[i].primary === 1) {
                                        primary_image = row.product_images[i].name;
                                    }
                                }
                                primary_image = '<a href="<?= $this->Url->build(['action' => 'edit']); ?>/'+ row.id +'"><img src="<?= $this->Url->build('/images/50x50/');?>' + primary_image + '" style="width: 50px;" /></a>';
                            }
                            return primary_image;
                        }
                    },
                    {
                        field: 'Products.name',
                        title: 'Name',
                        template: function(row) {
                            return row.name;
                        }
                    },

                    {
                        field: 'Products.sku',
                        title: 'SKU',
                        template: function(row) {
                            return row.sku;
                        }
                    },

                    /*{
                        field: 'Products.qty',
                        title: 'Qty',
                        template: function(row) {
                            return row.qty;
                        }
                    },*/

                    {
                        field: 'ProductStockStatuses.name',
                        title: 'Stock Status',
                        template: function(row) {
                            var status = {
                                1: {'class': 'm-badge--success'},
                                2: {'class': ' m-badge--danger'},
                            };
                            return '<span class="m-badge ' + status[row.product_stock_status_id].class + ' m-badge--wide">' + row.product_stock_status.name + '</span>';
                        }
                    },


                    {
                        field: 'Products.price',
                        title: 'Harga Reguler',
                        template: function(row) {
                            return parseInt(row.price).format(0, 3, '.', ',');
                        }
                    },

                    {
                        field: 'Products.price_sale',
                        title: 'Harga Jual',
                        template: function(row) {
                            return parseInt(row.price_sale).format(0, 3, '.', ',');
                        }
                    },
                    {
                        field: 'ProductStatuses.name',
                        title: 'Publish Status',
                        template: function(row) {

                            var status = {
                                1: {'class': 'm-badge--success'},
                                2: {'class': ' m-badge--danger'},
                            };
                            return '<span class="m-badge ' + status[row.product_status_id].class + ' m-badge--wide">' + row.product_status.name + '</span>';
                        }
                    },

                    {
                        field: 'Products.view',
                        title: 'View',
                        template: function(row) {
                            return row.view;
                        }
                    },

                    {
                        field: 'Products.created',
                        title: 'Creation',
                        template: function(row) {
                            return row.created;
                        }
                    },

                    /** Action button **/
                    {
                        field: "Actions",
                        width: 110,
                        title: "Actions",
                        sortable: false,
                        overflow: 'visible',
                        template: function (row, index, datatable) {
                            return '<a href="javascript:view_data('+row.id+');" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="VIew"><i class="la la-eye"></i></a><a href="<?= $this->Url->build(['action' => 'edit']); ?>/'+ row.id +'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a><a href="javascript:delete_data('+row.id+');" onclick="return confirm(\'Are you sure delete #'+row.id+'\');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
                        }
                    }
                ]
            });
            var query = datatable.getDataSourceQuery();

        };
        return {
            init: function() {
                demo();
            },
        };
    }();

    jQuery(document).ready(function() {
        DatatableRemoteAjaxDemo.init();
    });
</script>
<?php $this->end(); ?>



