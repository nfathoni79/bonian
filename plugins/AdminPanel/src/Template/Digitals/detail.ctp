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
                    <?= __('Produk Digital') ?>
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
                                <?= __('Produk Digital') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Produk') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Pratinjau Daftar Pulsa') ?>
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
                            <?= __('Pratinjau Daftar Pulsa') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span><?= __('Tambah Daftar Pulsa') ?></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>

                <div class="m_datatable" >
                    <?= $this->Form->create(null,['url' => 'validate','class' => 'm-form m-form--fit m-form--label-align-right','id' => 'frm-example']); ?>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="table-schedule">
                        <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Denom</th>
                            <th>Operator</th>
                            <th>Price</th>
                            <th>Status</th>
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

    function change_status(id, stts) {
        $.post( "<?= $this->Url->build(['action' => 'change']); ?>", {
            _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>' ,
            id : id,
            stts : stts
        } )
            .done(function( data ) {
                location.href = '<?= $this->Url->build();?>';
            });
    }


    // begin first table
    var table = $('#table-schedule').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        //== Order settings
        ajax: {
            url: "<?= $this->Url->build(['action' => 'detail', $this->request->params['pass'][0]]); ?>",
            type: 'POST',
            data: {
                pagination: {
                    perpage: 50,
                },
                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
            },
        },
        initComplete: function(settings, json) {
            $('input.numberinput').keyup(function(event) {

                // skip for arrow keys
                if(event.which >= 37 && event.which <= 40) return;

                // format number
                $(this).val(function(index, value) {
                    return value
                        .replace(/\D/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        ;
                });
            });

            $('input.child').on('change',function(){
                $( "#parent-"+$(this).data('parent')).prop('checked', true);
            })
        },
        headerCallback: function(thead, data, start, end, display) {
            thead.getElementsByTagName('th')[0].innerHTML = '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="" class="m-group-checkable"><span></span></label>';
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'code'},
            {data: 'denom'},
            {data: 'operator'},
            {data: 'price'},
            {data: 'status'},
        ],
        columnDefs: [
            {
                orderable: false,
                targets: 0,
                width: "5%",
                render: function (data, type, row, meta) {
                    return '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">\n' +
                        '<input type="checkbox" name="DigitalDetails['+row.id+'][id]" value="'+row.id+'" class="m-checkable" >\n' +
                        '<span></span>\n' +
                        '</label>';
                }
            },
            {
                targets: 1,
                width: "20%",
                render: function (data, type, row, meta) {
                    return '<div class="form-group m-form__group row"><div class="col-xl-12"><input type="text" class="form-control fname"  name="DigitalDetails['+row.id+'][name]" value="'+row.name+'"/></div></div>';
                }
            },
            {
                targets: 2, 
                render: function (data, type, row, meta) {
                    return '<div class="form-group m-form__group row"><div class="col-xl-12"><input type="text" class="form-control"  name="DigitalDetails['+row.id+'][code]" value="'+row.code+'"/></div></div>';
                }
            },
            {
                targets: 3,
                render: function (data, type, row, meta) {
                    return '<div class="form-group m-form__group row"><div class="col-xl-12"><input type="text" class="form-control numberinput"  name="DigitalDetails['+row.id+'][denom]" value="'+(new Intl.NumberFormat('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0})).format(row.denom)+'"/></div></div>';
                }
            },
            {
                targets: 4,
                width: "20%",
                render: function (data, type, row, meta) {

                    var selection = {
                        'Axis': 'Axis',
                        'Indosat': 'Indosat',
                        'Smartfren': 'Smartfren',
                        'Telkomsel': 'Telkomsel',
                        'Tri': 'Tri',
                        'XL': 'XL',
                    };
                    var renderOpt = '<div class="form-group m-form__group row"><div class="col-xl-12"><select name="DigitalDetails['+row.id+'][operator]" class="form-control">';
                    $.each(selection, function(k,v){
                        if(v == row.operator){
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
                targets: 5,
                render: function (data, type, row, meta) {
                    return '<div class="form-group m-form__group row"><div class="col-xl-12"><input type="text" class="form-control numberinput"  name="DigitalDetails['+row.id+'][price]" value="'+(new Intl.NumberFormat('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0})).format(row.price)+'"/></div></div>';
                }
            },
            {
                targets: 6,
                width: "15%",
                render: function (data, type, row, meta) {
                    var status = {
                        '0': 'Close',
                        '1': 'Open',
                    };
                    var renderOpt = '<div class="form-group m-form__group row"><div class="col-xl-12"><select name="DigitalDetails['+row.id+'][status]" class="form-control">';
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



