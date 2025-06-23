<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/main-index.css">
        <title>Pizzeria Sole Machina</title>
    </head>

    <body>
  
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/header.php'; ?>

        <main>
            <div class="main-content">
            <div class="hero-banner">
                <a href="menu.html"><img src="../public/images/herobanner.png" alt="Pizzeria Sole Machina Banner" class="banner-image"></a>
            </div>
            <section id="over-ons">
            <h1>Over Pizzeria Sole Machina</h1>
            <p>Welkom bij Pizzeria Sole Machina – waar zon, vuur en vakmanschap samenkomen in elke pizza. Onze naam betekent letterlijk ‘Zonmachine’, en dat is precies wat we willen zijn: een warme plek waar iedereen zich thuis voelt.</p>
    
            <p>Opgericht in 2017 door twee vrienden met een gedeelde liefde voor Italië en houtgestookte ovens, groeide Sole Machina al snel uit tot een vaste waarde in Amsterdam. We gebruiken uitsluitend verse ingrediënten, lokaal waar mogelijk en met de hand geselecteerd. Ons deeg rijst minimaal 48 uur voor de perfecte bodem: krokant van buiten, luchtig van binnen.</p>
    
            <p>Naast klassieke pizza’s zoals de Margherita en de Quattro Stagioni, verrassen we onze gasten graag met creatieve, seizoensgebonden specials. Vegan of glutenvrij? Geen probleem – we vinden dat iedereen moet kunnen genieten van goede pizza.</p>
    
            <p>Sole Machina is meer dan een pizzeria – het is een plek waar buurtbewoners, studenten, toeristen en gezinnen samenkomen. Kom langs en proef zelf waarom onze gasten terug blijven komen.</p>
        </section>
            </div>
        </main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/html/footer.html'; ?>

    </body>
</html>