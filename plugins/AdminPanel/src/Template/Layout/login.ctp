<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Login page
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    <?= $this->Html->css([
        '/admin-assets/vendors/base/vendors.bundle',
        '/admin-assets/demo/default/base/style.bundle',
    ]); ?>
    <!--end::Base Styles -->
    <?= $this->Html->meta(
        'favicon.ico',
        '/admin-assets/demo/default/media/img/logo/favicon.ico',
        ['type' => 'icon']
    );
    ?>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >

<?= $this->fetch('content'); ?>

<!--begin::Base Scripts -->
<?= $this->Html->script([
    '/admin-assets/vendors/base/vendors.bundle',
    '/admin-assets/demo/default/base/scripts.bundle'
]); ?>
<!--end::Base Scripts -->
<!--begin::Page Snippets -->
<?= $this->Html->script('/admin-assets/snippets/pages/user/login'); ?>
<!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>
