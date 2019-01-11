<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $regency
 */
?>


<div class="regencies view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Province') ?></th>
            <td><?= $regency->has('province') ? $this->Html->link($regency->province->name, ['controller' => 'Provinces', 'action' => 'view', $regency->province->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($regency->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($regency->id) ?></td>
        </tr>
    </table>
    </div>
</div>
