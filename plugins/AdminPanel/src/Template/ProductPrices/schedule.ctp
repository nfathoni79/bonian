<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $brands
 * nevix
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Manajemen Harga') ?>
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
                                <?= __('Manajemen Harga') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Schedule Perubahan Harga') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'schedule']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Schedule Perubahan Harga') ?>
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
                            <?= __('Daftar Schedule Perubahan Harga') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>

                <div class="m_datatable" >
                    <table class="table table-striped table-bordered table-hover table-checkable" id="table-schedule">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Aksi</th>
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
'/admin-assets/vendors/custom/libs/validation-render',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>

    // begin first table
    var table = $('#table-schedule').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= $this->Url->build(['action' => 'schedule']); ?>",
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
            {data: 'schedule'},
            {data: 'user.first_name'},
            {data: 'status'},
            {data: 'id'},
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    var status = {
                        0: {'title': 'Pending', 'class': 'm-badge--brand'},
                        1: {'title': 'Success', 'class': ' m-badge--success'},
                        2: {'title': 'Canceled', 'class': ' m-badge--danger'}
                    };
                    return '<span class="m-badge ' + status[row.status].class + ' m-badge--wide">' + status[row.status].title + '</span>';
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    var btnTmp = '<a class="btn btn-info btn-sm" href="<?= $this->Url->build(['action' => 'preview']); ?>/'+row.id+'"><i class="la la-eye"></i> Pratinjau Data Perubahan</a> ';
                    if(row.status == '0'){
                        btnTmp += '<a class="btn btn-danger btn-sm" href="<?= $this->Url->build(['action' => 'cancel']); ?>/'+row.id+'"><i class="la la-times"></i> Batalkan</a>';
                    }
                    return btnTmp;
                }
            },
        ],
    });




</script>
<?php $this->end(); ?>



