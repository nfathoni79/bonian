<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $product
 */
?>


<div class="products view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($product->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($product->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($product->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model') ?></th>
            <td><?= h($product->model) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Code') ?></th>
            <td><?= h($product->code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sku') ?></th>
            <td><?= h($product->sku) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Isbn') ?></th>
            <td><?= h($product->isbn) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Stock Status') ?></th>
            <td><?= $product->has('product_stock_status') ? $this->Html->link($product->product_stock_status->name, ['controller' => 'ProductStockStatuses', 'action' => 'view', $product->product_stock_status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Weight Class') ?></th>
            <td><?= $product->has('product_weight_class') ? $this->Html->link($product->product_weight_class->name, ['controller' => 'ProductWeightClasses', 'action' => 'view', $product->product_weight_class->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Status') ?></th>
            <td><?= $product->has('product_status') ? $this->Html->link($product->product_status->name, ['controller' => 'ProductStatuses', 'action' => 'view', $product->product_status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($product->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Qty') ?></th>
            <td><?= $this->Number->format($product->qty) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shipping') ?></th>
            <td><?= $this->Number->format($product->shipping) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($product->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price Discount') ?></th>
            <td><?= $this->Number->format($product->price_discount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Weight') ?></th>
            <td><?= $this->Number->format($product->weight) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('View') ?></th>
            <td><?= $this->Number->format($product->view) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($product->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($product->modified) ?></td>
        </tr>
    </table>
    </div>
</div>
