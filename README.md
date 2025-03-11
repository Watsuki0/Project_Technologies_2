# Project_Technologies_2
Projets Technologies Internet 2 


GITHUB	Important : l’application PHP sera déposée sur Github au minimum à ces dates:
-	La semaine du 3/3
-	La semaine du 17/3
-	La semaine du 14/4
-	La semaine du 28/4
-	La semaine du 12/5
-	Au minimum 2 jours avant de l'examen de juin si modifié

Cahier des charges	Le sujet : tout commerce (détaillant, grossistes, services, cinéma, loisirs payants, etc.)
Vous devrez développer une ou deux fonctionnalités, selon l’ampleur.  Il est inutile de reproduire dans d’autres fonctionnalités les outils et technologies déjà utilisés dans une fonctionnalité. Par exemple, si vous gérez les produits de manière complète, il est inutile d’appliquer la même gestion aux clients, aux fournisseurs, etc. L'important est l'application des technologies vues.

Le site comprend une partie publique et une partie administration. Il y aura donc au moins 2 niveaux de droits d’accès différents.  On pourra visiter la partie publique sans connexion préalable ; on devra s’identifier de manière sécurisée si l’on concrétise un achat ou qu’on gère le site en tant qu’administrateur.   

Pensez aux règles de User Expérience (convivialité, accessibilité, etc.) passées en revue à un moment du cours.
Base de données	Le SGBD est POSTGRESQL.
La base de données devra consister en 3 à 5 tables (ou plus), reliées.  Si la table admin existe, elle n’est normalement pas reliée.  Les administrateurs peuvent faire partie des users, avec un champ de statut pour les identifier.

Les modifications de base de données se feront par des appels de fonctions plpgsql. 

Langages et librairies	Les langages utilisés sont le PHP pur objet ainsi que les langages clients habituels (js, css, html, autres).
L’application doit utiliser une librairie CSS (bootstrap ou équivalent) et une librairie javascript (jquery ou équivalent).

SEO : les codes spécifiques doivent figurer dans l'application : <meta>, attributs, présentation des contenus, …
Organisation	Architecture à pages multiples principalement chargées par l’index dans le l’architecture de la démo, ou différemment dans le cas d’une organisation MVC.   

Sauf justification correcte (demander), les seules organisations seront l’une des deux qui ont été présentées au cours pendant le quadrimestre.
 
Le modèle DAO sera appliqué pour la collecte des données.  Aucune requête à la BD ne peut avoir lieu lors de sa méthode dans une classe DAO.
Toutes les pages soumises à autorisation seront sécurisées. 

Technologies	AJAX
Le projet contiendra l’exemple ajax vu au cours, adaptée au projet, ainsi qu’une ou plusieurs applications ajax personnelles au choix. 

XML : une sitemap sera générée selon la norme sitemap.
	developers.google.com/search/docs/crawling-indexing/sitemaps/overview?hl=fr

PDF
Facultatif 
Dépôt	A tout moment, le dump de la base de données devra être à jour sur Github.

