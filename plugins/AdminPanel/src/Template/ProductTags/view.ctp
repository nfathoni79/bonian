<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productTag
 */
?>


<div class="productTags view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $productTag->has('product') ? $this->Html->link($productTag->product->name, ['controller' => 'Products', 'action' => 'view', $productTag->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tag') ?></th>
            <td><?= $productTag->has('tag') ? $this->Html->link($productTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $productTag->tag->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($productTag->id) ?></td>
        </tr>
    </table>
    </div>
</div>
