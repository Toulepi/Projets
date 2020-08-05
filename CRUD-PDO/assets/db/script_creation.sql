create database if not exists crud_pdo_db;

use crud_pdo_db;
create table if not exists Employes(
    id int auto_increment not null ,
    prenom varchar(50) not null ,
    ddn date,
    fonction varchar(50),
    email varchar(50),
    salaire int not null,
    constraint uq_prenom_employe UNIQUE (prenom),
    constraint uq_email_employe UNIQUE (email),
    constraint pk_employe primary key (id)
);

insert into Employes(prenom, ddn, fonction, email, salaire)
            values ('Joachim','1979-01-01','Developpeur','joachim@dawm.ge',50000);

insert into Employes(prenom, ddn, fonction, email, salaire)
values ('Badji','1980-01-01','DBA','badji@dawm.ge',150000);

