<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $village
 */
?>


<div class="villages view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('District') ?></th>
            <td><?= $village->has('district') ? $this->Html->link($village->district->name, ['controller' => 'Districts', 'action' => 'view', $village->district->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($village->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($village->id) ?></td>
        </tr>
    </table>
    </div>
</div>
