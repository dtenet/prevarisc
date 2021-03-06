<?php

class GestionDesCommunesController extends Zend_Controller_Action
{
    /**
     * Affichage de la liste des villes
     *
     */  
    public function indexAction()
    {
        // Définition du layout
        $this->_helper->layout->setLayout('menu_left');
        
        // Modèles 
        $commune = new Model_DbTable_AdresseCommune;
        
        // Liste des villes pour le select
        $this->view->rowset_communes = $commune->fetchAll(null, "LIBELLE_COMMUNE");
    }

    public function displayAction()
    {
        // Modèles de données
        $DB_informations = new Model_DbTable_UtilisateurInformations;
        $DB_communes = new Model_DbTable_AdresseCommune;

        // On récupère la commune
        $commune = $DB_communes->find($this->_request->numinsee)->current();
        $this->view->commune = $commune;

        // On envoit le tout sur la vue
        $this->view->user_info = $DB_informations->find( $commune->ID_UTILISATEURINFORMATIONS )->current();

        $this->view->ext = $this->_request->ext;
    }

    public function saveAction()
    {
        $this->_helper->viewRenderer->setNoRender();

        // Modèles de données
        $DB_informations = new Model_DbTable_UtilisateurInformations;
        $DB_communes = new Model_DbTable_AdresseCommune;

        // On récupère la commune
        $commune = $DB_communes->find($_GET["numinsee"])->current();

        if ($commune->ID_UTILISATEURINFORMATIONS == 0)
        {
            $commune->ID_UTILISATEURINFORMATIONS = $DB_informations->insert(array_intersect_key($_POST, $DB_informations->info('metadata')));
        }
        else
        {
            $info = $DB_informations->find( $commune->ID_UTILISATEURINFORMATIONS )->current();

            if ($info == null)
            {
                $id = $DB_informations->insert(array_intersect_key($_POST, $DB_informations->info('metadata')));
                $commune->ID_UTILISATEURINFORMATIONS = $id;
            }
            else
            {
                $info->setFromArray(array_intersect_key($_POST, $DB_informations->info('metadata')))->save();
            }
        }

        $commune->save();
    }
}
