<?php
/**
 * @var \App\View\AppView $this
 * @var \AdminPanel\Model\Entity\Order $order
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Order') ?>
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
                                <?= __('Order') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('List Order') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Edit Order') ?>
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="m-content">
        <?php  echo $this->Flash->render(); ?>
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <?= __('Order') ?> #<?= $order->invoice; ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-3">

                        <!--begin:: Widgets/Daily Sales-->
                        <div class="m-widget14">
                            <div class="m-widget14__header m--margin-bottom-15">
                                <span class="m-widget14__desc">
                                    Order Date
                                </span>
                                <h3 class="m-widget14__title">
                                    <?= $order->created->format('d/m/Y'); ?>
                                </h3>
                            </div>
                        </div>

                        <!--end:: Widgets/Daily Sales-->
                    </div>
                    <div class="col-xl-3">

                        <!--begin:: Widgets/Profit Share-->
                        <div class="m-widget14">
                            <div class="m-widget14__header">
                                <span class="m-widget14__desc d-block">
                                    Payment Status
                                </span>
                                <?php
                                    $payment_statuses = [
                                        '1' => [
                                                'name' => 'Pending',
                                                'class' => 'm-badge--default'
                                        ],
                                        '2' => [
                                            'name' => 'Success',
                                            'class' => 'm-badge--success'
                                        ],
                                        '3' => [
                                            'name' => 'Failed',
                                            'class' => 'm-badge--danger'
                                        ],
                                        '4' => [
                                            'name' => 'Expired',
                                            'class' => 'm-badge--danger'
                                        ],
                                        '5' => [
                                            'name' => 'Refund',
                                            'class' => 'm-badge--danger'
                                        ],
                                        '6' => [
                                            'name' => 'Cancel',
                                            'class' => 'm-badge--danger'
                                        ],
                                    ];

                                ?>
                                <span class="m-badge <?= $payment_statuses[$order->payment_status]['class']; ?> m-badge--wide"><?= $payment_statuses[$order->payment_status]['name']; ?></span>
                            </div>
                        </div>

                        <!--end:: Widgets/Profit Share-->
                    </div>

                    <div class="col-xl-3">

                        <!--begin:: Widgets/Profit Share-->
                        <div class="m-widget14">
                            <div class="m-widget14__header">
                                <span class="m-widget14__desc">
                                    Payment Method
                                </span>
                                <h3 class="m-widget14__title">
                                    <?= $order->has('transactions') && count($order->transactions) > 0 ? $order->transactions[count($order->transactions)-1]->payment_type : '-'; ?>
                                </h3>
                            </div>
                        </div>

                        <!--end:: Widgets/Profit Share-->
                    </div>

                    <div class="col-xl-3">

                        <!--begin:: Widgets/Profit Share-->
                        <div class="m-widget14">
                            <div class="m-widget14__header">
                                <span class="m-widget14__desc">
                                    Amount
                                </span>
                                <h3 class="m-widget14__title">
                                    <?= $this->Number->format($order->total); ?>
                                </h3>
                            </div>
                        </div>

                        <!--end:: Widgets/Profit Share-->
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Order Detail') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>

                    <?php $shipping_cost = 0;?>
                    <?php foreach($order->order_details as $key => $val) : ?>
                    <?php $shipping_cost += $val->shipping_cost;?>
                    <?php endforeach;?>

                    <div class="m-portlet__body">
                        <div class="m-widget16">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="m-widget16__head">
                                        <div class="m-widget16__item">
                                            <span class="m-widget16__sceduled">
                                                Type
                                            </span>
                                            <span class="m-widget16__amount m--align-right">
                                                Value
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-widget16__body">
                                        <!--begin::widget item-->
                                        <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Shop Amount
                                                </span>
                                            <span class="m-widget16__price m--align-right">
                                                <?= $this->Number->format($order->gross_total - $shipping_cost); ?>
                                            </span>
                                        </div>
                                        <?php if ($order->order_type == 1) :?>
                                        <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Shipping Cost
                                                </span>
                                            <span class="m-widget16__price m--align-right">
                                                +<?= $this->Number->format($shipping_cost); ?>
                                            </span>
                                        </div>
                                        <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Gross Total
                                                </span>
                                            <span class="m-widget16__price m--align-right">
                                                <?= $this->Number->format($order->gross_total); ?>
                                            </span>
                                        </div>
                                        <!--end::widget item-->

                                        <!--begin::widget item-->
                                        <div class="m-widget16__item">
                                            <span class="m-widget16__date">
                                                Using Point
                                            </span>
                                            <span class="m-widget16__price m--align-right">
                                                -<?= $this->Number->format($order->use_point); ?>
                                            </span>
                                        </div>
                                        <!--end::widget item-->

                                        <?php if ($order->has('voucher_id')) : ?>
                                            <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Voucher Amount
                                                </span>
                                                <span class="m-widget16__price m--align-right">
                                                    -<?= $this->Number->format($order->discount_voucher); ?>
                                                </span>
                                            </div>
                                            <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Code Voucher
                                                </span>
                                                <span class="m-widget16__price m--align-right">
                                                    -<?= $order->voucher->get('code_voucher'); ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>

                                        <div class="m-widget16__item">
                                            <span class="m-widget16__date">
                                                Coupon Amount
                                            </span>
                                            <span class="m-widget16__price m--align-right">
                                                -<?= $this->Number->format($order->discount_kupon); ?>
                                            </span>
                                        </div>
                                        <?php endif; ?>

                                        <!--begin::widget item-->
                                        <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Net Total
                                                </span>
                                            <span class="m-widget16__price m--align-right">
                                                <?= $this->Number->format($order->total); ?>
                                                </span>
                                        </div>
                                        <!--end::widget item-->


                                    </div>
                                </div>
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-5">
                                    <?php if ($order->has('transactions') && count($order->transactions) > 0) : ?>
                                    <div class="m-widget16__head">
                                        <div class="m-widget16__item">
															<span class="m-widget16__sceduled">
																Type
															</span>
                                            <span class="m-widget16__amount m--align-right">
																Value
															</span>
                                        </div>
                                    </div>
                                    <div class="m-widget16__body">

                                            <?php $transaction = $order->transactions[count($order->transactions) - 1]; ?>
                                            <!--begin::widget item-->
                                            <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Transaction Time
                                                </span>
                                                <span class="m-widget16__price m--align-right">
                                                    <?= $transaction->get('transaction_time'); ?>
                                                </span>
                                            </div>
                                            <!--end::widget item-->

                                            <!--begin::widget item-->
                                            <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Transaction Status
                                                </span>
                                                <span class="m-widget16__price m--align-right">
                                                    <?= $transaction->get('transaction_status'); ?>
                                                </span>
                                            </div>
                                            <!--end::widget item-->

                                            <!--begin::widget item-->
                                            <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Fraud Status
                                                </span>
                                                <span class="m-widget16__price m--align-right">
                                                    <?= $transaction->get('fraud_status'); ?>
                                                </span>
                                            </div>
                                            <!--end::widget item-->

                                            <?php if ($bank = $transaction->get('bank')) : ?>
                                                <!--begin::widget item-->
                                                <div class="m-widget16__item">
                                                        <span class="m-widget16__date">
                                                            Bank
                                                        </span>
                                                    <span class="m-widget16__price m--align-right">
                                                            <?= $bank; ?>
                                                        </span>
                                                </div>
                                                <!--end::widget item-->
                                            <?php endif; ?>

                                            <?php if ($va_number = $transaction->get('va_number')) : ?>
                                                <!--begin::widget item-->
                                                <div class="m-widget16__item">
                                                            <span class="m-widget16__date">
                                                                VA Number
                                                            </span>
                                                    <span class="m-widget16__price m--align-right">
                                                                <?= $va_number; ?>
                                                            </span>
                                                </div>
                                                <!--end::widget item-->
                                            <?php endif; ?>

                                            <?php if ($masked_card = $transaction->get('masked_card')) : ?>
                                            <?php
                                                if (preg_match('/^(\d+)-(\d+)/i', $masked_card, $matched)) {
                                                    $masked_card = substr($matched[1], 0, 4) . ' ' .
                                                        substr($matched[1], 4, 6) .
                                                        '** **** ' .
                                                        $matched[2];
                                                }
                                            ?>
                                            <!--begin::widget item-->
                                            <div class="m-widget16__item">
                                                    <span class="m-widget16__date">
                                                        Masked Card
                                                    </span>
                                                <span class="m-widget16__price m--align-right">
                                                        <?= $masked_card; ?>
                                                    </span>
                                            </div>
                                            <!--end::widget item-->
                                            <?php endif; ?>


                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">

                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <?= __('Customer Detail') ?>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>


                    <div class="m-portlet__body">
                        <div class="m-widget16">
                            <div class="m-widget16__head">
                                <div class="m-widget16__item">
                                    <span class="m-widget16__sceduled">
                                        Type
                                    </span>
                                    <span class="m-widget16__amount m--align-right">
                                        Value
                                    </span>
                                </div>
                            </div>
                            <div class="m-widget16__body">
                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Full Name
                                                </span>
                                    <span class="m-widget16__price m--align-right">
                                                    <?= $order->customer->get('first_name'); ?>
                                                    <?= $order->customer->get('last_name'); ?>
                                                </span>
                                </div>
                                <!--end::widget item-->

                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Email
                                                </span>
                                    <span class="m-widget16__price m--align-right">
                                                    <?= $order->customer->get('email'); ?>
                                                </span>
                                </div>
                                <!--end::widget item-->
                                <?php if ($order->order_type == 1) : ?>
                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Destination Province
                                                </span>
                                    <span class="m-widget16__price m--align-right">
                                                    <?= $order->province->get('name'); ?>
                                                </span>
                                </div>
                                <!--end::widget item-->
                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Destination City
                                                </span>
                                    <span class="m-widget16__price m--align-right">
                                                    <?= $order->city->get('name'); ?>
                                                </span>
                                </div>
                                <!--end::widget item-->

                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Destination Subdistrict
                                                </span>
                                    <span class="m-widget16__price m--align-right">
                                                    <?= $order->subdistrict->get('name'); ?>
                                                </span>
                                </div>
                                <!--end::widget item-->

                                <!--begin::widget item-->
                                <div class="m-widget16__item">
                                                <span class="m-widget16__date">
                                                    Destination Address
                                                </span>
                                    <span class="m-widget16__price m--align-right">
                                                    <?= $order->get('address'); ?>
                                                </span>
                                </div>
                                <!--end::widget item-->
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php if ($order->order_type == 2): ?>
        <?php $status_transaction_digital = [
                0 => 'Pending',
                1 => 'Success',
                2 => 'Failed'
        ]; ?>
        <?php foreach($order->order_digitals as $val) : ?>
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                           Digital Produk
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>



            <div class="m-portlet__body">
                <!--begin::Form-->
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label>Tipe Produk:</label>
                            <div style="font-weight: bolder"><?= $val->digital_detail->operator ?> <?= $val->digital_detail->type ?></div>
                        </div>
                        <div class="col-lg-6">
                            <label class="">Nomor Tujuan :</label>
                            <div style="font-weight: bolder"><?= $val->customer_number; ?></div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label>Denom:</label>
                            <div style="font-weight: bolder"><?= $this->Number->format($val->digital_detail->denom); ?></div>
                        </div>
                        <div class="col-lg-6">
                            <label class="">Status Transaksi :</label>
                            <div style="font-weight: bolder"><?= $status_transaction_digital[$val->digital_detail->status]; ?></div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php foreach($order->order_details as $key => $val) : ?>
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <?= __('Origin') ?> <?= $val['branch']['name']; ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>



            <div class="m-portlet__body">
                <!--begin::Form-->
                    <?= $this->Form->create($order,['class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed']); ?>
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>Shipping Code:</label>
                                <div><?= strtoupper($val->shipping_code); ?> - <?= strtoupper($val->shipping_service); ?></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">Shipping Weight:</label>
                                <div><?= $val->shipping_weight / 1000; ?> Kg</div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>Origin Province:</label>
                                <div><?= $val->province->name; ?></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">Origin City:</label>
                                <div><?= $val->city->name; ?></div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>Origin Subdistrict:</label>
                                <div><?= $val->subdistrict->name; ?></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="">Shipping Cost:</label>
                                <div><?= $this->Number->format($val->shipping_cost); ?></div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-6">
                                <label>Awb:</label>
                                <?= $this->Form->input('origin.' . $val['branch_id'] . '.awb', [
                                    'value' => $val['awb'],
                                    'div' => false,
                                    'label' => false,
                                    'class' => 'form-control m-input col-lg-4 form-event-changed',
                                    'placeholder' => 'Input no. awb disini'
                                ]); ?>
                            </div>

                            <div class="col-lg-6">
                                <label style="display: block;">Order Status:</label>
                                <?= $this->Form->select('origin.' . $val['branch_id'] . '.order_status_id',
                                    $order_detail_statuses,
                                    [
                                        'value' => $val['order_status_id'],
                                        'div' => false,
                                        'label' => false,
                                        'class' => 'form-control m-input col-lg-4 form-event-changed',
                                        'style' => 'display: block;',
                                        'empty' => '-'
                                    ]); ?>
                            </div>

                        </div>
                    </div>

                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit form-action" style="display: none;">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary button-reset">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>

                <!--end::Form-->

                <div class="table-responsive" >
                    <table class="table">
                        <thead>
                        <tr>
                            <th>IMAGE</th>
                            <th>DESCRIPTION</th>
                            <th>SKU</th>
                            <th>QTY</th>
                            <th>PRICE</th>
                            <th style="text-align: right;">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $subtotal = 0; foreach($val->order_detail_products as $product) : ?>
                        <tr>
                            <td>
                                <?php foreach($product['product']['product_images'] as $image) : ?>
                                    <?php if ($product['product_option_price']['idx'] == $image['idx']) : ?>
                                        <img src="<?= $this->Url->build('/images/70x70/' . $image['name']); ?>" alt="image" />
                                    <?php break; endif; ?>
                                <?php endforeach; ?>

                            </td>
                            <td>
                                <?= $product['product']['name']; ?>
                                <?php if(!empty($product['comment'])) : ?>
                                    <span style="font-style: italic; display: block; color: #999; font-size:11px;">
                                        Note: <?= h($product['comment']); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><?= $product['product_option_price']['sku']; ?></td>
                            <td><?= $product['qty']; ?></td>
                            <td><?= $this->Number->format($product['price']); ?></td>
                            <td class="m--font-danger" style="text-align: right;"><?= $this->Number->format($product['total']); ?></td>
                        </tr>
                        <?php $subtotal += $product['total']; endforeach; ?>
                        <tr>
                            <th colspan="5" style="text-align: right;">Subtotal</th>
                            <th style="text-align: right;"><?= $this->Number->format($subtotal); ?></th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right;">Shipping</th>
                            <th style="text-align: right;"><?= $this->Number->format($val->shipping_cost); ?></th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right;">Total</th>
                            <th style="text-align: right;"><?= $this->Number->format($subtotal + $val->shipping_cost); ?></th>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <?php endforeach; ?>



    </div>
</div>
<script>
    $(document).ready(function(){
        $('select').selectpicker();
        $('.form-event-changed').on('change', function(){
            $(this).parents('form').find('.form-action').show();
        });
        $('.button-reset').click(function() {
           $(this).parents('.form-action').hide();
        });
    });
</script>

