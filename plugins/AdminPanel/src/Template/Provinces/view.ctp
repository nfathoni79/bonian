<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $province
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Province'), ['action' => 'edit', $province->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Province'), ['action' => 'delete', $province->id], ['confirm' => __('Are you sure you want to delete # {0}?', $province->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Provinces'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Province'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customer Addresses'), ['controller' => 'CustomerAddresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Address'), ['controller' => 'CustomerAddresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Regencies'), ['controller' => 'Regencies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Regency'), ['controller' => 'Regencies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="provinces view large-9 medium-8 columns content">
    <h3><?= h($province->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($province->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($province->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Customer Addresses') ?></h4>
        <?php if (!empty($province->customer_addresses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Province Id') ?></th>
                <th scope="col"><?= __('Regency Id') ?></th>
                <th scope="col"><?= __('District Id') ?></th>
                <th scope="col"><?= __('Village Id') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($province->customer_addresses as $customerAddresses): ?>
            <tr>
                <td><?= h($customerAddresses->id) ?></td>
                <td><?= h($customerAddresses->customer_id) ?></td>
                <td><?= h($customerAddresses->province_id) ?></td>
                <td><?= h($customerAddresses->regency_id) ?></td>
                <td><?= h($customerAddresses->district_id) ?></td>
                <td><?= h($customerAddresses->village_id) ?></td>
                <td><?= h($customerAddresses->address) ?></td>
                <td><?= h($customerAddresses->created) ?></td>
                <td><?= h($customerAddresses->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CustomerAddresses', 'action' => 'view', $customerAddresses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CustomerAddresses', 'action' => 'edit', $customerAddresses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CustomerAddresses', 'action' => 'delete', $customerAddresses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerAddresses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Regencies') ?></h4>
        <?php if (!empty($province->regencies)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Province Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($province->regencies as $regencies): ?>
            <tr>
                <td><?= h($regencies->id) ?></td>
                <td><?= h($regencies->province_id) ?></td>
                <td><?= h($regencies->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Regencies', 'action' => 'view', $regencies->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Regencies', 'action' => 'edit', $regencies->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Regencies', 'action' => 'delete', $regencies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $regencies->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
