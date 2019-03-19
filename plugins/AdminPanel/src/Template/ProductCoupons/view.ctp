<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productCoupon
 */
?>


<div class="productCoupons view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $productCoupon->has('product') ? $this->Html->link($productCoupon->product->name, ['controller' => 'Products', 'action' => 'view', $productCoupon->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($productCoupon->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($productCoupon->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($productCoupon->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expired') ?></th>
            <td><?= h($productCoupon->expired) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($productCoupon->created) ?></td>
        </tr>
    </table>
    </div>
</div>
