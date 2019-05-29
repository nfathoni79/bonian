<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Products
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
                                Products
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Edit Product
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Pilih gambar
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Pilih gambar
                            <!-- <small>
                                data loaded from remote data source
                            </small> -->
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>
            <!--begin::Form-->
            <?= $this->Form->create(null, ['class' => 'm-login__form m-form']); ?>
            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>

                <div class="row mt-5">
                    <div class="col-sm-12">
                        <h6><?= __d('AdminPanel',  'Gambar produk'); ?></h6>
                    </div>
                </div>
                <div class="m-form__seperator m-form__seperator--dashed"></div>

                <div class="row mt-3">
                    <div class="col-lg-12" id="input-preview-wizard">

                        <div class="form-group m-form__group">
                            <label for="exampleInputEmail1">Pilih Gambar utama</label>
                            <div class="row" id="image-preview-wizard">
                                <?php foreach($images as $image) : ?>
                                    <div class="col-md-1 nopad text-center">
                                        <label class="image-radio">
                                            <img src="<?= $this->Url->build('/images/120x120/') . $image['name']; ?>" alt="" class="img-thumbnail img-responsive" />
                                            <input type="radio" name="ProductImages[primary]" value="<?= $image['id']; ?>" <?= $image['primary'] == 1 ? 'checked': ''; ?> />
                                            <i class="la la-check-square checked-icon d-none"></i>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <button type="submit" class="btn btn-brand">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end(); ?>
            <!--end::Form-->
        </div>
    </div>
</div>
<?php $this->append('script'); ?>
<script>
    $(document).ready(function() {
        $(".image-radio").each(function(i) {
            if($(this).find('input[type="radio"]').first().attr("checked")){
                $(this).addClass('image-radio-checked');
            }else{
                $(this).removeClass('image-radio-checked');
            }
        });

        // sync the input state
        $(".image-radio").on("click", function(e) {
            $(".image-radio").removeClass('image-radio-checked');
            $(this).addClass('image-radio-checked');
            var $radio = $(this).find('input[type="radio"]');
            $radio.prop("checked",!$radio.prop("checked"));
            e.preventDefault();
        });
    });
</script>
<?php $this->end(); ?>
