<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $subdistrict
 */
?>


<div class="subdistricts view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $subdistrict->has('city') ? $this->Html->link($subdistrict->city->name, ['controller' => 'Cities', 'action' => 'view', $subdistrict->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($subdistrict->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($subdistrict->id) ?></td>
        </tr>
    </table>
    </div>
</div>
