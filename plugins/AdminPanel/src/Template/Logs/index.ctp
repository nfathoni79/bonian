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
                    <?= __('Log Aktifitas') ?>
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
                                <?= __('Log Aktifitas') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Aktifitas') ?>
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
                            <?= __('Daftar Aktifitas') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                Actions
                            </a>
                            <div class="m-dropdown__wrapper" style="z-index: 101;">
                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 36px;"></span>
                                <div class="m-dropdown__inner">
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__content">
                                            <ul class="m-nav">
                                                <li class="m-nav__section m-nav__section--first">
                                                    <span class="m-nav__section-text">Export Tools</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_print">
                                                        <i class="m-nav__link-icon la la-print"></i>
                                                        <span class="m-nav__link-text">Print</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_copy">
                                                        <i class="m-nav__link-icon la la-copy"></i>
                                                        <span class="m-nav__link-text">Copy</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_excel">
                                                        <i class="m-nav__link-icon la la-file-excel-o"></i>
                                                        <span class="m-nav__link-text">Excel</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_csv">
                                                        <i class="m-nav__link-icon la la-file-text-o"></i>
                                                        <span class="m-nav__link-text">CSV</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="#" class="m-nav__link" id="export_pdf">
                                                        <i class="m-nav__link-icon la la-file-pdf-o"></i>
                                                        <span class="m-nav__link-text">PDF</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>

                <div class="m_datatable" >
                    <form  id="frm-example" method="POST">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="table-logs">
                            <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Message</th>
                                <th>Sebelum</th>
                                <th>Sesudah</th>
                            </tr>
                            </thead>
                        </table>
                        <button class="btn m-btn m-btn--gradient-from-primary m-btn--gradient-to-info mt-5">Simpan</button></p>
                    </form>
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
    var table = $('#table-logs').DataTable({
        responsive: true,

        buttons: [
            'print',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
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
        columns: [
            {data: 'created_at'},
            {data: 'issuer_id'},
            {data: 'action'},
            {data: 'data'},
            {data: 'data'},
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return row.created_at;
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return row.user.first_name;
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return row.message;
                }
            },
            {
                targets: 4,
                render: function (data, type, row, meta) {
                    var text = JSON.parse(row.data);
                    var message = '';
                    $.each(text.before, function(k,v){
                        message += 'Kolom "'+k+'" : '+v+', ' ;
                    })
                    return message;
                }
            },
            {
                targets: 5,
                render: function (data, type, row, meta) {
                    var text = JSON.parse(row.data);
                    var message = '';
                    $.each(text.after, function(k,v){
                        message += 'Kolom "'+k+'" : '+v+', ' ;
                    })
                    return message;
                }
            },
        ],
    });


    $('#export_print').on('click', function(e) {
        e.preventDefault();
        table.button(0).trigger();
    });

    $('#export_copy').on('click', function(e) {
        e.preventDefault();
        table.button(1).trigger();
    });

    $('#export_excel').on('click', function(e) {
        e.preventDefault();
        table.button(2).trigger();
    });

    $('#export_csv').on('click', function(e) {
        e.preventDefault();
        table.button(3).trigger();
    });

    $('#export_pdf').on('click', function(e) {
        e.preventDefault();
        table.button(4).trigger();
    });


</script>
<?php $this->end(); ?>



