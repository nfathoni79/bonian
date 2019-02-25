<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $gameWheel
 */
?>


<div class="gameWheels view large-9 medium-8 columns content">
    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th scope="row"><?= __('Product Name') ?></th>
            <td><?= h($gameWheel->product_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($gameWheel->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Probability') ?></th>
            <td><?= $this->Number->format($gameWheel->probability) ?></td>
        </tr>
    </table>
    </div>
</div>
