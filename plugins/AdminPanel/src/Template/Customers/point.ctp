<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $customers
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
                        <a href="<?= $this->Url->build(); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                <?= __('Mutasi Point') ?>
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
                            <?= __('Mutasi Point') ?>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-8">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input" placeholder="Pencarian..." id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m_datatable" id="table-points"></div>

            </div>
        </div>
    </div>
</div>
<?php
    if(!empty($this->request->params['pass'][0])){
        $requestUrl = $this->Url->build(['action' => 'point']).'/'.$this->request->params['pass'][0];
    }else{
        $requestUrl = $this->Url->build();
    }
?>

<?php
$this->Html->css([
'/admin-assets/vendors/custom/datatables/datatables.bundle.css'
], ['block' => true]);
$this->Html->script([
'/admin-assets/vendors/custom/datatables/datatables.bundle'
], ['block' => true]);
?>
<?php $this->append('script'); ?>
<script>

    var DatatableRemoteAjaxDemo = function() {
        var demo = function() {
            var datatable = $('#table-points').mDatatable({
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            method: 'POST',
                            url: '<?= $requestUrl; ?>',
                            cache: false,
                            params: {
                                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
                            },
                            map: function(raw) {
                                var dataSet = raw;
                                if (typeof raw.data !== 'undefined') {
                                    dataSet = raw.data;
                                }
                                return dataSet;
                            },
                        },
                    },
                    pageSize: 10,
                    serverPaging: true,
                    serverFiltering: true,
                    serverSorting: true,
                },
                layout: {
                    scroll: true,
                    height: 550,
                    footer: false
                },
                sortable: true,
                pagination: true,
                toolbar: {
                    items: {
                        pagination: {
                            pageSizeSelect: [10, 20, 30, 50, 100],
                        },
                    },
                },
                search: {
                    input: $('#generalSearch'),
                },
                order: [[ 6, "desc" ]],
                columns: [
                    {
                        field: 'id',
                        title: '#',
                        sortable: true,
                        width: 40,
                        selector: false,
                        textAlign: 'center',
                        template: function(row, index, datatable) {
                            return ++index;
                        }
                    },
                    {
                        field: 'Customers.username',
                        title: 'Username',
                        template: function(row) {
                            return row.customer.username;
                        }
                    },
                    {
                        field: 'CustomerMutationPointTypes.name',
                        title: 'Type',
                        template: function(row) {
                            return row.customer_mutation_point_type.name + ' ['+row.customer_mutation_point_type.type+']';
                        }
                    },
                    {
                        field: 'description',
                        title: 'Deskripsi',
                        template: function(row) {
                            return row.description;
                        }
                    },
                    {
                        field: 'amount',
                        title: 'Nilai',
                        template: function(row) {
                            return (new Intl.NumberFormat('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 2})).format(row.amount);
                        }
                    },
                    {
                        field: 'balance',
                        title: 'Total Saldo',
                        template: function(row) {
                            return (new Intl.NumberFormat('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 2})).format(row.balance);
                        }
                    },
                    {
                        field: 'CustomerMutationPoints.created',
                        title: 'Tanggal',
                        template: function(row) {
                            return row.created;
                        }
                    },

                ]
            });
            var query = datatable.getDataSourceQuery();

        };
        return {
            init: function() {
                demo();
            },
        };
    }();

    jQuery(document).ready(function() {
        DatatableRemoteAjaxDemo.init();
    });
</script>
<?php $this->end(); ?>



