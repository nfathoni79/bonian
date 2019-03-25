<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $order
 */
?>


<div class="orders view large-9 medium-8 columns content">
    <div class="table-responsive">
    <h5>Order</h5>
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Invoice') ?></th>
            <td><?= h($order->invoice) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $order->has('customer') ? $this->Html->link($order->customer->email, ['controller' => 'Customers', 'action' => 'view', $order->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Destination Province') ?></th>
            <td><?= $order->has('province') ? $this->Html->link($order->province->name, ['controller' => 'Provinces', 'action' => 'view', $order->province->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Destination City') ?></th>
            <td><?= $order->has('city') ? $this->Html->link($order->city->name, ['controller' => 'Cities', 'action' => 'view', $order->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Destination Subdistrict') ?></th>
            <td><?= $order->has('subdistrict') ? $this->Html->link($order->subdistrict->name, ['controller' => 'Subdistricts', 'action' => 'view', $order->subdistrict->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Destination Address') ?></th>
            <td><?= $order->address ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher') ?></th>
            <td><?= $order->has('voucher') ? $this->Html->link($order->voucher->id, ['controller' => 'Vouchers', 'action' => 'view', $order->voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Promotion') ?></th>
            <td><?= $order->has('product_promotion') ? $this->Html->link($order->product_promotion->name, ['controller' => 'ProductPromotions', 'action' => 'view', $order->product_promotion->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Use Point') ?></th>
            <td><?= $this->Number->format($order->use_point) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gross Total') ?></th>
            <td><?= $this->Number->format($order->gross_total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= $this->Number->format($order->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Status') ?></th>
            <td><?php
                $statuses = [1 => 'Pending', 2 => 'Success', 3 => 'Failed'];
                echo $statuses[$order->payment_status];
                ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($order->created) ?></td>
        </tr>
    </table>

    <h5>Order Details</h5>
    <table class="table table-hover table-striped">
        <?php foreach($order->order_details as $key => $val) : ?>
        <tr>
            <th scope="row"><?= __('Branch') ?></th>
            <td><?= h($val->branch->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shipping Code') ?></th>
            <td><?= h($val->shipping_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shipping Service') ?></th>
            <td><?= h($val->shipping_service) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shipping Weight') ?></th>
            <td><?= h($val->shipping_weight) ?> grams</td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shipping Cost') ?></th>
            <td><?= h($val->shipping_cost) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Status') ?></th>
            <td><?= h($val->order_status->name) ?></td>
        </tr>
        <tr style="background: none;">
            <td colspan="2">
                <table class="table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Variant</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($val->order_detail_products as $product) : ?>
                        <tr>
                            <td>
                                <?php if ($product['product']['product_images']) : ?>
                                    <img src="<?= $this->Url->build('/images/50x50/' . $product['product']['product_images'][0]['name']); ?>" alt="image" />
                                <?php endif; ?>
                            </td>
                            <td><?= $product['product']['name']; ?></td>
                            <td><?= $product['product_option_price']['sku']; ?></td>
                            <td><?= $product['qty']; ?></td>
                            <td><?= $product['price']; ?></td>
                            <td>Variant</td>
                            <td><?= $product['total']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
</div>
