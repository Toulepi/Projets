create database if not exists game_db;

use game_db;

create table if not exists Users
(
    idUser          int auto_increment not null,
    prenom          varchar(30)        not null,
    email           varchar(20)        not null,
    password        varchar(20)               not null,
    constraint pk_users primary key (idUser),
    constraint uq_email_users unique (email)
);

create table if not exists Score
(
    idScore         int auto_increment not null,
    product         varchar(20),
    reponse        int,
    correct         varchar(10),
    idUser          int not null ,
    constraint pk_score primary key (idScore)
);

alter table Score
    add constraint fk_score_users
        foreign key (idUser) references Users(idUser);

insert into Users(prenom, email, password)
values ('Jeatsa', 'jeatsa@dwwm.ge', '1234'),
       ('Kueta', 'kueta@dwwm.ge', '1234');

insert into Score(product,reponse,correct,idUser)
values ('11x12',132,'OUI',1),
       ('89x67',1325,'NON',2);

/*drop database game_db;*/




