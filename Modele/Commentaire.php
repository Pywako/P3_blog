<?php
namespace P3_blog\Modele;
use P3_blog\Framework\Modele;
/**
 * Fournit les services d'accès aux genres musicaux 
 *
 */
class Commentaire extends Modele {

// Renvoie la liste des commentaires associés à un chapitre
    public function getCommentaires($idChapitre) {
        $sql = 'select COM_ID as id, COM_AUTEUR as auteur, COM_DATE as date, COM_CONTENU as contenu, COM_signalement as signalement
 from T_COMMENTAIRE where CHAP_ID=?';
        $commentaires = $this->executerRequete($sql, array($idChapitre));
        return $commentaires;
    }

    public function getAllCommentaires()
    {
        $sql = 'select COM_ID as com_id, COM_AUTEUR as com_auteur, COM_DATE as com_date, COM_CONTENU as com_contenu, 
COM_signalement as com_signalement, chap_id as chap_id from T_COMMENTAIRE order by CHAP_ID DESC';
        $commentaires = $this->executerRequete($sql);
        return $commentaires;
    }

    public function ajouterCommentaire($auteur, $contenu, $idChapitre) {
        $sql = 'insert into T_COMMENTAIRE(COM_AUTEUR, COM_CONTENU, CHAP_ID)'
            . ' values(?,?,?)';
        $this->executerRequete($sql, array($auteur, $contenu, $idChapitre));
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

    public function modifierCommentaire($contenu, $signalement, $chapitreId)
    {
        $sql = "UPDATE t_commentaire SET com_contenu = ?, com_signalement = ? 
WHERE chap_id = ?";
        $this->executerRequete($sql, array($contenu, $signalement, $chapitreId));
    }

    public function supprimerCommentaire($commentaireId)
    {
        $sql = "DELETE FROM t_commentaire WHERE COM_id = ?";
        $this->executerRequete($sql, array($commentaireId));
    }
}