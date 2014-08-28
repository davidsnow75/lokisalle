<?php

//-- CONNEXION BDD ------------------------------------------------------------
$bdd = @new Mysqli($mydb_host, $mydb_user, $mydb_pass, $mydb_name);

if ($bdd->connect_error) {
    die (
       '<!DOCTYPE html>
        <html>
        <head><title>Erreur de connexion à la BDD</title><meta charset="utf-8"></head>
        <body>
        <p>Une erreur s\'est produite lors de la connexion à la base de données:</p>
        <p><strong>'.$bdd->connect_error.'</strong></p>
        </body>
        </html>'
    );
}

//-- GESTION DE LA SESSION -----------------------------------------------------
session_start();

//-- FONCTIONS UTILITAIRES DE TRAITEMENT DES INPUTS ----------------------------

function fournir_varchar($string, $nb_caracteres_max = 255)
{
    return htmlentities(substr($string, 0, --$nb_caracteres), ENT_QUOTES, "utf-8");
}

function fournir_int($int, $nb_chiffres_max = false) {
    // TODO: traitement des nombres
    return $int;
}


/*----*/

function traiter_varchar($string, $nb_caracteres)
{
    if (!$string && !is_string($string)) {

        return false;
    
    } else {

        return fournir_varchar($string, $nb_caracteres);

    }
}

function traiter_int($int, $nb_chiffres_max) {
    return $int;
}

// renvoie une valeur propre, à même d'être insérée en BDD.
// si aucune valeur propre n'a pu être trouvée, alors renvoie faux.
function est_exploitable(array $donnee)
{
    if (empty($donnee['nom']) || empty($donnee['type'])) {
        return false;
    }
}

function ajouterSalle($infos_salle)
{
    /* Test de la validité des données à utiliser pour la création d'une salle */
    $pays        = est_exploitable( array( 'valeur' => $infos_salle['pays']       , 'type' => 'varchar', 'maximum' => '20'  ) );                              
    $ville       = est_exploitable( array( 'valeur' => $infos_salle['ville']      , 'type' => 'varchar', 'maximum' => '20'  ) );                            
    $adresse     = est_exploitable( array( 'valeur' => $infos_salle['adresse']    , 'type' => 'varchar', 'maximum' => '20'  ) );                  
    $cp          = est_exploitable( array( 'valeur' => $infos_salle['cp']         , 'type' => 'varchar', 'maximum' => '5'   ) );                                           
    $titre       = est_exploitable( array( 'valeur' => $infos_salle['titre']      , 'type' => 'varchar', 'maximum' => '200' ) );                            
    $description = est_exploitable( array( 'valeur' => $infos_salle['description'], 'type' => 'varchar', 'maximum' => ''    ) );
    $photo       = est_exploitable( array( 'valeur' => $infos_salle['photo']      , 'type' => 'varchar', 'maximum' => '200' ) );                            
    $capacite    = est_exploitable( array( 'valeur' => $infos_salle['capacite']   , 'type' => 'varchar', 'maximum' => '3'   ) );             
    $categorie   = est_exploitable( array( 'valeur' => $infos_salle['categorie']  , 'type' => 'varchar', 'maximum' => ''    ) );
}