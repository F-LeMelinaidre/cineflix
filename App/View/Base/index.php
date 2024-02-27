<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title><?= $this->title_page; ?></title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../public/css/style.css" type="text/css" media="screen" />
</head>
<body class="bg-black">
    <?php if($this->header === true) include(\Cineflix\App\AppController::$_Root."/app/View/Base/header.php"); ?>

    <main id ="<?= $this->page_id ?>" class="<?= $class ?>">

        <?= $content ?>

    </main>

    <?php include(\Cineflix\App\AppController::$_Root . "/app/View/Base/footer.php"); ?>

</body>
</html>