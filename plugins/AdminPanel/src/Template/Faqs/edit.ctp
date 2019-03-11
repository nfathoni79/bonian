<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $faq
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Faq') ?>
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
                                <?= __('Faq') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Faq') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Edit Faq') ?>
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
                            <?= __('Edit Faq') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($faq,['class' => 'm-form m-form--label-align-right']); ?>

            <?php
                echo $this->Flash->render();
            $default_class = 'form-control form-control-danger m-input m-input--air';
            ?>
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label">Kategori Faq:</label>
                    <div class="col-lg-6">
                        <?php echo $this->Form->control('faq_category_id', ['label' => false, 'div' => false, 'options' => $faqCategories, 'class' => $default_class]);?>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label">Judul:</label>
                    <div class="col-lg-6">
                        <?php  echo $this->Form->control('judul',['label' => false, 'div' => false, 'class' => $default_class]);?>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label">Konten:</label>
                    <div class="col-lg-9">
                        <?php echo $this->Form->control('content',['label' => false, 'div' => false, 'class' => $default_class. ' froala-editor']);?>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label">Status:</label>
                    <div class="col-lg-1">
                        <?php echo $this->Form->control('status',['label' => false, 'div' => false, 'class' => $default_class, 'options' => [0 => 'Off', 1 => 'On']]);?>
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
