<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $optionValue
 */
?>


<div class="optionValues view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Option') ?></th>
            <td><?= $optionValue->has('option') ? $this->Html->link($optionValue->option->name, ['controller' => 'Options', 'action' => 'view', $optionValue->option->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($optionValue->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($optionValue->id) ?></td>
        </tr>
    </table>
    </div>
</div>
