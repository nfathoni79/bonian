<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $faq
 */
?>


<div class="faqs view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Faq Category') ?></th>
            <td><?= $faq->has('faq_category') ? $this->Html->link($faq->faq_category->name, ['controller' => 'FaqCategories', 'action' => 'view', $faq->faq_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Judul') ?></th>
            <td><?= h($faq->judul) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($faq->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($faq->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($faq->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($faq->modified) ?></td>
        </tr>
    </table>
    </div>
</div>
