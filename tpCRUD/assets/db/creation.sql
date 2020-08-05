create database if not exists dwwm_db;

use dwwm_db;

create table if not exists Users
(
    idUser       int auto_increment not null,
    prenom   varchar(30)        not null,
    email    varchar(20)        not null,
    password  int                not null,
    constraint pk_users primary key (idUser),
    constraint uq_email_users unique (email)
);

create table if not exists Messsage
(
    idMessage              int auto_increment not null,
    Titre           varchar(20) ,
    Contenu         text(255) not null,
    dateInsertion   timestamp,
    idUser int not null ,
    constraint pk_message primary key (idMessage)
);

alter table Messsage
    add constraint fk_message_users
        foreign key (idUser) references Users(idUser);

insert into Users(prenom, email, password)
values ('Jeatsa', 'jeatsa@dwwm.ge', '1234'),
       ('Kueta', 'kueta@dwwm.ge', '1234'),
       ('Toulepi', 'toulepi@dwwm.ge', '1234');

insert into Messsage(Titre, contenu, dateInsertion,idUser)
values ('Bienvenue', 'Je suis Jeatsa, ingénieur informaticien de formation', current_date,1),
       ('Cameroun', 'Pays de l\'Afrique centrale très beau et riche tant au niveau naturel que culturel', current_date,1),
       ('Bienvenue', 'Je suis Jeatsa, ingénieur informaticien de formation', current_date,1);



