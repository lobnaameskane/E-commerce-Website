/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     04/01/2021 23:21:23                          */
/*==============================================================*/


drop table if exists adresse;

drop table if exists avis;

drop table if exists categorie;

drop table if exists client;

drop table if exists commande;

drop table if exists marque;

drop table if exists options;

drop table if exists panier;

drop table if exists produit;

drop table if exists qt_commande;

drop table if exists utilisateurs;

drop table if exists wishlist;

/*==============================================================*/
/* Table: adresse                                               */
/*==============================================================*/
create table adresse
(
   id_adresse           int not null,
   id_client            int not null,
   adresse              varchar(1024) not null,
   code_postal          int not null,
   nom_complet          varchar(25) not null,
   tel_adresse_client   varchar(10),
   primary key (id_adresse)
);

/*==============================================================*/
/* Table: avis                                                  */
/*==============================================================*/
create table avis
(
   id_client            int not null,
   id_produit           int not null,
   ranking              int,
   date_avis            date,
   commentaire          varchar(1024),
   primary key (id_client, id_produit)
);

/*==============================================================*/
/* Table: categorie                                             */
/*==============================================================*/
create table categorie
(
   id_categorie         int not null,
   nom_categorie        varchar(1024) not null,
   primary key (id_categorie)
);

/*==============================================================*/
/* Table: client                                                */
/*==============================================================*/
create table client
(
   id_client            int not null,
   nom_client           varchar(25) not null,
   prenom_client        varchar(25) not null,
   tel_client           varchar(10) not null,
   date_naissance       date,
   sexe                 varchar(1),
   email                varchar(25) not null,
   mdp_client           varchar(50) not null,
   primary key (id_client)
);

/*==============================================================*/
/* Table: commande                                              */
/*==============================================================*/
create table commande
(
   id_commande          int not null,
   id_client            int not null,
   id_user              int not null,
   date_commande        datetime not null,
   valide               bool not null,
   prix_commande        decimal(8),
   etat_actuell         varchar(50),
   date_etat_actuel     datetime,
   script_etat          varchar(1024),
   primary key (id_commande)
);

/*==============================================================*/
/* Table: marque                                                */
/*==============================================================*/
create table marque
(
   id_marque            int not null,
   nom_marque           varchar(45),
   primary key (id_marque)
);

/*==============================================================*/
/* Table: options                                               */
/*==============================================================*/
create table options
(
   options              varchar(1024) not null,
   type_options         varchar(20) not null,
   id_options           int not null,
   id_produit           int not null,
   primary key (id_options)
);

/*==============================================================*/
/* Table: panier                                                */
/*==============================================================*/
create table panier
(
   id_client            int not null,
   id_produit           int not null,
   qtt_panier           int,
   primary key (id_client, id_produit)
);

/*==============================================================*/
/* Table: produit                                               */
/*==============================================================*/
create table produit
(
   id_produit           int not null,
   id_marque            int not null,
   id_categorie         int not null,
   `label`              varchar(1024) not null,
   prix_produit         varchar(50),
   primary key (id_produit)
);

/*==============================================================*/
/* Table: qt_commande                                           */
/*==============================================================*/
create table qt_commande
(
   id_produit           int not null,
   id_commande          int not null,
   prix_produit_commande float,
   qtt_commande         int,
   primary key (id_produit, id_commande)
);

/*==============================================================*/
/* Table: utilisateurs                                          */
/*==============================================================*/
create table utilisateurs
(
   id_user              int not null,
   nom_user             varchar(25) not null,
   prenom_user          varchar(25) not null,
   email_user           varchar(25) not null,
   mdp_user             varchar(100) not null,
   is_admin             bool not null,
   tel_user             varchar(10) not null,
   fonction             varchar(25) not null,
   primary key (id_user)
);

/*==============================================================*/
/* Table: wishlist                                              */
/*==============================================================*/
create table wishlist
(
   id_client            int not null,
   id_produit           int not null,
   primary key (id_client, id_produit)
);

alter table adresse add constraint fk_a_comme_adresse foreign key (id_client)
      references client (id_client) on delete restrict on update restrict;

alter table avis add constraint fk_avis foreign key (id_client)
      references client (id_client) on delete restrict on update restrict;

alter table avis add constraint fk_avis2 foreign key (id_produit)
      references produit (id_produit) on delete restrict on update restrict;

alter table commande add constraint fk_passe foreign key (id_client)
      references client (id_client) on delete restrict on update restrict;

alter table commande add constraint fk_valide_par foreign key (id_user)
      references utilisateurs (id_user) on delete restrict on update restrict;

alter table options add constraint fk_a_comme_option foreign key (id_produit)
      references produit (id_produit) on delete restrict on update restrict;

alter table panier add constraint fk_panier foreign key (id_client)
      references client (id_client) on delete restrict on update restrict;

alter table panier add constraint fk_panier2 foreign key (id_produit)
      references produit (id_produit) on delete restrict on update restrict;

alter table produit add constraint fk_appartient foreign key (id_marque)
      references marque (id_marque) on delete restrict on update restrict;

alter table produit add constraint fk_appartient_a foreign key (id_categorie)
      references categorie (id_categorie) on delete restrict on update restrict;

alter table qt_commande add constraint fk_qt_commande foreign key (id_produit)
      references produit (id_produit) on delete restrict on update restrict;

alter table qt_commande add constraint fk_qt_commande2 foreign key (id_commande)
      references commande (id_commande) on delete restrict on update restrict;

alter table wishlist add constraint fk_wishlist foreign key (id_client)
      references client (id_client) on delete restrict on update restrict;

alter table wishlist add constraint fk_wishlist2 foreign key (id_produit)
      references produit (id_produit) on delete restrict on update restrict;

