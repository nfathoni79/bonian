<?php foreach($data as $key => $val) : ++$key; ?>
<div class="m-accordion__item product-variant-item item-<?= $key; ?>">
    <div class="m-accordion__item-head" role="tab" id="m_accordion_2_item_<?= $key; ?>_head" data-toggle="collapse" href="#m_accordion_2_item_<?= $key; ?>_body" aria-expanded="    false">
        <span class="m-accordion__item-title">Varian Produk <a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove-row" data-item=<?= $key; ?>>  <i class="la la-trash"></i></a> </span>
        <span class="m-accordion__item-mode"></span>
    </div>
    <div class="m-accordion__item-body collapse show" id="m_accordion_2_item_<?= $key; ?>_body" class=" " role="tabpanel" aria-labelledby="m_accordion_2_item_<?= $key; ?>_head" data-parent="#m_accordion_2">
        <div class="m-accordion__item-content">
            <div class="row">
                <div class="col-xl-4">
                    <?php foreach($val['product_option_value_lists'] as $variant) : ?>
                    <div class="form-group m-form__group row">
                        <label class="col-xl-4 col-form-label"><?= $variant['option']->get('name'); ?> *</label>
                        <div class="col-xl-6">
                            <?= $this
                                ->Form
                                ->select('ProductOptionValueLists.' . $key . '.' . $variant->get('option_id'),
                                    $dropdown[$variant->get('option_id')],
                                    [
                                        'label' => false,
                                        'value' => $variant->get('option_value_id'),
                                        'disabled' => true,
                                        'class' => 'form-control select2 m-input sku-prefix select-' . strtolower($variant['option']->get('name')),
                                        'id' => 'ProductOptionValues' . $key . $variant['option']->get('name')
                                    ]); ?>
                        </div>
                        <div class="col-xl-2">
                            <?php /*<a href="#" class="btn btn-info m-btn m-btn--icon m-btn--icon-only add-variant" style="width:40px; height: 40px;" data-toggle="modal" data-target="#modal-attribute" data-variant="'+text.toLowerCase()+'"><i class="la la-plus"></i></a>*/ ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
                <div class="col-xl-4">
                    <div class="form-group m-form__group row">
                        <label class="col-xl-4 col-form-label">Expired</label>
                        <div class="col-xl-4">
                            <input type="text" name="ProductOptionPrices[<?= $key; ?>][expired]" class="form-control m-input datepicker" value="<?= h($val->get('expired')->format('Y-m-d')); ?>" placeholder="Expired">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-xl-4 col-form-label">SKU *</label>
                        <div class="col-xl-5">
                            <input type="text" name="ProductOptionPrices[<?= $key; ?>][sku]" class="form-control m-input sku-number disabled" placeholder="Sku" value="<?= h($val->get('sku')); ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-xl-4 col-form-label">Harga Tambahan *</label>
                        <div class="col-xl-4">
                            <input type="number" name="ProductOptionPrices[<?= $key; ?>][price]" class="form-control m-input" value="<?= h($val->get('price')); ?>" placeholder="Harga">
                        </div>
                    </div>
                    <?php $is_weight = !empty($val['product_option_stocks'][0]['weight']) ? true : false ?>
                    <div class="m-form__group form-group row berat" style="<?php echo $is_weight ? '' : 'display:none;'; ?>">
                        <label class="col-xl-4 col-form-label">Berat *</label>
                        <div class="col-xl-3">
                            <input type="number" value="<?= $val['product_option_stocks'][0]['weight']; ?>" name="ProductOptionStocks[<?= $key; ?>][weight]" class="form-control m-input" placeholder="Berat (gram)">
                        </div>
                    </div>
                    <div class="m-form__group form-group row dimensi" style="<?php echo $is_weight ? 'display:none;' : ''; ?>;">
                        <label class="col-xl-4 col-form-label">Dimensi *</label>
                        <div class="col-xl-2">
                            <input type="number" value="<?= $val['product_option_stocks'][0]['length']; ?>" name="ProductOptionStocks[<?= $key; ?>][length]" class="form-control m-input" placeholder="Panjang">
                        </div>
                        <div class="col-xl-2">
                            <input type="number" value="<?= $val['product_option_stocks'][0]['width']; ?>" name="ProductOptionStocks[<?= $key; ?>][width]" class="form-control m-input" placeholder="Lebar">
                        </div>
                        <div class="col-xl-2">
                            <input type="number" value="<?= $val['product_option_stocks'][0]['height']; ?>" name="ProductOptionStocks[<?= $key; ?>][height]" class="form-control m-input" placeholder="Tinggi">
                        </div>
                    </div>
                    <?php foreach($val['product_option_stocks'] as $k => $stock) : ?>
                    <?php if ($k > 0) : ?>
                    <div class="multi-cabang-<?= $key; ?>">
                    <?php endif; ?>
                    <div class="m-form__group form-group row">
                        <label class="col-xl-4 col-form-label"><?php if ($k == 0) : ?>Stock Cabang *<?php endif; ?></label>
                        <div class="col-xl-3">
                            <?= $this
                                ->Form
                                ->select('ProductOptionStocks.' . $key . '.branches.' . $k . '.branch_id',
                                    $branches,
                                    [
                                        'label' => false,
                                        'value' => $stock->get('branch_id'),
                                        'disabled' => true,
                                        'class' => 'form-control select2 m-input',
                                    ]); ?>
                        </div>
                        <div class="col-xl-3">
                            <input type="number" disabled value="<?= $stock['stock']; ?>" name="ProductOptionStocks[<?= $key; ?>][branches][0][stock]" class="form-control m-input" placeholder="Stok">
                        </div>
                        <div class="col-xl-1">
                            <?php if ($k == 0) : ?>
                            <a href="javascript:void(0);" style="width:40px; height: 40px;" class="btn btn-info m-btn m-btn--icon m-btn--icon-only add-cabang" data-item=<?= $key; ?>><i class="la la-plus"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($k > 0) : ?>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="col-xl-4">
                    <div class="form-group m-form__group row">
                        <div class="col-xl-12">
                            <div class="m-dropzone dropzone m-dropzone--primary" action="#" id="m-dropzone<?= $key; ?>" style="min-height:100px !important;">
                                <div class="m-dropzone__msg dz-message needsclick">
                                    <h3 class="m-dropzone__msg-title">Drop files disini atau click untuk upload.</h3>
                                    <span class="m-dropzone__msg-desc">Upload sampai 10 file</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>