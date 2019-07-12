<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $productCoupons
 * nevix
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Promosi Penjualan') ?>
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
                                <?= __('Promosi Penjualan') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Coupons') ?>
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
                            <?= __('Daftar Coupons') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air"  data-toggle="modal" data-target="#modalView"><span><i class="la la-plus"></i><span><?= __('Tambah Coupon') ?></span></span></a>
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

                <div class="m_datatable" id="table-productCoupons"></div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('ProductCoupon',['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form', 'id' => 'form-coupon']); ?>

                <?php
                   echo $this->Form->control('product_id',['type' => 'hidden','div' => false, 'label' => false, 'class' => 'form-control']);
                ?>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-4">Nama Produk</label>
                    <div class="col-lg-8">
                        <div class="m-typeahead">
                            <?php
                             echo $this->Form->control('name',['type' => 'text', 'div' => false, 'label' => false, 'class' => 'form-control form-control-danger m-input m-input--air k_typeahead', 'dir' => 'ltr',   'placeholder' => 'Pencarian Produk']);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-4">Jumlah Potongan</label>
                    <div class="col-lg-6">
                        <?php
                            echo $this->Form->control('sku',['type' => 'hidden']);
                        ?>
                        <?php
                             echo $this->Form->control('price',['type' => 'number','div' => false, 'label' => false, 'class' => 'form-control' ]);
                        ?>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-4">Tanggal Kadaluarsa</label>
                    <div class="col-lg-6">
                        <?php
                             echo $this->Form->control('expired',['div' => false, 'label' => false, 'class' => 'form-control', 'id' => 'm_datepicker', 'readonly' => 'readonly', 'placeholder' => 'Select date']);
                        ?>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-4">Status</label>
                    <div class="col-lg-2">
                        <?php
                             echo $this->Form->control('status',['type' => 'select','div' => false, 'label' => false, 'class' => 'form-control', 'options' => ['1' => 'On', '2' => 'Off']]);
                        ?>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-4">Notifikasi?</label>
                    <div class="col-lg-6 m-form__group-sub">
                        <div class="m-checkbox-inline">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                <input type="checkbox" name="notif" value="1"> Kirim sebagai pesan notifikasi <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <?= $this->Form->submit(__('Tambahkan'),['class' => 'btn btn-brand']) ?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<?php $this->append('script'); ?>
<?php
echo $this->Html->script([
'/admin-assets/vendors/custom/libs/validation-render',
'/admin-assets/app/js/lib-tools.js',
]);
?>
<script>

    var formEl = $("#form-coupon");
    var url = '<?= $this->Url->build(['action' => 'validateAjax']); ?>';
    var ajaxRequest = new ajaxValidation(formEl);
    ajaxRequest.setblockUI('.modal-body');


    $("#form-coupon").submit(function(e) {
        ajaxRequest.post(url, formEl.find(':input'), function(data,saved) {
            if (data.success) {
                location.reload();
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    $('#m_datepicker').datepicker({
        startDate: '-0d',
        todayHighlight: true,
        autoclose: true,
        pickerPosition: 'bottom-left',
        format: 'yyyy-mm-dd',
    });


    function init(rows) {
        rows = rows || '';
        var productLists = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?= $this->Url->build(['action' => 'productExist']); ?>'
            remote: {
                wildcard: '%QUERY',
                url: '<?= $this->Url->build(['action' => 'productExist']); ?>',
                prepare: function(query, setting) {
                    // setting.url += '?search=' + encodeURI(query) + '&exl=' + PopulateProductLists();
                    setting.url += '?search=' + encodeURI(query) ;
                    return setting;
                }
            }
        });
        //productLists.clearPrefetchCache();
        productLists.initialize();

        $('.k_typeahead').typeahead(null, {
            display: 'name',
            source: productLists.ttAdapter(),
            templates: {
                empty: [
                    '<div class="empty-message" style="padding: 10px 15px; text-align: center;">',
                    'Produk tidak ditemukan dalam daftar produk',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div><strong>{{name}}</strong> (SKU:{{sku}})</div>')
            },
        });

        $('.k_typeahead').on('typeahead:select', function(evt, item) {
            $("#product-id").val(item.id)
            $("#sku").val(item.sku)
            console.log(item);
        })
    }
    init();




    function delete_data(id) {
        $.post( "<?= $this->Url->build(['action' => 'delete']); ?>/" + id, { _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>' } )
            .done(function( data ) {
                location.href = '<?= $this->Url->build();?>';
            });
    }

    var DatatableRemoteAjaxDemo = function() {
        var demo = function() {
            var datatable = $('#table-productCoupons').mDatatable({
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
                        sortable: true,
                        width: 40,
                        selector: false,
                        textAlign: 'center',
                        template: function(row, index, datatable) {
                            return ++index;
                        }
                    },
                    {
                        field: 'Products.name',
                        title: 'Nama Produk',
                        template: function(row) {
                            return row.product.name;
                        }
                    },

                    {
                        field: 'ProductCoupons.price',
                        title: 'Jumlah Potongan',
                        template: function(row) {
                            return parseInt(row.price).format(0, 3, '.', ',');
                        }
                    },

                    {
                        field: 'ProductCoupons.expired',
                        title: 'Kadaluarsa',
                        template: function(row) {
                            return row.expired;
                        }
                    },

                    {
                        field: 'ProductCoupons.status',
                        title: 'Status',
                        template: function(row) {
                            var status = {
                                1: {'title': 'ON','class': 'm-badge--success'},
                                2: {'title': 'OFF','class': ' m-badge--danger'},
                            };
                            return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
                        }
                    },

                    {
                        field: 'ProductCoupons.created',
                        title: 'Tanggal',
                        template: function(row) {
                            return row.created;
                        }
                    },

                    /** Action button **/
                    {
                        field: "Actions",
                        width: 110,
                        title: "Aksi",
                        sortable: false,
                        overflow: 'visible',
                        template: function (row, index, datatable) {
                            return '<a href="javascript:delete_data('+row.id+');" onclick="return confirm(\'Are you sure delete #'+row.product.name+'\');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
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



