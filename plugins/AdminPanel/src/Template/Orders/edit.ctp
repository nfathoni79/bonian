<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $order
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
                                        ]
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
                                    <?= $order->has('transactions') ? $order->transactions[count($order->transactions)-1]->payment_type : '-'; ?>
                                </h3>
                            </div>
                        </div>

                        <!--end:: Widgets/Profit Share-->
                    </div>

                    <div class="col-xl-3">

                        <!--begin:: Widgets/Profit Share-->
                        <div class="m-widget14">
                            <div class="m-widget14__header">
                                <h3 class="m-widget14__title">
                                    Masked Card
                                </h3>
                                <span class="m-widget14__desc">
                                    4111 **** **** 1212
                                </span>
                            </div>
                        </div>

                        <!--end:: Widgets/Profit Share-->
                    </div>

                </div>
            </div>
        </div>

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
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
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
                    </div>
                    <?php /*
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="reset" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                                <div class="col-lg-6 m--align-right">
                                    <button type="reset" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div> */ ?>
                </form>

                <!--end::Form-->

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>IMAGE</th>
                            <th>DESCRIPTION</th>
                            <th>SKU</th>
                            <th>QTY</th>
                            <th>PRICE</th>
                            <th>AMOUNT</th>
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
                            <td class="m--font-danger right-align"><?= $this->Number->format($product['total']); ?></td>
                        </tr>
                        <?php $subtotal += $product['total']; endforeach; ?>
                        <tr>
                            <th colspan="5" style="text-align: right;">Subtotal</th>
                            <th class="right-align"><?= $this->Number->format($subtotal); ?></th>
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
    $('select').selectpicker();
</script>

