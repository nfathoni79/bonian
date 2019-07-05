<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Pengaturan Pengguna
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
                                Pengaturan Pengguna
                            </span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= $this->Url->build(['action' => 'index']); ?>" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Daftar Pengguna
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Daftar Pengguna
                            <!-- <small>
                                data loaded from remote data source
                            </small> -->
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>
            <div class="m-portlet__body">
                <?= $this->Flash->render() ?>
                <!--begin: Search Form -->
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-xl-8 order-2 order-xl-1">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label>
                                                Jenis Pengguna:
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <?= $this->Form->select('groups', $groups, [
                                                    'empty' => 'Semua',
                                                    'class' => 'form-control m-bootstrap-select',
                                                    'id' => 'm_form_group',
                                            ]); ?>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="m-form__group m-form__group--inline">
                                        <div class="m-form__label">
                                            <label class="m-label m-label--single">
                                                Status Pengguna:
                                            </label>
                                        </div>
                                        <div class="m-form__control">
                                            <?= $this->Form->select('status', $user_statuses, [
                                                'empty' => 'Semua',
                                                'class' => 'form-control m-bootstrap-select',
                                                'id' => 'm_form_status',
                                            ]); ?>
                                        </div>
                                    </div>
                                    <div class="d-md-none m--margin-bottom-10"></div>
                                </div>
                                <div class="col-md-4">
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
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="<?= $this->Url->build(['action' => 'add']); ?>" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Tambah Pengguna
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                </div>
                <!--end: Search Form -->
                <!--begin: Datatable -->
                <div class="m_datatable" id="ajax_data"></div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
</div>

<!-- end:: Body -->
<script>
    //== Class definition

    function delete_data(id) {
        $.post( "<?= $this->Url->build(['action' => 'delete']); ?>/" + id, { _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>' } )
            .done(function( data ) {
                location.href = '<?= $this->Url->build();?>';
            });
    }

    var DatatableRemoteAjaxDemo = function() {
        //== Private functions

        // basic demo
        var demo = function() {

            var datatable = $('.m_datatable').mDatatable({
                // datasource definition
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            // sample GET method
                            method: 'POST',
                            url: '<?= $this->Url->build(['action' => 'index']); ?>',
                            cache: false,
                            params: {
                                _csrfToken: '<?= $this->request->getParam('_csrfToken'); ?>'
                            },
                            map: function(raw) {
                                // sample data mapping
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

                // layout definition
                layout: {
                    scroll: true,
                    height: 550,
                    footer: false
                },

                // column sorting
                sortable: true,

                pagination: true,

                toolbar: {
                    // toolbar items
                    items: {
                        // pagination
                        pagination: {
                            // page size select
                            pageSizeSelect: [10, 20, 30, 50, 100],
                        },
                    },
                },

                search: {
                    input: $('#generalSearch'),
                },

                // columns definition
                columns: [
                    {
                        field: 'id',
                        title: '#',
                        sortable: false, // disable sort for this column
                        width: 40,
                        selector: false,
                        textAlign: 'center',
                        template: function(row, index, datatable) {
                            return ++index;
                        }
                    }, {
                        field: 'email',
                        title: 'Alamat Email',
                        // sortable: 'asc', // default sort
                        filterable: false, // disable or enable filtering
                        width: 150,
                        // basic templating support for column rendering,
                        //template: '{{OrderID}} - {{ShipCountry}}',
                    },
                    {
                        field: 'first_name',
                        title: 'Nama Lengkap',
                        // sortable: 'asc', // default sort
                        filterable: false, // disable or enable filtering
                        //width: 150,
                        // basic templating support for column rendering,
                        template: '{{first_name}} {{last_name}}',
                    },
                    {
                        field: 'Groups.name',
                        title: 'Jenis Pengguna',
                        // sortable: 'asc', // default sort
                        filterable: false, // disable or enable filtering
                        //width: 150,
                        template: function(row) {
                            return row.group ? row.group.name : '-';
                        }
                    },
                    {
                        field: 'UserStatus.name',
                        title: 'Status',
                        // sortable: 'asc', // default sort
                        filterable: false, // disable or enable filtering
                        //width: 150,
                        // basic templating support for column rendering,
                        //template: '{{OrderID}} - {{ShipCountry}}',
                        template: function(row) {
                            var status = {
                                1: {'class': 'm-badge--success'},
                                2: {'class': 'm-badge--metal'}
                            };
                            return '<span class="m-badge ' + status[row.user_status.id].class + ' m-badge--wide">' + row.user_status.name + '</span>';
                        }
                    },
                    {
                        field: 'Users.created',
                        title: 'Tanggal Didaftarkan',
                        template: function(row) {
                            return row.created;
                        }
                    },
                    {
                        field: 'Users.modified',
                        title: 'Tanggal Modifikasi',
                        template: function(row) {
                            return row.modified;
                        }
                    },
                    {
                        field: "Actions",
                        width: 110,
                        title: "Aksi",
                        sortable: false,
                        overflow: 'visible',
                        template: function (row, index, datatable) {
                            //var dropup = (datatable.getPageSize() - index) <= 4 ? 'dropup' : '';
                            return '\
						<a href="<?= $this->Url->build(['action' => 'edit']); ?>/'+ row.id +'" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:delete_data('+row.id+');" onclick="return confirm(\'Are you sure delete '+row.email+'\');" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\
							<i class="la la-trash"></i>\
						</a>\
					';
                        }
                    }
                ],
            });

            var query = datatable.getDataSourceQuery();

            $('#m_form_group').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'group_id');
            });

            $('#m_form_status').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'user_status_id');
            });

            $('#m_form_group, #m_form_status').selectpicker();

        };

        return {
            // public functions
            init: function() {
                demo();
            },
        };
    }();

    jQuery(document).ready(function() {
        DatatableRemoteAjaxDemo.init();
    });
</script>
