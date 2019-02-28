<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $attribute
 */
?>


<div class="attributes view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Parent Attribute') ?></th>
            <td><?= $attribute->has('parent_attribute') ? $this->Html->link($attribute->parent_attribute->name, ['controller' => 'Attributes', 'action' => 'view', $attribute->parent_attribute->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Category') ?></th>
            <td><?= $attribute->has('product_category') ? $this->Html->link($attribute->product_category->name, ['controller' => 'ProductCategories', 'action' => 'view', $attribute->product_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($attribute->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($attribute->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($attribute->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($attribute->rght) ?></td>
        </tr>
    </table>
    </div>
</div>
