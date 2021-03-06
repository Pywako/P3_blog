<?php

namespace P3_blog\Controleur;

use P3_blog\Framework\Controleur;
use P3_blog\Modele\Chapitre;
use P3_blog\Modele\Commentaire;

/**
 * Contrôleur des actions liées aux chapitres
 */
class ControleurChapitre extends Controleur
{

    private $chapitre;
    private $commentaire;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->chapitre = new Chapitre();
        $this->commentaire = new Commentaire();
    }

    // Affiche les détails sur un chapitre
    public function index()
    {
        if ($this->requete->existeParametreGet('id') || $this->requete->existeParametrePost('id') || $this->requete->getSession()->existeAttribut("id")) {
            if ($this->requete->getSession()->existeAttribut("id")) {
                $idChapitre = $this->requete->getSession()->getAttribut("id");
                $this->requete->getSession()->setAttribut('id',"");
            } elseif ($this->requete->existeParametreGet("id") || $this->requete->existeParametrePost("id")) {
                $idChapitre = $this->requete->getParametre("id");
            }
            $chapitre       = $this->chapitre->getChapitre($idChapitre);
            $commentaires   = $this->commentaire->formaterCommentaires($idChapitre);
            $session        = $this->requete->getSession();
            $suivant        = $this->chapitre->chapitreSuivant($idChapitre);
            $precedent      = $this->chapitre->chapitrePrecedent($idChapitre);
            $this->genererVue(array(
                'chapitre'      => $chapitre,
                'commentaires'  => $commentaires,
                'session'       => $session,
                'suivant'       => $suivant,
                'precedent'     => $precedent));
        } else {
            $session = $this->requete->getSession();
            $this->requete->getSession()->setflash("Le chapitre sélectionné n'existe pas :(", "danger");
            $this->genererVue(array(
                'session' => $session));
        }
    }

    // Ajoute un commentaire sur un billet
    public function commenter()
    {
        if ($this->requete->existeParametrePost('auteur')) {
            $pattern = "#[a-zA-Z0-9]{3}#";
            $auteur = htmlspecialchars($this->requete->getParametre("auteur"));
            if (preg_match($pattern, $auteur)) {
                if ($this->requete->existeParametrePost('contenu')) {
                    $contenu = htmlspecialchars($this->requete->getParametre("contenu"));
                    if ($this->requete->existeParametrePost('id')) {
                        $idChapitre = $this->requete->getParametre("id");
                        $test = "#[0-9]#";
                        if (preg_match($test, $idChapitre)) {
                            if ($this->requete->existeParametrePost("parent_id")) {
                                $idParent = $this->requete->getParametre("parent_id");
                                $this->requete->getSession()->setflash("Merci pour votre retour, la réponse au commentaire a été ajoutée ! ;)", "success");
                            } else {
                                $idParent = null;
                                $this->requete->getSession()->setflash("Merci pour votre retour, Commentaire ajouté ! ;)", "success");
                            }
                            $this->commentaire->ajouterCommentaire($auteur, $contenu, $idChapitre, $idParent);
                            $nbCom = $this->commentaire->getNbCommentairesChapitre($idChapitre);
                            $this->chapitre->miseAjourNbCommentaire($nbCom, $idChapitre);
                        } else {
                            $this->requete->getSession()->setflash("id du chapitre non conforme :(", "danger");
                        }
                    } else {
                        $this->requete->getSession()->setflash("id du chapitre non reconnu :(", "danger");
                    }
                } else {
                    $this->requete->getSession()->setflash("Vous n'avez rien écrit :(", "danger");
                }
            } else {
                $this->requete->getSession()->setflash("Le nom choisi n'est pas conforme", "danger");
            }
        } else {
            $this->requete->getSession()->setflash("comment vous appelez vous?", "danger");
        }
        // Exécution de l'action par défaut pour réafficher la page index
        $this->executerAction("index");
    }

    /**
     * Fonction de gestion des signalement
     *
     */
    public function signaler()
    {
        if ($this->requete->existeParametreGet('id')) {
            $commentaireId = $this->requete->getParametre("id");
            $commentaire = $this->commentaire->getOneCommentaire($commentaireId);
            $this->commentaire->signaler($commentaireId);
            $this->requete->getSession()->setflash("Le commentaire a bien été signalé.", "success");
            // Exécution de l'action par défaut pour réafficher la page index
            $this->rediriger("chapitre", "index", $commentaire['chap_id']);
        } else {
            $session = $this->requete->getSession();
            $this->requete->getSession()->setflash("oups, le commentaire est introuvable ...", "danger");
            $this->genererVue(array(
                'session' => $session));
        }
    }
}

