<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= $this->fetch('meta') ?>
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <!--end::Page Vendors -->
    <?= $this->Html->css([
            '/admin-assets/vendors/base/vendors.bundle',
            '/admin-assets/demo/default/base/style.bundle',
            '/admin-assets/app/css/custom'
    ]); ?>
    <!--end::Base Styles -->
    <?= $this->Html->meta(
        'favicon.ico',
        '/admin-assets/demo/default/media/img/logo/favicon.ico',
        ['type' => 'icon']
    );
    ?>
    <?= $this->fetch('css') ?>
    <?= $this->Html->script([
        '/admin-assets/vendors/base/vendors.bundle',
    ]); ?>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    <header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">

                <!-- BEGIN: Brand -->
                <div class="m-stack__item m-brand  m-brand--skin-dark ">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="<?= $this->Url->build(['controller' => 'Dashboard']); ?>" class="m-brand__logo-wrapper">
                                <img alt="" src="<? $this->Url->build('/admin-assets/media/logos/logo-1.png'); ?>" />
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">

                            <!-- BEGIN: Left Aside Minimize Toggle -->
                            <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                                <span></span>
                            </a>

                            <!-- END -->

                            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                            <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>

                            <!-- END -->

                            <!-- BEGIN: Responsive Header Menu Toggler -->
                            <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>

                            <!-- END -->

                            <!-- BEGIN: Topbar Toggler -->
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>

                            <!-- BEGIN: Topbar Toggler -->
                        </div>
                    </div>
                </div>

                <!-- END: Brand -->
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                    <?= $this->Element('Menu/top-menu'); ?>
                    <?= $this->Element('Header/top-bar'); ?>
                </div>
            </div>
        </div>
    </header>

    <!-- END: Header -->
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <?= $this->Element('Menu/side-menu'); ?>
        <?= $this->fetch('content'); ?>
    </div>

<!-- end:: Body -->
<?= $this->Element('Footer/default'); ?>
<!-- end:: Page -->
</div>

<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

<!--begin::Base Scripts -->
<?= $this->Html->script([
        //'/admin-assets/vendors/base/vendors.bundle',
        '/admin-assets/demo/default/base/scripts.bundle'
]); ?>
<!--end::Base Scripts -->
<!--begin::Page Vendors -->
<!--end::Page Vendors -->
<!--begin::Page Snippets -->
<?= $this->Html->script('/admin-assets/app/js/dashboard'); ?>
<!--end::Page Snippets -->
<?= $this->fetch('script') ?>
</body>
<!-- end::Body -->
</html>
