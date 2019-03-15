<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $brands
 * nevix
 */
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    <?= __('Pelanggan') ?>
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="#" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Pelanggan') ?>
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Networking') ?>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <?= __('Networking'); ?>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>
                <div class="m_datatable" >
                    <table class="table table-striped table-bordered table-hover table-checkable" id="table-network">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
$this->Html->css([
'/admin-assets/vendors/custom/datatables/datatables.bundle.css'
], ['block' => true]);
$this->Html->script([
'/admin-assets/vendors/custom/datatables/datatables.bundle',
'/admin-assets/app/js/dataTables.treeGrid',
'/admin-assets/vendors/custom/libs/validation-render',
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>
    // https://homfen.github.io/dataTables.treeGrid.js/arrays.txt?_=1552616209951
    var columns = [
        {
            title: '',
            target: 0,
            className: 'treegrid-control',
            data: function (item) {
                if (jQuery.isEmptyObject(item.children)) {
                    return '';
                }
                return '<span>+</span>';
            }
        },
        {
            title: 'Username',
            target: 1,
            data: function (item) {
                return item.customer.username;
            }
        },
        {
            title: 'Alamat Email',
            target: 2,
            data: function (item) {
                return item.customer.email;
            }
        },
        {
            title: 'Sponsor',
            target: 3,
            data: function (item) {
                return item.refferal.username;
            }
        },
        {
            title: 'Level Kedalaman',
            target: 4,
            data: function (item) {
                return 'Level '+item.level;
            }
        },
        {
            title: 'Tanggal',
            target: 5,
            data: function (item) {
                return item.created;
            }
        },
    ];
    $('#table-network').DataTable({
        'columns': columns,
        ajax: {
            url: "<?= $this->Url->build(['action' => 'network']); ?>",
            data: {
                pagination: {
                    perpage: 1,
                },
                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
            },
        },
        'treeGrid': {
            'left': 10,
            'expandIcon': '<span>+</span>',
            'collapseIcon': '<span>-</span>'
        }
    });
</script>
<?php $this->end(); ?>



