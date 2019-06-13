<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $banner
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
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Banner') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Tambah Banner') ?>
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
                            <?= __('Tambah Banner') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($banner,['class' => 'm-form m-form--label-align-left', 'id' => 'form-banner','type' => 'file']); ?>

            <div class="m-portlet__body">
                <?php
                    echo $this->Flash->render();
                    $default_class = 'form-control m-input';
                ?>
                <div class="m-form__section m-form__section--first">
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Kategori </label>
                        <div class="col-lg-4">
                            <?php echo $this->Form->control('product_category_id', ['label' => false, 'div' => false, 'options' => $productCategories, 'empty' => 'Pilih Kategori', 'class' => $default_class]);?>
                            <span class="m-form__help">Non Mandatory, Jika pilihan kategory di pilih maka banner akan di tampilkan pada produk list banner berdasarkan kategory.</span>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Posisi </label>
                        <div class="col-lg-4">
                            <?php
                                 echo $this->Form->control('position', ['options' => [
                                    'Home Top' => 'Home Top',
                                    'Home Bottom Left' => 'Home Bottom Left',
                                    'Home Bottom Right' => 'Home Bottom Right',
                                    'Product List By Category' => 'Product List By Category',
                                    'Flash Sale' => 'Flash Sale',
                                ], 'empty' => 'Pilih Posisi', 'label' => false, 'required' => false, 'div' => false, 'class' => $default_class]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Url Action </label>
                        <div class="col-lg-4">
                            <?php
                                echo $this->Form->control('url', ['label' => false, 'div' => false,'empty' => true, 'required' => false, 'class' => $default_class]);
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <a href="javascript:void(0);" class="btn btn-info m-btn m-btn--icon"  data-toggle="modal" data-target="#m_modal_1">
                                <i class="la la-list-alt"></i> Pick Content
                            </a>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Gambar Banner </label>
                        <div class="col-lg-4">
                            <?php
                                echo $this->Form->control('name', ['label' => false, 'div' => false,'type' => 'file','empty' => true, 'required' => false, 'class' => $default_class]);
                            ?>
                            <span class="m-form__help">Minimum demention size : 796x235 px</span>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label">Status </label>
                        <div class="col-lg-1">
                            <?php
                                echo $this->Form->control('status', ['label' => false, 'div' => false, 'options' => [0 => 'Off', 1 => 'On' ], 'required' => false, 'class' => $default_class]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-10 ml-lg-auto">
                            <?= $this->Form->submit(__('Submit'),['class' => 'btn btn-brand']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Konten Promosi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs  m-tabs-line" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link produk active" data-toggle="tab" href="#Produk" role="tab" data-content="produk">Produk</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link voucher" data-toggle="tab" href="#Voucher" role="tab" data-content="voucher">Voucher</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="Produk" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table-produk">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nama Produk</th>
                                    <th>SKU</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="Voucher" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table-voucher">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tipe Voucher</th>
                                    <th>Nama Voucher</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
'/admin-assets/vendors/custom/libs/validation-render',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>

    function picked(url) {
        $('#url').val(url);
        $('#m_modal_1').modal('hide');
    }

    $(document).ready(function () {
        var select = $('#product-category-id').val();
        if(select){
            $('#position').val("Product List By Category");
            $('#position').prop('disabled', true);
        }else{
            $('#position').val("");
            $('#position').prop('disabled', false);
        }

        $('#product-category-id').on('change',function(){
            var selected = $(this).val();
            if(selected){
                $('#position').val("Product List By Category");
                $('#position').prop('disabled', true);
            }else{
                $('#position').val("");
                $('#position').prop('disabled', false);
            }
        })

        $(window).on('shown.bs.modal', function() {
            $('.active').trigger('click');


        });


        $('.nav-link').on('click',function(){


            var content = $(this).data('content');
            if(content == 'voucher'){
                var url = "<?= $this->Url->build(['controller' => 'Vouchers','action' => 'picker']); ?>";

                $('#table-voucher').DataTable({

                    "bDestroy": true,
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: {
                        url: url,
                        type: 'POST',
                        data: {
                            pagination: {
                                perpage: 50,
                            },
                            _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
                        },
                    },
                    initComplete: function(settings, json) {

                    },
                    columns: [
                        {data: 'id'},
                        {data: 'type_text'},
                        {data: 'name'},
                    ],
                    columnDefs: [
                        {
                            targets: 3,
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:picked(\'/promotion/'+row.slug+'\');" class="m-portlet__nav-link btn btn-sm btn-primary " title="Pick">Pilih</a>';
                            }
                        },
                    ]

                });
            }else if(content == 'produk'){
                var url = "<?= $this->Url->build(['controller' => 'Products','action' => 'indexpick']); ?>";

                $('#table-produk').DataTable({

                    "bDestroy": true,
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: {
                        url: url,
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
                    ],
                    columnDefs: [
                        {
                            targets: 3,
                            render: function (data, type, row, meta) {
                                return '<a href="javascript:picked(\'/products/detail/'+row.slug+'\');" class="m-portlet__nav-link btn btn-sm btn-primary " title="Pick">Pilih</a>';
                            }
                        },
                    ]

                });
            }

        });
    })
</script>
<?php $this->end(); ?>
