<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $branch
 */
?>


<div class="branches view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($branch->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($branch->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Province') ?></th>
            <td><?= $branch->has('province') ? $this->Html->link($branch->province->name, ['controller' => 'Provinces', 'action' => 'view', $branch->province->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $branch->has('city') ? $this->Html->link($branch->city->name, ['controller' => 'Cities', 'action' => 'view', $branch->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subdistrict') ?></th>
            <td><?= $branch->has('subdistrict') ? $this->Html->link($branch->subdistrict->name, ['controller' => 'Subdistricts', 'action' => 'view', $branch->subdistrict->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($branch->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Latitude') ?></th>
            <td><?= $this->Number->format($branch->latitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Longitude') ?></th>
            <td><?= $this->Number->format($branch->longitude) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($branch->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($branch->modified) ?></td>
        </tr>
    </table>
    </div>
</div>
