<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    User &amp; Group
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
												User &amp; Group
											</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
											<span class="m-nav__link-text">
												List User
											</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
											<span class="m-nav__link-text">
												Edit User
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
                            Edit Users
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
            <?= $this->Form->create($user, ['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form']); ?>
                <div class="m-portlet__body">
                    <?php
                    echo $this->Flash->render();
                    $default_class = 'form-control form-control-danger m-input m-input--air';
                    echo $this->Form->controls([
                            'email' => ['class' => $default_class],
                            'password' => ['class' => $default_class, 'required' => false, 'value' => ''],
                            'repeat_password' => ['type' => 'password', 'class' => $default_class, 'required' => false, 'value' => ''],
                            'group_id' => ['class' => $default_class, 'empty' => 'Select'],
                            'user_status_id' => ['class' => $default_class, 'empty' => 'Select', 'options' => $user_status],
                            'first_name' => ['class' => $default_class],
                            'last_name' => ['class' => $default_class]
                    ], ['fieldset' => false])
                    ?>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-brand">
                                    Submit
                                </button>
                                <button type="submit" class="btn btn-secondary">
                                    Cancel
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
<!-- end:: Body -->
<script>
    $('select').selectpicker();
</script>
