<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productCategory
 */
?>


<div class="productCategories view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Parent Category') ?></th>
            <td><?= $productCategory->has('parent_product_category') ? $this->Html->link($productCategory->parent_product_category->name, ['controller' => 'ProductCategories', 'action' => 'view', $productCategory->parent_product_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($productCategory->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Slug') ?></th>
            <td><?= h($productCategory->slug) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($productCategory->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Images') ?></th>
            <td><img src="<?= $this->Url->build('/files/ProductCategories/path/thumbnail-'.$productCategory->path); ?>"> </td>
        </tr>
    </table>
    </div>
</div>
