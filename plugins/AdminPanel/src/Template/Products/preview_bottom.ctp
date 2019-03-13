
<div class="row mt-5">
    <div class="col-sm-12">
        <h6><?= __d('AdminPanel',  'Varian Produk'); ?></h6>
    </div>
</div>
<div class="m-form__seperator m-form__seperator--dashed"></div>

<div class="m-accordion m-accordion--bordered m-accordion--solid mb-4" id="m_accordion_4" role="tablist">
    <?php $i = 1;?>
    <?php foreach($product['product_option_prices'] as $key => $vals):?>
    <div class="m-accordion__item">
        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_4_item_<?php echo $i;?>_head" data-toggle="collapse" href="#m_accordion_4_item_<?php echo $i;?>_body" aria-expanded="false">
            <span class="m-accordion__item-title">Variant <?php echo $i;?> </span>
            <span class="m-accordion__item-mode"></span>
        </div>
        <div class="m-accordion__item-body collapse" id="m_accordion_4_item_<?php echo $i;?>_body" role="tabpanel" aria-labelledby="m_accordion_4_item_<?php echo $i;?>_head" data-parent="#m_accordion_4" style="">
            <div class="m-accordion__item-content">
                <div class="row">
                    <div class="col-sm-3">
                        <?php foreach($vals['product_option_value_lists'] as $val):?>
                            <div class="form-group m-form__group row p-0 ">
                                <label class="col-sm-3 col-form-label"><?php echo $val['option']['name'];?></label>
                                <div class="col-sm-8">
                                    <p class="form-control-plaintext"><?php echo $val['option_value']['name'];?></p>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group m-form__group row p-0 ">
                            <label class="col-sm-3 col-form-label">Expired</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext"><?php echo $vals['expired'] ? $vals['expired'] : '-';?></p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row p-0 ">
                            <label class="col-sm-3 col-form-label">SKU</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext"><?php echo $vals['sku'];?></p>
                            </div>
                        </div>

                        <div class="form-group m-form__group row p-0 ">
                            <label class="col-sm-3 col-form-label">Harga Tambahan</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext"><?php echo $vals['price'];?></p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row p-0 ">
                            <label class="col-sm-3 col-form-label">Berat </label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext"><?php echo $vals['product_option_stocks'][0]['weight'] ? $vals['product_option_stocks'][0]['weight'] : '-';?></p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row p-0 ">
                            <label class="col-sm-3 col-form-label">Dimensi </label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext"><?php echo $vals['product_option_stocks'][0]['length'] ? $vals['product_option_stocks'][0]['length'].'*'.$vals['product_option_stocks'][0]['width'].'*'.$vals['product_option_stocks'][0]['height'] : '-';?>  </p>
                            </div>
                        </div>
                        <?php foreach($vals['product_option_stocks'] as $kk => $val):?>
                        <div class="form-group m-form__group row p-0 ">
                            <label class="col-sm-3 col-form-label"><?php echo ($kk == '0') ? 'Stock Cabang' : ''; ?> </label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext"><?php echo $val['branch']['name'];?> : <?php echo $val['stock'];?></p>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group m-form__group">
                            <div class="row">
                                <?php foreach($vals['image'] as $val):?>
                                <div class="col-md-3 nopad text-center">
                                    <img src="/zolaku/images/100x100/<?php echo $val?>" alt="" class="img-thumbnail img-responsive">
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $i++;?>
    <?php endforeach;?>
</div>



