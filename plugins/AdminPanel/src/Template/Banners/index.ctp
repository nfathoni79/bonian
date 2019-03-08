<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $banners
 * nevix
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Banners') ?>
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
                                <?= __('Banners') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Banners') ?>
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
                            <?= __('Daftar Banners') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span><?= __('Tambah Banner') ?></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>

                <div class="m_datatable">
                    <?= $this->Form->create(null,['url' => 'validate','class' => 'm-form m-form--fit m-form--label-align-right','id' => 'frm-example']); ?>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="table-banners">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Kategori</th>
                            <th>Posisi</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                    </table>
                    <button class="btn m-btn m-btn--gradient-from-primary m-btn--gradient-to-info mt-5">Simpan</button></p>
                    <?= $this->Form->end();?>
                </div>

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

<?php
$this->Html->css([
'/admin-assets/vendors/custom/datatables/datatables.bundle.css'
], ['block' => true]);
$this->Html->script([
'/admin-assets/vendors/custom/datatables/datatables.bundle',
'/admin-assets/vendors/custom/libs/validation-render',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>

    function delete_data(id) {
        location.href = '<?= $this->Url->build(['action' => 'delete']);?>/'+ id;
    }
    // begin first table
    var table = $('#table-banners').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= $this->Url->build(['action' => 'index']); ?>",
            type: 'POST',
            data: {
                pagination: {
                    perpage: 50,
                },
                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
            },
        },
        headerCallback: function(thead, data, start, end, display) {
            thead.getElementsByTagName('th')[0].innerHTML = `
                    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                        <input type="checkbox" value="" class="m-group-checkable">
                        <span></span>
                    </label>`;
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'product_category_id'},
            {data: 'position'},
            {data: 'type'},
            {data: 'status'},
            {data: 'id'},
        ],
        columnDefs: [
            {
                orderable: false,
                targets: 0,
                width: "5%",
                render: function (data, type, row, meta) {
                    return '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">\n' +
                        '<input type="checkbox" name="Banners['+row.id+'][id]" value="'+row.id+'" class="m-checkable" >\n' +
                        '<span></span>\n' +
                        '</label>';
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return '<img src="<?= $this->Url->build('/files/Banners/name/');?>' + row.name + '" style="width: 250px;" />';
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    if(row.product_category){
                        return row.product_category.name;
                    }else{
                        return '-';
                    }
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    var status = {
                        '0': 'OFF',
                        '1': 'ON',
                    };
                    var renderOpt = '<div class="form-group m-form__group row"><div class="col-xl-12"><select name="Banners['+row.id+'][status]" class="form-control">';
                    $.each(status, function(k,v){
                        if(k == row.status){
                            renderOpt += '<option value="'+k+'" selected="selected">'+v+'</option>';
                        }else{
                            renderOpt += '<option value="'+k+'">'+v+'</option>';
                        }
                    });
                    renderOpt += '</select></div></div>';
                    return renderOpt;
                }
            },
            {
                targets: 6,
                render: function (data, type, row, meta) {
                    return '<a href="javascript:delete_data('+row.id+');" onclick="return confirm(\'Are you sure delete #'+row.id+'\');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
                }
            },
        ],
    });

    table.on('change', '.m-group-checkable', function() {
        var set = $(this).closest('table').find('td:first-child .m-checkable');
        var checked = $(this).is(':checked');

        $(set).each(function() {
            if (checked) {
                $(this).prop('checked', true);
                $(this).closest('tr').addClass('active');
            }
            else {
                $(this).prop('checked', false);
                $(this).closest('tr').removeClass('active');
            }
        });
    });

    table.on('change', 'tbody tr .m-checkbox', function() {
        $(this).parents('tr').toggleClass('active');
    });


    $('#frm-example').on('submit', function(e){
        // Prevent actual form submission
        e.preventDefault();

        var formEl = $("#frm-example");

        // $('input[type="hidden"]', formEl).remove();

        var ajaxRequest = new ajaxValidation(formEl);
        ajaxRequest.setblockUI('.m-portlet__body');
        var datax = formEl.find(':input','input.numberinput, input.m-checkable, select');
        // var datax = table.$('input,select,textarea');
        ajaxRequest.post("<?= $this->Url->build(['action' => 'validate']); ?>", datax, function(data, saved) {
            if (data.success) {
                location.href = '';
            }
        });
    });
</script>
<?php $this->end(); ?>



