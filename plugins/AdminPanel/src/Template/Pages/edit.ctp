<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $page
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Page') ?>
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
                                <?= __('Page') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Page') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Edit Page') ?>
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
                            <?= __('Edit Page') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($page,['class' => 'm-login__form m-form', 'templates' => 'AdminPanel.app_form']); ?>
            <div class="m-portlet__body">

            <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                echo $this->Form->control('title',['class' => $default_class]);
                echo $this->Form->control('slug',['class' => $default_class, 'required' => false],['fieldset' => false]);
                echo $this->Form->input('kategori', array('label'=>'Kategori', 'class' => 'form-control form-control-danger m-input', 'type'=>'select', 'options'=>['Satu', 'Dua']));
                echo $this->Form->control('content',['class' => $default_class . ' froala-editor', 'required' => false]);
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
                            <?= $this->Form->submit(__('Submit'),['class' => 'btn btn-brand']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
<script>
    $('select').selectpicker();
    $(document).ready(function(){
        $("#title").keyup(function(){
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $("#slug").val(Text);
        });
    })
</script>


<?= $this->Element('Script/froala-editor'); ?>