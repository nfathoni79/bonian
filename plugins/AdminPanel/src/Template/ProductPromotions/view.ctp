<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productPromotion
 */
?>


<div class="productPromotions view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($productPromotion->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $productPromotion->has('product') ? $this->Html->link($productPromotion->product->name, ['controller' => 'Products', 'action' => 'view', $productPromotion->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($productPromotion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Id') ?></th>
            <td><?= $this->Number->format($productPromotion->product_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Qty') ?></th>
            <td><?= $this->Number->format($productPromotion->qty) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Min Qty') ?></th>
            <td><?= $this->Number->format($productPromotion->min_qty) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Free Qty') ?></th>
            <td><?= $this->Number->format($productPromotion->free_qty) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Start') ?></th>
            <td><?= h($productPromotion->date_start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date End') ?></th>
            <td><?= h($productPromotion->date_end) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($productPromotion->created) ?></td>
        </tr>
    </table>
    </div>
</div>
