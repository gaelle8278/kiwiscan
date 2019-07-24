# Description

Plugin qui gère la construction et l'affichage d'un CV.

# Fonctionnalités

Ajoute les Custom Post Type suivants :
* CV, post_type = kscv_cv
* Expériences Professionnelles, post_type = kscv_job
* Formations, post_type = kscv_education

Ajoute les custom taxonomies suivantes :
* Mot-clé pour le CPT Expériences Professionnelle, id = 'kscv_job_keyword_taxo'
* Compétence pour le CPT CV, id = 'kscv_cv_skill_taxo' , custom  meta pour indiquer le niveau (meta_key = 'ks_cv_skill_level')
* Langue pour le CPT CV, id = 'kscv_cv_lang_taxo', custom  meta pour indiquer le niveau (meta_key = 'ks_cv_lang_level')
* Loisirs pour le CPT CV , id = 'kscv_cv_hobby_taxo'


# Installation

Installer le plugin via le menu Extensions > Ajouter dans l'interface d'administration.

# Personnaliser l'affichage/le design 

Ajouter les templates suivants dans le thème actif :
* single-kscv_cv.php et archive-kscv_cv.php pour personnaliser l'affichage des CPT CV
* single-kscv_job.php et archive-kscv_job.php pour personnaliser l'affichage des CPT Expérience Professionnelle
* single-kscv_education.php et archive-kscv_education.php pour personnaliser l'affichage des CPT Formation

Créer un template page spécifique pour afficher le CV mis en avant.


