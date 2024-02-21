<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title><?= $this->title_page; ?></title>
    <link rel="stylesheet" href="<?= ROOT ?>css/bootstrap.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?= ROOT ?>css/style.css" type="text/css" media="screen" />
</head>
<body class="bg-black">
    <?php if($this->header === true) include(WEBROOT . "/app/View/Base/header.php"); ?>

    <main id ="<?= $this->page_id ?>" class="<?= $class ?>">

        <?= $content ?>

    </main>

    <?php include(WEBROOT . "/app/View/Base/footer.php"); ?>

</body>
</html>