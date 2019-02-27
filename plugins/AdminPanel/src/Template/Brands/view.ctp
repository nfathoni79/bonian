<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $brand
 */
?>


<div class="brands view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Product Category') ?></th>
            <td><?= $brand->has('product_category') ? $this->Html->link($brand->product_category->name, ['controller' => 'ProductCategories', 'action' => 'view', $brand->product_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Brand') ?></th>
            <td><?= $brand->has('parent_brand') ? $this->Html->link($brand->parent_brand->name, ['controller' => 'Brands', 'action' => 'view', $brand->parent_brand->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($brand->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($brand->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($brand->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($brand->rght) ?></td>
        </tr>
    </table>
    </div>
</div>
