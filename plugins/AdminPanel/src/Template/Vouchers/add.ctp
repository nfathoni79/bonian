<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $voucher
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
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Voucher') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Voucher') ?>
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
                            <?= __('Daftar Voucher') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($voucher,['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form', 'id' => 'm_form']); ?>
            <div class="m-portlet__body">
                <?php
                    $this->Form->setConfig('errorClass', 'is-invalid');
                    echo $this->Flash->render();
                    $default_class = 'form-control form-control-danger m-input m-input--air';
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <?php  echo $this->Form->control('name',['class' => $default_class,'required' => false,'label' => 'Judul Promosi']); ?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <?php  echo $this->Form->control('code_voucher',['class' => $default_class,'required' => false,'label' => 'Code Voucher']); ?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <?php echo $this->Form->control('date_start',['type' => 'text','required' => false,'class' => $default_class, 'id' => 'm_datetimepicker_start', 'label' => 'Start']); ?>
                            </div>
                            <div class="col-lg-4">
                                <?php echo $this->Form->control('date_end',['type' => 'text','required' => false,'class' => $default_class, 'id' => 'm_datetimepicker_end', 'label' => 'End']); ?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <?php  echo $this->Form->control('percent',['class' => $default_class, 'label' => 'Nilai Diskon','required' => false, 'placeholder' => 'Nilai diskon yang diberikan dalam format % (contoh 10)']); ?>
                            </div>
                            <div class="col-lg-4">
                                <?php  echo $this->Form->control('value',['class' => $default_class, 'label' => 'Nilai Maximum Voucher','required' => false, 'placeholder' => 'Nilai voucher yang diberikan']); ?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <?php echo $this->Form->control('type',['class' => $default_class, 'label' => 'Tipe', 'options' => ['1' => 'Penukaran Point', '2' => 'Seleksi Berdasarkan Kategori'],'empty' => 'Pilih Tipe Voucher']); ?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row point" style="display:none;">
                            <div class="col-lg-4">
                                <?php echo $this->Form->control('point',['class' => $default_class, 'label' => 'Jumlah Point','required' => false, 'placeholder' => 'Jumlah point yang akan di redeem']); ?>
                            </div>
                        </div>
                        <div class="category mt-3" style="display:none;">
                            <div class="form-group  m-form__group row">
                                <label  class="col-lg-1 col-form-label">Kategori </label>
                                <div class="col-lg-9">
                                    <div class="repeater">
                                        <div data-repeatable data-repeater-list="" class="col-lg-12">
                                            <div data-repeater-item class="row m--margin-bottom-10">
                                                <div class="col-lg-4">
                                                    <?php echo $this->Form->control('categories[0][id]', ['type'=> 'hidden','label' => false, 'class' => $default_class . ' category-id', 'readonly' => true, 'data-id' => 0]);?>
                                                    <?php echo $this->Form->control('categories[0][name]', ['label' => false, 'class' => $default_class . ' category-name', 'readonly' => true, 'data-id' => 0]);?>
                                                </div>
                                                <div class="col-lg-2">
                                                    <a href="javascript:void(0);" class="btn btn-info m-btn m-btn--icon btn-pick"  data-id="0"  data-toggle="modal" data-target="#m_modal_1">
                                                        <i class="la la-list-alt"></i> Pilih Kategori
                                                    </a>
                                                </div>
                                                <div class="col-lg-2">
                                                    <a href="javascript:void(0);" data-repeater-delete="" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove-row">
                                                        <i class="la la-remove"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div data-repeater-create="" class="btn btn btn-primary m-btn m-btn--icon button">
                                                <span>
                                                    <i class="la la-plus"></i>
                                                    <span>Tambah Kategori</span>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-1 col-form-label">Syarat & Ketentuan</label>
                            <div class="col-lg-9">
                                <?php  echo $this->Form->control('tos',['label' => false, 'div' => false, 'class' => $default_class. ' froala-editor']);?>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <?php  echo $this->Form->control('status',['class' => $default_class, 'label' => 'Status', 'options' => ['1' => 'Aktif', '2' => 'Tidak Aktif'], 'empty' => 'Pilih Status']); ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
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
                <h5 class="modal-title" id="exampleModalLabel">Pilih Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group m-form__group row">
                    <div class="col-lg-6">
                        <?php echo $this->Form->control('id',['type'=>'hidden','id' => 'idform']);?>
                        <?php echo $this->Form->control('level1',['class' => $default_class, 'label' => 'Kategori Level 1','required' => false, 'options' => $parent_categories, 'empty' => 'Pilih Kategori Utama']); ?>
                    </div>
                    <div class="col-lg-6">
                        <?php  echo $this->Form->control('level2',['type' => 'select', 'class' => $default_class, 'label' => 'Kategori Level 2','required' => false, 'empty' => 'Pilih Kategori Sub Level']); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <label>Kategori Level 3</label>
                    <table class="table table-hover" id="table-kategori">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<?php $this->append('script'); ?>

<?= $this->Element('Script/froala-editor'); ?>
<?php
$this->Html->css([
'/admin-assets/vendors/custom/datatables/datatables.bundle.css'
], ['block' => true]);
$this->Html->script([
'/admin-assets/vendors/custom/datatables/datatables.bundle',
'/admin-assets/vendors/custom/libs/validation-render',
], ['block' => true]);
?>
<script>
    $( document ).ready(function() {
        $('select').selectpicker();
        $('#m_datetimepicker_start').datetimepicker({
            startDate: '-0d',
            todayHighlight: true,
            autoclose: true,
            pickerPosition: 'bottom-left',
            format: 'yyyy-mm-dd hh:ii',
        });
        $('#m_datetimepicker_end').datetimepicker({
            startDate: '-0d',
            todayHighlight: true,
            autoclose: true,
            pickerPosition: 'bottom-left',
            format: 'yyyy-mm-dd hh:ii',
        });

        $('#type').on('change',function(){
            var tipe = $(this).val();
            if(tipe == '1'){
                $('.point').show();
                $('.category').hide();
            }else{
                $('.point').hide();
                $('.category').show();
            }
        });

        var formEl = $("#m_form");
        var url = '<?= $this->Url->build(['action' => 'add']); ?>';
        var ajaxRequest = new ajaxValidation(formEl);
        ajaxRequest.setblockUI('.m-portlet m-portlet--mobile');


        $("#m_form").submit(function(e) {
            ajaxRequest.post(url, formEl.find(':input'), function(data,saved) {
                if (data.success) {
                    location.reload();
                }
            });
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });


        $('#m_repeater_3x').repeater({
            initEmpty: false,


            show: function() {
                $(this).slideDown();
                createAttributeValues($(this).find('.attribute-value'));
            },

            hide: function(deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        });

        // idform
        $('.btn-pick').on('click',function (){
            var idpick = $(this).data('id');
            $('#idform').val(idpick);
        })

        var count = 1;
        $('.repeater').on('click', '.button', function(e) {
            e.preventDefault();

            var $this = $(this),
                $repeater = $this.closest('.repeater').find('[data-repeatable]'),
                //count = $repeater.length,
                $clone = $repeater.first().clone();

            $clone.find('.select2-container').remove();
            $clone.find('.remove-row').show();
            $clone.find('.form-control-feedback').remove();


            $clone.find('[id]').each(function() {
                this.id = this.id.replace(/\d+/, count);
                $(this).attr('data-id', count)
            });

            $clone.find('.btn-pick').each(function() {
                $(this).attr('data-id', count)
                $(this).on('click',function (){
                    var idpick = $(this).data('id');
                    $('#idform').val(idpick);
                })
            });

            $clone.find('[data-select2-id]').each(function() {
                $(this).attr('data-select2-id', this.id)
            });

            $clone.find('.category-id').each(function() {
                $(this).val('');
            });

            $clone.find('[name]').each(function() {
                this.name = this.name.replace(/\[\d+\]/, '[' + count + ']');
            });

            var select = $clone.find('#tags-' + count);

            select.val('');

            // createAttributeValues(select);
            removeRow($clone.find('.remove-row'));

            $clone.find('label').each(function() {
                var $this = $(this);
                $this.attr('for', $this.attr('for') + '_' + count);
            });

            $clone.insertBefore($this);
            count++;
        });

        function removeRow(selector) {
            selector.on('click', function() {
                $(this).parents('[data-repeatable]').remove();
            });
        }

        removeRow($('.remove-row'));
        $('[data-repeatable]').first().find('.remove-row').hide();



        $('#level1').on('change',function (){
            var terpilih = $(this).val();
            setChainCategory('#level2', terpilih);
        })

        $('#level2').on('change',function (){
            var idform = $('#idform').val();
            var terpilih = $(this).val();
            setChainCategoryTable('#table-kategori', terpilih, idform);
        })

        function setChainCategory(target, parent_id) {
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build(['controller' => 'Attributes','action' => 'getCategory']); ?>',
                data: {parent_id: parent_id, _csrfToken : $('input[name=_csrfToken]').val()},
                success: function (data) {
                    $(target + ' option').remove();
                    var o = [];
                    $(target).append($('<option/>').attr('value', '').text('Pilih Kategori Sub Level'));
                    for(var i in data) {
                        $(target).append($('<option/>').attr('value', i).text(data[i]));
                    }
                    $(target).selectpicker('refresh');
                }
            });
        }
        function setChainCategoryTable(target, parent_id, idform) {
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build(['controller' => 'Attributes','action' => 'getCategory']); ?>',
                data: {parent_id: parent_id, _csrfToken : $('input[name=_csrfToken]').val()},
                success: function (data) {
                    var drawTable = '';
                    $.each(data, function(k,v){
                        drawTable += '<tr><td>'+k+'</td><td>'+v+'</td><td><a href="#" class="btn btn-primary btn-sm btn-transfer" data-idform="'+idform+'" data-name="'+v+'" data-id="'+k+'">Pilih Kategori</a></td></tr>';
                    })
                    $(target+ ' tbody').html(drawTable);
                    $('.btn-transfer').on('click',function(){
                        $('#categories-'+$(this).data('idform')+'-id').val($(this).data('id'));
                        $('#categories-'+$(this).data('idform')+'-name').val($(this).data('name'));
                        $('#m_modal_1').modal('hide');
                    })
                }
            });
        }
        $('#m_modal_1').on('hidden.bs.modal', function() {
            $('#table-kategori tbody').html('');
        })

    });



</script>


<?php $this->end(); ?>