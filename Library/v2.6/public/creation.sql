use db_library;

/* Catalogue */

    insert into catalogue(id,mot_cle)
    values (1,'Graphisme & Photo'),(2,'Informatique'),(3,'Construction'),(4,'Entreprise'),
            (5,'Sciences'),(6,'Litterature'),(7,'Arts & Loisirs & Vie Pratique');

/* Rubriques */

    /* Graphisme  (mot_clé du Catalogue) */
    insert into rubrique(catalogue_id,classement)
    values (1,'Graphisme'),(2,'Design'),
           (2,'Photographie'),(2,'Cinema, Video & Son');

    /* Informatique  (mot_clé du Catalogue) */
    insert into rubrique(catalogue_id,classement)
    values (2,'Developpement d\'applications'),(2,'Informatique d\'entreprise'),
           (2,'Systemes d\'exploitation'),(2,'Hardware et materiels'),(2,'Bases de donnees'),(2,'Reseaux et Telecommunications'),
           (2,'Certifications'),(2,'Graphisme et multimédia'),(2,'Bureautique');

    /* Construction */
    insert into rubrique(catalogue_id,classement)
    values (3,'Construction durable'),(3,'Architecture'),(3,'Gros oeuvre et structure'),
           (3,'Renovation'),(3,'Travaux Publics'),(3,'Urbanisme');

    /* Entreprise */
   insert into rubrique(catalogue_id,classement)
    values (4,'Economie'),(4,'creation d\'entreprise'),(4,'Production'),(4,'Efficacite du manager'),
           (4,'Emploi & carriere'),(4,'Enseignement');

    /* Sciences */
    insert into rubrique(catalogue_id,classement)
    values (5,'Mathematiques'),(5,'Physique'),
       (5,'Chimie'),(5,'Science de la Vie et de la Terre'),(5,'Techniques');

    /* Litterature */
    insert into rubrique(catalogue_id,classement)
    values (6,'Romans'),(6,'Poesie'),
       (6,'Theatre'),(6,'Humour'),(6,'Nouvelle');

    /* Arts & Loisirs & Vie Pratique */
    insert into rubrique(catalogue_id,classement)
    values (7,'Nature'),(7,'Voyages'), (7,'Cuisine'),(7,'Jardin'),(7,'Jeux-Loisirs'),(7,'Langues');

/* Themes */

    insert into theme(rubrique_id, description)
    values
           /* Informatique */
          (1,'Langages'),(1,'Outils de Developpement'),
          (2,'Management des SI'),(2,'Conception & Developpement Web'),
          (3,'Windows'),(3,'Linux'),
          (4,'Architecture des ordinateurs'),(4,'Peripheriques'),
          (5,'Conception et Modélisation'),(5,'SQL'),
          (6,'Conception et architecture réseau'),

           /* Construction */
          (11,'Plans-Dessins'),(11,'Appartement'),
          (12,'Calcul de Structure'),(12,'Beton arme et precontraint'),
          (13,'Plans-Dessins'),(13,'Appartement'),
          (14,'Maison traditionnelle'),(14,'Rehabilitation batiment'),
          (15,'Droit urbanisme'),(15,'Histoire urbanisme'),

            /* Entreprise */
          (16,'Actualite Economique'),(16,'MacroEconomie-MicroEconomie'),
          (17,'Consultant-Freelance-TPE'),(17,'Business Plan'),
          (18,'Innovation'),(18,'Brevets'),
          (19,'Diriger-Decider'),(19,'Gerer un projet'),

            /* Sciences */
          (22,'Mathematiques appliquees'),(22,'Logiciels de calcul'),
          (23,'Physique fondamentale'),(23,'Mecanique'),
          (24,'Chimie organique'),(24,'Chimie inorganique'),
          (25,'Biologie'),(25,'Geologie'),
          (26,'Electronique'),(26,'Dessin industriel'),

             /* Litterature */
          (27,'Policier-Thriller'),(27,'Science Fiction'),

            /* Arts & Loisirs & Vie Pratique */
          (32,'Animaux'),
          (33,'Paris-Tour de France-Guides'),(34,'Livres de cuisine'),
          (37,'Francais'),(37,'Anglais');

/* Livres */

    insert into livre(theme_id, titre,prix,isbn,date_parution,resumer,image_name,updated_at)
    values (1,'Apprenez à programmer en Python',20,'978-2-212-67871-0','2019-11-21','Vous n\'y connaissez rien en programmation et vous souhaitez apprendre un langage clair et intuitif ? Python est fait pour vous ! ','livre1.jpg',current_timestamp),
           (12,'Revit pour les architectes',34,'978-2-212-67576-4','2018-08-30','Édité par Autodesk, Revit est le principal logiciel d\'architecture intégrant les concepts du BIM (Building Information Modeling)','livre2.jpg',current_timestamp),
           (29,'Gestion de projets',28,'978-2-326-00097-1','2015-06-27','Développer de nouveaux produits, réorganiser la chaîne logistique, interrompre certaines activités...','livre3.jpg',current_timestamp),
           (30,'Mathematiques des sciences appliquees',33,'978-2-7298-5278-8','2009-12-23','Les sciences appliquées et les techniques de l\'ingénieur font constamment appel à des outils mathématiques sophistiqués.','livre4.jpg',current_timestamp),
           (40,'Le miroir aux espions',8,'9782757885987','2020-08-13','En pleine Guerre froide, le Service, organe obscur des renseignements britanniques, décide d''enquêter sur ce qui se trame en Allemagne de l''Est. ','livre5.jpg',current_timestamp),
           (42,'Les secrets de la photo d\'animaux',18,'978-2-212-67642-6','2018-11-01','Une plongée ou cœur de la nature sauvage en compagnie de l\'un des meilleurs photographes animaliers.','livre6.jpg',current_timestamp),
           (46,'Minimum competence in scientific English',14,'978-2-7598-0808-3','2013-02-14','Cet ouvrage, devenue célèbre sous son sigle MCSE, a déjà été utilisé par environ 200 000 personnes, étudiants, chercheurs, universitaires, ingénieurs... ','livre7.jpg',current_timestamp),

           (1,'DevOps',34,'978-2-7598-0668-3','2019-11-21','test','carImg3',current_timestamp);

/* Editeur */

    insert into editeur(maison_edition)
    values ('Eyrolles'),
           ('Seuil');

/* Auteur */

    insert into auteur (nom_auteur,prenom_auteur)
    values ('Navarra','Pierre'), ('Guezo','Julie'), ('LeGolf','Vincent'),('Buttrick','Robert'),('Le Carre','John'),
           ('BALANCA','Erwan');

/* Client */

    insert into client (email, mot_de_passe, nom_client)
    values ('user@domain','1234','User'),('sabrine@dwwm.as','1234','Guedda'), ('bakary@dwwm.as','1234','Traore'),('toulepi@dwwm.as','1234','Toulepi');

/* Exemplaire */

    insert into exemplaire (livre_id, editeur_id, prix_unitaire)
    values (1,1,20),(5,2,8),(2,1,34),(6,1,18);

/* Commentaire */
    /* Un attribut a été ajouté à l'entité 'Commentaire' afin de pouvoir récupérer le commentaire de l'utilisateur'*/

    insert into commentaire (client_id, livre_id, date_commentaire,comment)
    values (1,1,'2020-06-15','Tres bon livre, bien explique et correspond a mes attentes'),
           (1,1,'2018-08-30','Cet ouvrage est bien ecrit et contient enormement de conseils, d\'astuces d\'explications utiles pour bien maitriser Revit'),
           (3,6,'2020-08-17','Un livre tres bien realise par le photographe professionnel Erwan BALANCA');

/* Rediger  */
    insert into Rediger (auteur_id, livre_id)
    values (5,5), (6,6);

/* Commande */
insert into commande (id, client_id, numero_commande, adresse_livraison, date_commande)
    values (1,1,'cmd01','9B rue de la Sablière, Asnieres','2020-08-18'),
           (2,2,'cmd02','6 rue des heritiers,Gennevilliers','2017-04-10'),
           (3,3,'cmd03','3 rue Gennot,Cergy','2020-06-10'),
           (4,4,'cmd04','3 rue de Diakite,Mali','2016-09-18'),
           (5,1,'cmd05','9B rue de la Sablière,Asnieres','2016-06-10'),
           (6,2,'cmd06','6 rue des heritiers,Gennevilliers','2020-01-10'),
           (7,3,'cmd07','3 rue Gennot,Cergy','2020-06-10');

/* Ligne de Commande */

    insert into ligne_commande (commande_id, exemplaire_id, quantite, pourcentage_remise)
    values (1,1,2,0),(2,4,1,5),(3,4,1,0),(4,4,3,10),(5,3,1,3),(6,2,1,0), (7,4,5,15);

/* Test de cohérence de la BDD */
/*================================

/* Quelques Requetes */

    /* 1- récupérer le catalogue auquel appartient le livre de titre "Revit pour les architectes" */

        /*  select mot_cle
            from catalogue,rubrique
            where rubrique.catalogue_id = catalogue.id and (classement in  (select classement
                                                                          from rubrique,theme
                                                                          where theme.id = rubrique.id and theme.id in (select theme.id
                                                                                                                       from livre,theme
                                                                                                                  where livre.theme_id = theme.id )));
        */

        /*
            select titre
            from livre
            where titre not in (
            select titre
            from livre,theme,rubrique,catalogue
            where livre.theme_id = theme.id
            and theme.id = rubrique.id
            and rubrique.catalogue_id = catalogue.id
            );
        */
        /*
            select distinct titre,description,classement,mot_cle
            from livre,theme,rubrique,catalogue
            where livre.theme_id = theme.id
            and theme.id = rubrique.id
            and rubrique.catalogue_id = catalogue.id;
            and titre = "Revit pour les architectes";
        */

        /*
            select *
            from livre, theme
            left join theme on  livre.theme_id = theme.id;
            where theme.rubrique_id = rubrique.id;
        */

    /* 2- Afficher toutes les commandes */

        /*
        select  client_id,numero_commande,date_commande,adresse_livraison
        from commande;
         */

    /* 3- Afficher les commandes effectuées par un client */

        /*
        select nom_client,numero_commande,date_commande
        from commande,client
        where client.id = commande.client_id
        and client_id = 1;
         */

    /* 4- Afficher la somme de la commande effectuée par un client donné */

        /*
        select nom_client,quantite,prix_unitaire,numero_commande,pourcentage_remise,exemplaire_id,commande_id,(quantite * prix_unitaire) as somme
        from client,commande,ligne_commande,exemplaire
        where client.id = commande.client_id
          and commande.id = ligne_commande.commande_id
          and ligne_commande.exemplaire_id= exemplaire.id
         group by nom_client;
          and client_id = 1;
        */

        /*
            select client_id,quantite,pourcentage_remise,prix_unitaire
            from exemplaire,ligne_commande,
                where ligne_commande.exemplaire_id= exemplaire.id and (classement in  (select quantite,pourcentage_remise
                                                                              from commande,ligne_commande
                                                                              where commande.id = ligne_commande.commande_id and client_id in (select client_id
                                                                                                                                           from client
                                                                                                                                            where client_id=1 )));
        */

    /* 5- Afficher les clients qui ont commandé un exemplaire donné */

        /*
        select nom_client,adresse_livraison, quantite,exemplaire_id,titre
        from client,commande,ligne_commande,exemplaire,livre
        where client.id = commande.client_id
          and commande.id = ligne_commande.commande_id
          and ligne_commande.exemplaire_id= exemplaire.id
          and exemplaire.livre_id = livre.id
          group by nom_client;
          and exemplaire_id = 4;
        */

    /* 6- CA réalisé par client */

        /*
        select nom_client, quantite,prix_unitaire,(quantite * prix_unitaire) as CA
        from client,commande,ligne_commande,exemplaire,livre
        where client.id = commande.client_id
          and commande.id = ligne_commande.commande_id
          and ligne_commande.exemplaire_id= exemplaire.id
          and exemplaire.livre_id = livre.id
          order by nom_client;
         */

    /* 7- Afficher le CA réalisé */

        /*
        create temporary table CACM (select nom_client, quantite,prix_unitaire,(quantite * prix_unitaire) as CA
            from client,commande,ligne_commande,exemplaire,livre
            where client.id = commande.client_id
            and commande.id = ligne_commande.commande_id
            and ligne_commande.exemplaire_id= exemplaire.id
            and exemplaire.livre_id = livre.id);
        select sum(CA) as somme
        from CACM;
         */
