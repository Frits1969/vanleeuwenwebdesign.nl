<?php
$naam = htmlspecialchars($_POST['naam']);
$email = htmlspecialchars($_POST['email']);
$bedrijf = htmlspecialchars($_POST['bedrijf']);
$bericht_raw = htmlspecialchars($_POST['bericht']);
$bericht = nl2br($bericht_raw);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-99REZ2DLYZ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-99REZ2DLYZ');
    </script>
    <meta charset="UTF-8">
    <title>Controleer je bericht | Van Leeuwen Webdesign</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <header>
        <div class="container nav">
            <div class="header-logo">
                <a href="index.html" class="logo-link"> <img src="images/logo/logo.png" alt="Van Leeuwen Design Logo"
                        class="logo-img">
                    <div class="logo-text">Van Leeuwen <span>Webdesign</span></div>
                </a>
                <a href="tel:+31624270103" class="phone-link"> <i class="fa-solid fa-phone"></i> +31 6 24270103</a>
            </div>
            <nav>
                <a href="diensten.html">Diensten</a>
                <a href="prijzen.html">Prijzen</a>
                <a href="over_mij.html">Over mij</a>
                <a href="contact.html" class="active">Contact</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-inner">
                <div class="p-4 border rounded shadow-sm bg-white" style="width:100%;max-width:700px;margin:auto;">
                    <h1>Controleer je bericht</h1>
                    <p>Klopt alles? Klik dan op <strong>Versturen</strong>.</p>

                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Naam:</strong> <?= $naam ?></li>
                        <li class="list-group-item"><strong>E-mail:</strong> <?= $email ?></li>
                        <li class="list-group-item"><strong>Bedrijf:</strong> <?= $bedrijf ?></li>
                        <li class="list-group-item"><strong>Bericht:</strong><br><?= $bericht ?></li>
                    </ul>

                    <form action="send_mail.php" method="POST">
                        <input type="hidden" name="naam" value="<?= $naam ?>">
                        <input type="hidden" name="email" value="<?= $email ?>">
                        <input type="hidden" name="bedrijf" value="<?= $bedrijf ?>">
                        <input type="hidden" name="bericht" value="<?= $bericht_raw ?>">

                        <button type="submit" class="btn btn-primary w-100 mb-2">Bevestigen en versturen</button>
                    </form>

                    <a href="contact.html" class="btn btn-secondary w-100">Terug naar formulier</a>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/nav.js"></script>
</body>

</html>
