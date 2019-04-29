<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $brand
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Brand') ?>
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
                                <?= __('Brand') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Daftar Brand') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Tambah Brand') ?>
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
                            <?= __('Tambah Brand') ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>


            <?= $this->Form->create($brand,['class' => 'm-login__form m-form', 'id' => 'm_form']); ?>
            <div class="m-portlet__body">

            <?php
                echo $this->Flash->render();
                $default_class = 'form-control form-control-danger m-input m-input--air';
                // echo $this->Form->control('product_category_id', ['options' => $productCategories, 'empty' => true, 'class' => $default_class]);
                // echo $this->Form->control('parent_id', ['options' => $parentBrands, 'empty' => true, 'class' => $default_class]);
                // echo $this->Form->control('name',['class' => $default_class]);
            ?>
                <div class="form-group  m-form__group row">
                    <label  class="col-lg-3 col-form-label">Category: </label>
                    <div class="col-lg-9">
                        <div class="col-md-12">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <?= $this->Form->select('parent', $productCategories, ['id' => 'level1', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                </div>

                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <?= $this->Form->select('level2', [], ['id' => 'level2', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                </div>

                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <?= $this->Form->select('product_category_id', [], ['id' => 'level3', 'class' => 'form-control product-category', 'size' => 7, 'multiple' => 1]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group  m-form__group row">
                    <label  class="col-lg-3 col-form-label">Nama Brand : </label>
                    <div class="col-lg-9">
                        <div class="repeater">
                            <div data-repeatable data-repeater-list="" class="col-lg-12">
                                <div data-repeater-item class="row m--margin-bottom-10">
                                    <div class="col-lg-5">
                                        <?php echo $this->Form->control('brand[0][value]', ['options' => $brands, 'label' => false, 'class' => $default_class . ' attribute-value', 'id' => 'tags-0', 'multiple' => true, 'style' => 'width: 100% !important;']);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-3">


                </div>
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
<?php
echo $this->Html->script([
'/admin-assets/vendors/custom/libs/validation-render',
]);
?>
<script>
    $('.select2').selectpicker();

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
        });

        $clone.find('[data-select2-id]').each(function() {
            $(this).attr('data-select2-id', this.id)
        });

        $clone.find('.attribute-name, attribute-value').each(function() {
            $(this).val('');
        });

        $clone.find('[name]').each(function() {
            this.name = this.name.replace(/\[\d+\]/, '[' + count + ']');
        });

        createAttributeValues($clone.find('#tags-' + count));
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


    function setChainCategory(target, parent_id) {
        $.ajax({
            type: 'POST',
            url: '<?= $this->Url->build(['controller' => 'Attributes','action' => 'getCategory']); ?>',
            data: {parent_id: parent_id, _csrfToken : $('input[name=_csrfToken]').val()},
            success: function (data) {
                $(target + ' option').remove();
                var o = [];
                for(var i in data) {
                    $(target).append($('<option/>').attr('value', i).text(data[i]));
                }
            }
        });
    }

    $("#level1").change(function(e) {
        var val = $(this).val();
        if (val.length == 1) {
            setChainCategory('#level2', val[0]);
        } else {
            e.preventDefault();
        }
    });

    $("#level2").change(function(e) {
        var val = $(this).val();
        if (val.length == 1) {
            setChainCategory('#level3', val[0]);
        } else {
            e.preventDefault();
        }
    });

    $("#level3").change(function(e) {
        var target = $("#tags-0");


        $.ajax({
            type: 'POST',
            url: '<?= $this->Url->build(['controller' => 'Brands','action' => 'categoryBrands']); ?>',
            data: {product_category_id: $(this).find(":selected").val(), _csrfToken : $('input[name=_csrfToken]').val()},
            success: function (data) {
                target.find("option:selected").prop("selected", false);
                for(var i in data) {
                    target.find('option[value="' + i + '"]').prop('selected', true);
                }
                target.trigger('change');
            }
        });
    });

    function createAttributeValues(selector) {
        selector.select2({
            placeholder: "Tambah Brand",
            tags: true
        }).on("change", function(e) {
            var isNew = $(this).find('[data-select2-tag="true"]');
            if(isNew.length && $.inArray(isNew.val(), $(this).val()) !== -1){
                isNew.replaceWith('<option selected value="' + isNew.val() + '">' + isNew.val() + '</option>');
                console.log('New tag: ', isNew.val());
            }
        })
        .on(
            'select2:close',
            function () {
                var select2SearchField = $(this).parent().find('.select2-search__field'),
                    setfocus = setTimeout(function() {
                        select2SearchField.focus();
                    }, 100);
            }
        );
    }

    createAttributeValues($('#tags-0'));



</script>
<?php $this->end(); ?>

