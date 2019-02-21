<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productDeal
 */
?>


<div class="productDeals view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($productDeal->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($productDeal->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($productDeal->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Start') ?></th>
            <td><?= h($productDeal->date_start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date End') ?></th>
            <td><?= h($productDeal->date_end) ?></td>
        </tr>
    </table>
    </div>
</div>
