<div class="m-accordion__item product-variant-item item-'+i+'">
    <div class="m-accordion__item-head" role="tab" id="m_accordion_2_item_'+i+'_head" data-toggle="collapse" href="#m_accordion_2_item_'+i+'_body" aria-expanded="    false">
        <span class="m-accordion__item-title">Varian Produk <a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only remove-row" data-item='+i+'>  <i class="la la-trash"></i></a> </span>
        <span class="m-accordion__item-mode"></span>
    </div>
    <div class="m-accordion__item-body collapse show" id="m_accordion_2_item_'+i+'_body" class=" " role="tabpanel" aria-labelledby="m_accordion_2_item_'+i+'_head" data-parent="#m_accordion_2">
        <div class="m-accordion__item-content">
            <div class="row">
                <div class="col-xl-4">'+formTemplate+'</div>
                <div class="col-xl-4">
                    <div class="form-group m-form__group row">
                        <label class="col-xl-4 col-form-label">Expired</label>
                        <div class="col-xl-4">
                            <input type="text" name="ProductOptionPrices['+i+'][expired]" class="form-control m-input datepicker" placeholder="Expired">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-xl-4 col-form-label">SKU *</label>
                        <div class="col-xl-6">
                            <input type="text" name="ProductOptionPrices['+i+'][sku]" class="form-control m-input sku-number" placeholder="Sku" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-xl-4 col-form-label">Harga Tambahan *</label>
                        <div class="col-xl-4">
                            <input type="number" name="ProductOptionPrices['+i+'][price]" class="form-control m-input" placeholder="Harga">
                        </div>
                    </div>
                    <div class="m-form__group form-group row berat" style="display:none;">
                        <label class="col-xl-4 col-form-label">Berat *</label>
                        <div class="col-xl-3">
                            <input type="number" name="ProductOptionStocks['+i+'][weight]" class="form-control m-input" placeholder="Berat (gram)">
                        </div>
                    </div>
                    <div class="m-form__group form-group row dimensi" style="display:none;">
                        <label class="col-xl-4 col-form-label">Dimensi *</label>
                        <div class="col-xl-2">
                            <input type="number" name="ProductOptionStocks['+i+'][length]" class="form-control m-input" placeholder="Panjang">
                        </div>
                        <div class="col-xl-2">
                            <input type="number" name="ProductOptionStocks['+i+'][width]" class="form-control m-input" placeholder="Lebar">
                        </div>
                        <div class="col-xl-2">
                            <input type="number" name="ProductOptionStocks['+i+'][heigth]" class="form-control m-input" placeholder="Tinggi">
                        </div>
                    </div>
                    <div class="m-form__group form-group row">
                        <label class="col-xl-4 col-form-label">Stock Cabang *</label>
                        <div class="col-xl-3">
                            <select name="ProductOptionStocks['+i+'][branches][0][branch_id]" class="form-control select2  m-input ">'+optbranchs+'</select>
                        </div>
                        <div class="col-xl-3">
                            <input type="number" name="ProductOptionStocks['+i+'][branches][0][stock]" class="form-control m-input" placeholder="Stok">
                        </div>
                        <div class="col-xl-1">
                            <a href="javascript:void(0);" style="width:40px; height: 40px;" class="btn btn-info m-btn m-btn--icon m-btn--icon-only add-cabang" data-item='+i+'><i class="la la-plus"></i></a>
                        </div>
                    </div>
                    <div class="multi-cabang-'+i+'">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group m-form__group row">
                        <div class="col-xl-12">
                            <div class="m-dropzone dropzone m-dropzone--primary" action="#" id="m-dropzone'+i+'" style="min-height:100px !important;">
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