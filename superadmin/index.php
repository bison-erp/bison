<?php include 'config/config.php';?>

<?php if (isUserConnected()) {?>
<!doctype html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<?php include 'tpl/head.php'?>
<?php include 'tpl/modules.php'?>
<title>Superadmin<?php if (isset($title)) {
    echo " - " . $title;
}
    ?></title>
</head>

<body>

    <?php include 'tpl/header.php'?>
    <?php include 'tpl/content.php'?>
    <?php include 'tpl/footer.php'?>

</body>

</html>
<?php
} else {
    include 'tpl/login.php';
}
?>