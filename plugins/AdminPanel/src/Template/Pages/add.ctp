<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Pages
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
												Pages
											</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
											<span class="m-nav__link-text">
												List Page
											</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
											<span class="m-nav__link-text">
												Add Page
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
                            Add Page
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
            <?= $this->Form->create($page, ['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form', 'id' => 'form-page']); ?>
            <div class="m-portlet__body">
                <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air'; ?>
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--success" role="tablist">
                    <?php $i = 0; foreach($languages as $key => $val) :?>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link <?= ($i == 0) ? 'active' : ''; ?>" data-toggle="tab" href="#m_tabs_<?= $key; ?>" role="tab"><?= $val['name']; ?></a>
                    </li>
                    <?php $i++; endforeach; ?>
                </ul>
                <div class="tab-content">
                    <?php $i = 0; foreach($languages as $key => $val) :?>
                    <div class="tab-pane <?= ($i == 0) ? 'active' : ''; ?>" id="m_tabs_<?= $key; ?>" role="tabpanel">
                        <?php
                        echo $this->Form->controls([
                            (($i == 0) ? 'title' : "_translations.{$key}.title") => ['class' => $default_class],
                            (($i ==0 ) ? 'content' : "_translations.{$key}.content") => ['class' => $default_class . ' froala-editor', 'required' => false]
                        ], ['fieldset' => false])
                        ?>
                    </div>
                    <?php $i++; ?>
                    <?php endforeach; ?>

                </div>
                <?php
                echo $this->Form->controls([
                    'slug' => ['class' => $default_class, 'required' => false],
                ], ['fieldset' => false])
                ?>
                <div class="input text form-group m-form__group row">
                    <label class="col-form-label col-lg-3"></label>
                    <div class="col-lg-9">
                        <div class="m-checkbox-list">
                            <label class="m-checkbox">
                                <?php echo $this->Form->checkbox('enable', ['div' => false, 'label' => false, 'hiddenField' => true, 'required' => false]); ?>  Enable
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <button type="submit" class="btn btn-brand" id="page-submit">
                                Submit
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
<script>
    $(document).ready(function() {
        $("#page-submit").click(function(){
            $(':required:invalid', '#form-page').each(function () {
                var id = $('.tab-pane').find(':required:invalid').closest('.tab-pane').attr('id');
                console.log(id)
                $('.nav a[href="#' + id + '"]').tab('show');
            });
        });
    });
</script>
<?= $this->Element('Script/froala-editor'); ?>
