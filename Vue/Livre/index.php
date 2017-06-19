<?php $this->titre = "Billet pour l'Alaska"; ?>

<?php foreach ($chapitres as $chapitre):
    ?>
    <article class="chapitre">
        <header>
            <a href="<?= "Chapitre/index/" . $this->nettoyer($chapitre['id']) ?>">
                <h1 class="titreChapitre"><?= $this->nettoyer($chapitre['titre']) ?></h1>
            </a>
            <time><?= $this->nettoyer($chapitre['date']) ?></time>
        </header>
        <p><?= $chapitre['contenu'] ?></p>
    </article>
    <hr />
<?php endforeach; ?>