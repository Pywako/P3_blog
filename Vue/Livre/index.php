<?php $this->titre = "Billet pour l'Alaska";
?>
<?php if (isset($chapitres)): ?>
    <!------------ Table des matières-------------->
    <div id="tableMatiere" class="jumbotron text-center">
        <h2>Table des matières</h2>
        <table class="container">
            <?php foreach ($titres as $titre): ?>
                <tr>
                    <td><a href="<?= "Chapitre/index/" . $this->nettoyer($titre['id']) ?>">
                            <h3 class="text-left"><span
                                        class="col-sm-3">Chapitre <?php echo $titre['numero'] . '</span><span class="col-sm-9">' . $this->nettoyer($titre['titre']) ?></span>
                            </h3>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php
    $url = "livre?page=";
    include "Vue/_pagination.php" ?>
    <!--Affichage des chapitres-->
    <?php foreach ($chapitres as $chapitre):
        ?>
        <article class="chapitre">
            <header>
                <a href="<?= "Chapitre/index/" . $this->nettoyer($chapitre['id']) ?>">
                    <h1 class="titreChapitre"><?= $this->nettoyer($chapitre['numero']) ?>
                        - <?= $this->nettoyer($chapitre['titre']) ?></h1>
                </a>
                <time><?= $this->nettoyer($chapitre['date']) ?></time>
            </header>
            <p><?= $chapitre['contenu'] ?></p>
        </article>
        <hr/>
    <?php endforeach;
    include "Vue/_pagination.php" ?>
<?php endif; ?>
<?php if (!isset($chapitres)): ?>
    <h2>Roman en cours d'écriture ...</h2>
<?php endif; ?>
