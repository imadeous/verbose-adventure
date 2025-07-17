<html lang="en" style="scroll-behavior: smooth;">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="/assets/img/favicon.png" type="image/png">
    <title><?= isset($title) ? htmlspecialchars($title) : 'YES' ?></title>
    <!-- Icon -->
    <link rel="stylesheet" type="text/css" href="/assets/css/LineIcons.2.0.css">
    <!-- Animate -->
    <?php
    $themePath = '/assets';
    ?>
    <html lang="en" style="scroll-behavior: smooth;">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="<?= $themePath ?>/img/favicon.png" type="image/png">
        <title><?= isset($title) ? htmlspecialchars($title) : 'YES' ?></title>
        <link rel="stylesheet" type="text/css" href="<?= $themePath ?>/css/LineIcons.2.0.css">
        <link rel="stylesheet" type="text/css" href="<?= $themePath ?>/css/animate.css">
        <link rel="stylesheet" type="text/css" href="<?= $themePath ?>/css/tiny-slider.css">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>

<body>
    <div class="bg-white">
        <?php echo $this->partial('front-navbar'); ?>
        <main>
            <?= $this->yield('content') ?>
        </main>
    </div>
    <?php echo $this->partial('footer'); ?>
</body>

</html>