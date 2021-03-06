<?php if (isset($chapitre)): ?>
    <?php $this->titre = "Billet pour l'Alaska"; ?>
    <article class="chapitre">
        <header id="chapitreHeader">
            <div class="">
                <a href="<?= "Chapitre/index/" . $this->nettoyer($chapitre['id']) ?>">
                    <h1 class="titreChapitre">
                        Chapitre <?= $this->nettoyer($chapitre['numero']) . " - " . $this->nettoyer($chapitre['titre']) ?>
                    </h1>
                </a>
            </div>
            <div id="precefentSuivant">
                <?php if (isset($precedent) && !empty($precedent)): ?>
                    <div class="">
                        <a href="<?= "Chapitre/index/" . $this->nettoyer($precedent) ?>">
                            < chapitre <?= $this->nettoyer($chapitre['numero']) - 1 ?>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (((isset($precedent) && !empty($precedent))) && (isset($suivant) && !empty($suivant))): ?>
                    <div>
                        &nbsp;-&nbsp;
                    </div>
                <?php endif; ?>
                <?php if (isset($suivant) && !empty($suivant)): ?>
                    <div class="">
                        <a href="<?= "Chapitre/index/" . $this->nettoyer($suivant) ?>">
                            chapitre <?= $this->nettoyer($chapitre['numero']) + 1 ?> >
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <time><?= $this->nettoyer($chapitre['date']) ?></time>
        </header>
        <p><?= $chapitre['contenu'] ?></p>
    </article>
    <hr/>
    <div class="commentaire">
        <header>
            <h1 id="titreReponses">Réponses à <?= $this->nettoyer($chapitre['titre']) ?></h1>
        </header>
        <?php
        // Inclusion de la partie HTML
        //Boucle sur les parents
        foreach ($commentaires['parent'] as $commentaire): ?>
            <!-- Commentaire parent-->
            <div class="card" id="commentaire-<?= $commentaire['id'] ?>">
                <div class="card-block">
                    <p><?= $this->nettoyer($commentaire['auteur']) ?> dit :</p>
                    <p><?= $this->nettoyer($commentaire['contenu']) ?></p>
                    <p class="text-right">
                        <button type="button" class="btn btn-info reponse" data-id="<?= $commentaire['id'] ?>"
                                data-niveau="<?php $niveau = 0 ?>">Répondre
                        </button>
                        <a id="signalerCommentaire" href="<?= "chapitre/signaler/" . $commentaire['id'] ?>">
                            <button type="button" class="btn btn-warning">Signaler</button>
                        </a>
                    </p>
                </div>
            </div>
            <?php $id_parent = $commentaire['id']; ?>
            <?php if (isset($commentaires['enfant'][$id_parent])):
                // Boucle sur les enfants?>
                <?php foreach ($commentaires['enfant'] as $key => $commentaireEnfant): ?>
                    <?php if ($key == $id_parent): ?>
                        <?php foreach ($commentaireEnfant as $commentaire): ?>
                            <?php $niveau = 1 ?>
                            <!-- commentaire Enfant -->
                            <div style="margin-left: 50px;">
                                <?php include("Vue/Chapitre/_commentaires.php"); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-------------- Commenter -------------->
        <form method="post" action="chapitre/commenter" id="formulaireCommenter">
            <input type="hidden" name="parent_id" value="">
            <h3>Poster un commentaire</h3>
            <div class="form-group">
                <input id="auteur" name="auteur" type="text" class="form-control" placeholder="Votre pseudo"
                       required/><br/>
                <textarea id="txtCommentaire" name="contenu" class="form-control" placeholder="Votre commentaire"
                          required></textarea>
                <input class="sr-only" type="hidden" name="id" value="<?= $chapitre['id'] ?>"/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Commenter</button>
            </div>
        </form>
        <!-------------- Répondre -------------->
        <?php if (isset($commentaires) && !empty($commentaires)): ?>
            <form method="post" action="chapitre/commenter" id="formulaireReponse">
                <h3>Répondre à ce commentaire</h3>
                <div class="form-group">
                    <input id="auteur" name="auteur" type="text" class="form-control" placeholder="Votre pseudo"
                           required/><br/>
                    <textarea id="txtCommentaire" name="contenu" class="form-control" placeholder="Votre commentaire"
                              required></textarea>
                    <input class="sr-only" type="hidden" name="id" value="<?= $chapitre['id'] ?>"/>
                    <input class="sr-only" type="hidden" name="parent_id" value="" id="parent_id">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Répondre</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (!isset($chapitre)): ?>
    <?php $this->titre = "Billet pour l'Alaska " . "<br>" . "Chapitre "; ?>
    <h3>Oups, pas de chapitre correspondant...</h3>
<?php endif; ?>