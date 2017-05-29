<?php

require_once 'Framework/Modele.php';

/**
 * Fournit les services d'accès aux genres musicaux 
 *
 */
class Commentaire extends Modele {

// Renvoie la liste des commentaires associés à un chapitre
    public function getCommentaires($idChapitre) {
        $sql = 'select COM_ID as id, COM_AUTEUR as auteur, COM_DATE as date, COM_CONTENU as contenu, COM_signalement as signalement, from T_COMMENTAIRE where CHAP_ID=?';
        $commentaires = $this->executerRequete($sql, array($idChapitre));
        return $commentaires;
    }

    public function ajouterCommentaire($auteur, $contenu, $signalement, $idChapitre) {
        $sql = 'insert into T_COMMENTAIRE(COM_DATE, COM_AUTEUR, COM_CONTENU, COM_SIGNALEMENT, CHAP_ID)'
            . ' values(?, ?, ?, ?, ?)';
        $date = date(DATE_W3C);
        $this->executerRequete($sql, array($date, $auteur, $contenu, $signalement, $idChapitre));
    }

    /**
     * Renvoie le nombre total de commentaires
     *
     * @return int le nombre de commentaires
     */
    public function getNombreCommentaires()
    {
        $sql = 'select count(*) as nbCommentaires from T_COMMENTAIRE';
        $resultat = $this->executerRequete($sql);
        $ligne = $resultat->fetch();
        return $ligne['nbCommentaires'];
    }
}