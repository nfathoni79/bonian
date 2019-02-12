<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $option
 */
?>


<div class="options view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($option->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($option->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sort Order') ?></th>
            <td><?= $this->Number->format($option->sort_order) ?></td>
        </tr>
    </table>
    </div>
</div>
