<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $branch
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Toko Cabang') ?>
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
                                <?= __('Toko Cabang') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Cabang') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Tambah Cabang') ?>
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
                            <?= __('Tambah Cabang') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($branch,['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form']); ?>
            <div class="m-portlet__body">

            <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                echo $this->Form->control('name',['class' => $default_class,'label' => 'Nama Cabang']);
                echo $this->Form->control('address',['class' => $default_class,'label' => 'Alamat']);
                echo $this->Form->control('phone',['class' => $default_class,'label' => 'Nomor Telepon']);

                echo $this->Form->control('provice_id', ['options' => $provinces, 'class' => 'form-control m-select2','id' => 'optprovince','empty' => 'Pilihan', 'label' => 'Provinsi']);
                echo $this->Form->control('city_id', ['options' => [],'class' => 'form-control m-select2','id' => 'optcity','empty' => 'Pilihan','label' => 'Kota']);
                echo $this->Form->control('subdistrict_id', ['options' => [],'class' => 'form-control m-select2','id' => 'optsubdistrict','empty' => 'Pilihan','label' => 'Kabupaten']);

                echo $this->Form->control('latitude',['class' => $default_class,'label' => 'Koordinat Latitude']);
                echo $this->Form->control('longitude',['class' => $default_class,'label' => 'Koordinat Longitude']);
            ?>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <?= $this->Form->submit(__('Simpan'),['class' => 'btn btn-brand']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>

<?php $this->append('script'); ?>
<script>
    // $cities
    // $subdistricts
    $("#optprovince").select2();
    $('#optprovince').on("change", function(e) {
        var selected = $(this).val();

        $.ajax({
            url: "<?= $this->Url->build(['action' => 'getCities']); ?>",
            cache: false,
            method: 'POST',
            data: {
                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>',
                province : selected
            },
            success: function (responseBranchs) {
                var optcities = '<option value="">Pilihan</option>';
                $.each(responseBranchs, function(k,v){
                    optcities += '<option value="'+k+'">'+v+'</option>';
                });
                $("#optcity").html(optcities);

                $("#optcity").select2();
            },
        })
    });
    $("#optcity").select2();
    $('#optcity').on("change", function(e) {
        var selected = $(this).val();

        $.ajax({
            url: "<?= $this->Url->build(['action' => 'getDistricts']); ?>",
            cache: false,
            method: 'POST',
            data: {
                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>',
                city : selected
            },
            success: function (responseBranchs) {
                var optdistricts = '<option value="">Pilihan</option>';
                $.each(responseBranchs, function(k,v){
                    optdistricts += '<option value="'+k+'">'+v+'</option>';
                });
                console.log(optdistricts);
                $("#optsubdistrict").html(optdistricts);

                $("#optsubdistrict").select2();
            },
        })
    });
    $("#optsubdistrict").select2();

</script>
<?php $this->end(); ?>

