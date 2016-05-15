<?php

// Capabilities
$string['use_stats:addinstance'] = 'Peut ajouter une instance';
$string['use_stats:myaddinstance'] = 'Peut ajouter une instance à la page personnalisée';
$string['use_stats:seecoursedetails'] = 'Peut voir les détails de tous les utilisateurs de ses cours';
$string['use_stats:seegroupdetails'] = 'Peut voir les détails de tous les utilisateurs de ses groupes';
$string['use_stats:seeowndetails'] = 'Peut voir son propre détail d\'usage';
$string['use_stats:seesitedetails'] = 'Peut voir les détails de tous les utilisateurs';
$string['use_stats:view'] = 'Voir les statistiques';

$string['activities'] = 'Activités';
$string['blockname'] = 'Mesure d\'activité';
$string['byname'] = 'Par nom';
$string['bytimedesc'] = 'Par temps de présence';
$string['configcapturemodules'] = 'Modules à capturer';
$string['configcapturemodules_desc'] = 'Liste des modules qui sont pris en compte dans l\'analyse de détail';
$string['configcustomtagselect'] = 'Requête pour tag custom ';
$string['configcustomtagselect_desc'] = 'Cette requête ne doit retourner qu\'une seule colonne de résultat. Ce résultat alimente la colonne customtag {$a}.';
$string['configenablecompilecube'] = 'Activer la compilation de cube statistique';
$string['configenablecompilecube_desc'] = 'Si activé, les requêtes d\'obtention de dimensions supplémentaires sont excutées et les champs alimentés';
$string['configenablecompilelogs'] = 'Activer la compilation des temps';
$string['configenablecompilelogs_desc'] = 'Si désactivé, aucune compilation des écarts n\'est faite par le cron';
$string['configfromwhen'] = 'A partir de ';
$string['configfromwhen_desc'] = 'Durée de compilation (en jours depuis aujourd\'hui) ';
$string['configfilterdisplayunder'] = 'Filtrer les temps inférieurs à';
$string['configfilterdisplayunder_desc'] = 'Si non nul, seuls les cours avec un temps de présence supérieur à la consigne seront affichés dans le bloc';
$string['configignoremodules'] = 'Liste des modules ignorés';
$string['configignoremodules_desc'] = 'Liste des modules ignorés par le tracking';
$string['configlastcompiled'] = 'Date de dernière compilation';
$string['configlastcompiled_desc'] = 'En changeant cette date, vous déclencherez le recalcul de toutes les valeurs à partir du log de cette date';
$string['configlastpingcredit'] = 'Crédit exceptionnel de fin de session';
$string['configlastpingcredit_desc'] = 'Ce temps (en minutes) sera ajouté au calcul à chaque fois qu\'une fin ou une discontinuité de session est supposée';
$string['configstudentscanuse'] = 'Les étudiants peuvent voir ce bloc (pour leur compte)';
$string['configstudentscanuseglobal_desc'] = 'Autoriser les étudiants à voir les blocs de statistiques dans les espaces globaux (MyMoodle, hors cours)';
$string['configthreshold'] = 'Seuil';
$string['configthreshold_desc'] = 'Seuil de détection (en minutes). Au dessus de ce délai entre deux traces successives, l\'analyseur conclut à une déconnexion de l\'utilisateur et attribue le temps forfaitaire.';
$string['configkeepalivedelay'] = 'Période d\'émission';
$string['configkeepalivedelay_desc'] = 'Délai entre deux envois de message de maintien de session (secondes). Régler ce paramètre sur la plus grande valeur possible qui maintienne la cohérence de votre tracking.';
$string['configkeepaliverule'] = 'Emettre les maintiens de session si ';
$string['configkeepaliverule_desc'] = 'Règle pour contrôler qui peut émettre les signaux de session.';
$string['configkeepalivecontrol'] = 'Méthode';
$string['configkeepalivecontrol_desc'] = 'Le type de donnée interne qui contrôle la règle';
$string['configkeepalivecontrolvalue'] = 'Nom de l\'item de contrôle';
$string['configkeepalivecontrolvalue_desc'] = 'Activera la règle si la capacité est disponible ou si le champ de profil a une valeur non nulle. Par défaut la règle exclue les administrateurs du site.';
$string['configdisplayothertime'] = 'Afficher le temps "Hors cours"';
$string['configdisplayothertime_desc'] = 'Si actif, affiche une ligne pour les temps hors contexte de cours.';
$string['configdisplayactivitytimeonly'] = 'Temps de référence à afficher';
$string['configdisplayactivitytimeonly_desc'] = 'Choisissez quel est la référence de temps à afficher aux utilisateurs';
$string['displaycoursetime'] = 'Temps complet du cours (tous les temps assignables au cours et à ses sous-contextes)';
$string['displayactivitiestime'] = 'Uniquement le temps passés dans les activités formalisées du cours.';
$string['blockdisplay'] = 'Réglages de l\'affichage du bloc';
$string['datacubing'] = 'Données multidimensionnelles';
$string['loganalysisparams'] = 'Réglages de l\'analyseur d\'historiques';
$string['activetrackingparams'] = 'Réglage du tracking actif';
$string['capabilitycontrol'] = 'Sur capacité';
$string['profilefieldcontrol'] = 'sur champ de profil';
$string['allusers'] = 'Actif pour tous les utilisateurs';
$string['allowrule'] = 'Envoie si la règle est vérifiée';
$string['declaredtime'] = 'Temps déclaré';
$string['denyrule'] = 'Envoie SAUF si la règle est vérifiée';
$string['dimensionitem'] = 'Classes observables';
$string['errornorecords'] = 'Aucune donnée de tracking';
$string['errornotinitialized'] = 'Ce module ne semble pas avoir été initialisé. Contactez l\'administrateur.';
$string['eventscount'] = 'Nombre de hits';
$string['from'] = 'Depuis ';
$string['ignored'] = 'Module/Activité non pris en compte';
$string['isfiltered'] = 'Seuls les cours avec un temps au dessus de {$a} secondes sont affichés';
$string['lastcompiled'] = 'Dernier log compilé';
$string['modulename'] = 'Activity tracking';
$string['noavailablelogs'] = 'Pas de logs disponibles pour cette évaluation';
$string['onthismoodlefrom'] = ' depuis ';
$string['pluginname'] = 'Mesure d\'activité';
$string['showdetails'] = 'Montrer les détails';
$string['timeelapsed'] = 'Temps passé';
$string['use_stats_description'] = 'En publiant ce service, vous permettez au serveur distant de consulter les statistiques des utilisateurs locaux.<br/>En vous abonnant à ce service, vous autorisez le serveur local à consulter les satistiques d\'utilisateurs du serveur distant.<br/>';
$string['use_stats_name'] = 'Acces distant aux statistiques d\'usage';
$string['use_stats_rpc_service'] = 'Lecture distante des statistiques';
$string['use_stats_rpc_service_name'] = 'Accès distant aux statistiques d\'usage';
$string['youspent'] = 'Cumul : ';
$string['credittime'] = 'Crédit temps';
$string['task_compile'] = 'Compilation des temps intercalaires';
$string['task_cleanup'] = 'Nettoyage des temps intercalaires';
$string['task_cache_ttl'] = 'TTL du cache d\'aggrégats';
$string['eventusestatskeepalive'] = 'Maintien de session de formation';
$string['keepuseralive'] = 'L\'utilisateur {$a} est toujours en session';
$string['othershort'] = 'Hors cours';
$string['other'] = 'Autres zones hors cours';
$string['printpdf'] = 'Exporter en PDF';
