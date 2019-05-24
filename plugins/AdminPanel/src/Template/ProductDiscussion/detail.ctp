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
                                    <div class="m--margin-bottom-10" style="height: 400px; overflow: scroll">
                                    <?php foreach($discuss as $discus):?>

                                    <div class="m-portlet m-portlet--skin-dark">
                                        <div class="m-portlet__body">
                                            <div class="m-widget3">
                                                <div class="m-widget3__item ">
                                                    <div class="m-widget3__header">
                                                        <div class="m-widget3__user-img">
                                                            <img class="m-widget3__img" src="<?= $this->Url->build('/files/Customers/avatar/thumbnail-'.$discus['customer']['avatar']);?>" alt="">
                                                        </div>
                                                        <div class="m-widget3__info">
                                                            <span class="m-widget3__username text-white">
                                                                <?= $discus['customer']['full_name'];?>
                                                            </span>
                                                            <br>
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
                                                        <a href="javascript:void(0);" class="m-widget3__status m--font-brand reply-msg" data-to="<?= $discus['customer_id'];?>"  data-for-name="<?= $discus['customer']['full_name']?>" data-for-id="<?= $discus['id']?>">
                                                                Balas
                                                            </a>
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
                                                                <span class="m-widget3__username text-white">
                                                                    <?= $val['is_admin'] ? 'Administrator - '.$val['user']['first_name'] : $val['customer']['full_name'];?>
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
                                                            <?php if($val['customer_id'] != 0): ?>
                                                            <a href="javascript:void(0);" class="m-widget3__status m--font-brand reply-msg" data-for-name="<?= $val['customer']['full_name']?>" data-to="<?= $val['customer_id'];?>" data-for-id="<?= $discus['id']?>">
                                                                Balas
                                                            </a>
                                                            <?php endif;?>
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

                                            </div>

                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                    </div>
                                    <?= $this->Form->create(null,[ 'id' => 'comment', 'style'=>'display:none;']); ?>

                                        <span class="msg-for" style="display:none;"></span>
                                        <input type="hidden" id="forId" name="parent_id" value="">
                                        <input type="hidden"  name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="hidden"  name="to_customer" id="to" value="">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group m-form__group row">
                                                    <?php echo $this->Form->control('comment', ['type' => 'textarea', 'class' => 'form-control m-input', 'rows' => '3', 'label' => false, 'div' => false,'placeholder' => 'Tulis diskusi anda disini', 'id' => 'komentar'])?>
                                                </div>
                                                <div class="m-form__actions">
                                                    <?= $this->Form->submit(__('Submit'),['class' => 'btn btn-brand']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?= $this->Form->end(); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->Html->script([
'/admin-assets/vendors/custom/libs/validation-render',
], ['block' => true]);
?>


<?php $this->append('script'); ?>
<script>
    $('.reply-msg').on('click',function(){
        var name = $(this).data('for-name');
        var id = $(this).data('for-id');
        var to = $(this).data('to');
        $('.msg-for').html('Silahkan tulis diskusi untuk '+name).show();
        $('#forId').val(id);
        $('#to').val(to);
        $('#comment').show();

        // var x = $('#comment').offset().top - 300;
        // jQuery('html,body').animate({scrollTop: x}, 500);
        $("#komentar").focus();
    });

    var formEl = $("#comment");
    var url = '<?= $this->Url->build(['action' => 'add']); ?>';
    var ajaxRequest = new ajaxValidation(formEl);
    ajaxRequest.setblockUI('.m-portlet m-portlet--mobile');


    $("#comment").submit(function(e) {
        console.log(formEl.find(':input'));
        ajaxRequest.post(url, formEl.find(':input'), function(data,saved) {
            // if (data.success) {
            //     location.reload();
            // }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
    //
    // $('#comment').on('submit', function(e){
    //     // Prevent actual form submission
    //     e.preventDefault();
    //
    //     var formEl = $("#comment");
    //     var ajaxRequest = new ajaxValidation(formEl);
    //     // ajaxRequest.setblockUI('.m-portlet__body');
    //     var datax = formEl.find(':input');
    //     ajaxRequest.post("<?= $this->Url->build(['action' => 'add']); ?>", datax, function(data, saved) {
    //         // if (data.success) {
    //             // location.href = '';
    //         // }
    //     });
    //
    // });

</script>
<?php $this->end(); ?>


