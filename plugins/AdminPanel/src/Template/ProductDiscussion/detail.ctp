<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title">
                    Diskusi produk
                </h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-xl-12">

                    <div class="m-portlet m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Diskusi Produk
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="row">
                                <div class="col-xl-4">

                                    <div class="m-widget5">
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__content">
                                                <div class="m-widget5__pic">
                                                    <?php foreach($product['product_images'] as $vals): ?>
                                                    <img class="m-widget7__img" src="<?= $this->Url->build('/images/112x112/'.$vals['name']);?>"  alt="">
                                                    <?php break;?>
                                                    <?php endforeach;?>
                                                </div>
                                                <div class="m-widget5__section">
                                                    <h4 class="m-widget5__title">
                                                        <?= $product['name'];?>
                                                    </h4>
                                                    <div class="m-widget5__desc">
                                                        <a href="<?= $this->Url->build($_baseFront .'products/detail/' .  $product['slug']);?>" target="_blank" class="btn btn-primary btn-sm m-btn m-btn--custom">Pratinjau Halaman Produk</a>
                                                    </div>
                                                    <div class="m-widget5__info">
                                                <span class="m-widget5__author">
                                                    SKU : <?= $product['sku'];?>
                                                </span>
                                                    </div>
                                                    <div class="m-widget5__info">
                                                <span class="m-widget5__author">
                                                    Harga
                                                </span>
                                                        <span class="m-widget5__info-date m--font-info">
                                                    Rp. <?= $this->Number->format($product['price_sale']);?>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget5__content">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="m-widget3">
                                        <?php foreach($discuss as $discus):?>
                                        <div class="m-widget3__item">
                                            <div class="m-widget3__header">
                                                <div class="m-widget3__user-img">
                                                    <img class="m-widget3__img" src="<?= $this->Url->build('/files/Customers/avatar/thumbnail-'.$discus['customer']['avatar']);?>" alt="">
                                                </div>
                                                <div class="m-widget3__info">
                                            <span class="m-widget3__username">
                                                <?= $discus['customer']['full_name'];?>
                                            </span><br>
                                                    <span class="m-widget3__time">
                                                <?php
                                                    echo $this->Time->timeAgoInWords(
                                                           $discus['created'], array(
                                                            'end' => '+10 year',
                                                            'format' => 'F jS, Y',
                                                            'accuracy' => array('second' => 'second')
                                                        )
                                                    );
                                                ?>
                                            </span>
                                                </div>
                                            </div>
                                            <div class="m-widget3__body">
                                                <p class="m-widget3__text">
                                                    <?= $discus['comment'];?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php if(!empty($discus['children'])):?>
                                        <?php foreach($discus['children'] as $val):?>
                                        <div class="m-widget3__item m--margin-left-50">
                                            <div class="m-widget3__header">
                                                <div class="m-widget3__user-img">
                                                    <img class="m-widget3__img" src="<?= $this->Url->build('/files/Customers/avatar/thumbnail-'.$val['customer']['avatar']);?>" alt="">
                                                </div>
                                                <div class="m-widget3__info">
                                                    <span class="m-widget3__username">
                                                        <?= $val['customer']['full_name'];?>
                                                    </span><br>
                                                    <span class="m-widget3__time">
                                                        <?php
                                                            echo $this->Time->timeAgoInWords(
                                                                   $val['created'], array(
                                                                    'end' => '+10 year',
                                                                    'format' => 'F jS, Y',
                                                                    'accuracy' => array('second' => 'second')
                                                                )
                                                            );
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="m-widget3__body">
                                                <p class="m-widget3__text">
                                                    <?= $val['comment'];?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php endforeach;?>
                                        <?php else:?>

                                        <?php endif;?>
                                        <?php endforeach;?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->append('script'); ?>
<script>

</script>
<?php $this->end(); ?>


