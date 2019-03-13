

<div class="row mt-3">
    <div class="col-sm-6">
        <div class="row mt-5">
            <div class="col-sm-12">
                <h6><?= __d('AdminPanel',  'Informasi Produk'); ?></h6>
            </div>
        </div>
        <div class="m-form__seperator m-form__seperator--dashed"></div>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel', 'Nama Produk'); ?></label>
            <div class="col-sm-9">
                <p class="form-control-plaintext"> <?php echo $product['name']; ?></p>
            </div>
        </div>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel',  'Slug URL'); ?></label>
            <div class="col-sm-9">
                <p class="form-control-plaintext"> <?php echo $product['slug']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-sm-5 offset-1">

        <div class="row mt-5">
            <div class="col-sm-12">
                <h6><?= __d('AdminPanel',  'SEO Produk'); ?></h6>
            </div>
        </div>
        <div class="m-form__seperator m-form__seperator--dashed"></div>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel', 'Kata Kunci'); ?></label>
            <div class="col-sm-9">
                <p class="form-control-plaintext"> <?php echo $product['keyword']; ?></p>
            </div>
        </div>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel',  'Deskripsi SEO'); ?></label>
            <div class="col-sm-9">
                <p class="form-control-plaintext"> <?php echo $product['description']; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-sm-12">
        <h6><?= __d('AdminPanel',  'Attribute Produk'); ?></h6>
    </div>
</div>
<div class="m-form__seperator m-form__seperator--dashed"></div>
<div class="row mt-3">
    <div class="col-sm-12">
        <?php foreach($product['attributes'] as $k => $vals):?>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?php echo $k; ?></label>
            <div class="col-sm-9">
                <p class="form-control-plaintext"> <?php echo implode(', ',$vals ); ?></p>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>

<div class="row mt-5">
    <div class="col-sm-12">
        <h6><?= __d('AdminPanel',  'Informasi Detail'); ?></h6>
    </div>
</div>
<div class="m-form__seperator m-form__seperator--dashed"></div>


<div class="row mt-3">
    <div class="col-sm-4">
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel',  'Brand'); ?></label>
            <div class="col-sm-7">
                <p class="form-control-plaintext"> <?php echo $product['brand']; ?></p>
            </div>
        </div>

        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel', 'Model'); ?></label>
            <div class="col-sm-8">
                <p class="form-control-plaintext"> <?php echo $product['model']; ?></p>
            </div>
        </div>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel', 'Sku'); ?></label>
            <div class="col-sm-8">
                <p class="form-control-plaintext"> <?php echo $product['sku']; ?></p>
            </div>
        </div>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel',  'Status Stok'); ?></label>
            <div class="col-sm-8">
                <p class="form-control-plaintext"> <?php echo $product['stock_status']; ?></p>
            </div>
        </div>

        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel',  'Barcode'); ?></label>
            <div class="col-sm-8">
                <p class="form-control-plaintext"> <?php echo $product['barcode']; ?></p>
            </div>
        </div>

    </div>
    <div class="col-sm-4">
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-4 col-form-label"><?= __d('AdminPanel',  'Harga Reguler'); ?></label>
            <div class="col-sm-4">
                <div class="input-group">
                    <p class="form-control-plaintext"> <?php echo $product['price']; ?></p>
                </div>
            </div>
        </div>

        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-4 col-form-label"><?= __d('AdminPanel',  'Harga Jual'); ?></label>
            <div class="col-sm-4">
                <div class="input-group">
                    <p class="form-control-plaintext"> <?php echo $product['price_sale']; ?></p>
                </div>
            </div>
        </div>

        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-4 col-form-label"><?= __d('AdminPanel',  'Reward Point'); ?>*</label>
            <div class="col-sm-6">
                <p class="form-control-plaintext"> <?php echo $product['point']; ?></p>
            </div>
        </div>

        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-4 col-form-label"><?= __d('AdminPanel',  'Kode Supplier'); ?></label>
            <div class="col-sm-6">
                <p class="form-control-plaintext"> <?php echo $product['supplier_code']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel',  'Produk Tagging'); ?></label>
            <div class="col-sm-9">
                <p class="form-control-plaintext"> <?php echo implode(', ', $product['tags']); ?></p>
            </div>
        </div>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel',  'Kurir'); ?></label>
            <div class="col-sm-9">
                <p class="form-control-plaintext"> <?php echo implode(', ',$product['couriers']); ?></p>
            </div>
        </div>
        <div class="form-group m-form__group row p-0 ">
            <label class="col-sm-3 col-form-label"><?= __d('AdminPanel',  'Garansi'); ?></label>
            <div class="col-sm-9">
                <p class="form-control-plaintext"> <?php echo $product['warranty']; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-sm-12">
        <h6><?= __d('AdminPanel',  'Embed Video'); ?></h6>
    </div>
</div>
<div class="m-form__seperator m-form__seperator--dashed"></div>
<div class="row mt-3">
    <div class="col-sm-12">
        <div class="form-group m-form__group row p-0 ">
            <div class="col-sm-12">
                <p class="form-control-plaintext"> <?php echo $product['video_url']; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-sm-12">
        <h6><?= __d('AdminPanel',  'Deskripsi Produk'); ?></h6>
        <div class="m-form__seperator m-form__seperator--dashed"></div>
    </div>
    <div class="col-sm-6">
        <div class="form-group m-form__group">
            <label class="col-form-label"><?= __d('AdminPanel',  'Highlight Produk'); ?></label>
            <p class="form-control-plaintext"> <?php echo $product['highlight']; ?></p>
        </div>
    </div>
    <div class="col-sm-5 offset-1">
        <div class="form-group m-form__group">
            <label class="col-form-label"><?= __d('AdminPanel',  'Profil Produk'); ?></label>
            <p class="form-control-plaintext"> <?php echo $product['profile']; ?></p>
        </div>
    </div>
</div>
