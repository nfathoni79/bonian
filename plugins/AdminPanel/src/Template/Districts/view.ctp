<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $district
 */
?>


<div class="districts view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Regency') ?></th>
            <td><?= $district->has('regency') ? $this->Html->link($district->regency->name, ['controller' => 'Regencies', 'action' => 'view', $district->regency->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($district->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($district->id) ?></td>
        </tr>
    </table>
    </div>
</div>
