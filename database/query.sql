DROP DATABASE IF EXISTS gestion_etudiants_db; 

CREATE DATABASE gestion_etudiants_db;

 create table Classe(
     id_classe int primary key AUTO_INCREMENT,
     nom varchar(25) not null

 );

create table Etudiant(
     id_etudiant int primary key AUTO_INCREMENT ,
     nom varchar(25) not null,
     prenom varchar(25) not null ,
     cne varchar(25) not null,
     date_naissance date not null,
     email varchar(50) not null unique,
     password varchar(50) not null,
     image varchar(255),
     id_classe int,
     FOREIGN key(id_classe) REFERENCES Classe(id_classe) 

);


CREATE TABLE Enseignant(
   id_enseignant int AUTO_INCREMENT primary key, 
   nom varchar(25) NOT NULL , 
   prenom varchar(25) NOT NULL , 
   cin varchar(25) NOT NULL,
   image varchar(25), 
   date_naissance date NOT NULL,
   email varchar(50) not null unique,
   password varchar(50)
); 

 create table Matiere(
     id_matiere int primary key AUTO_INCREMENT,
     nom varchar(25) not null,
     id_enseignant int not null,
     id_classe int not null ,
     FOREIGN key(id_classe) REFERENCES Classe(id_classe),
     FOREIGN key(id_enseignant) REFERENCES Enseignant(id_enseignant)
 );

CREATE TABLE Note(
   id_note int AUTO_INCREMENT primary key, 
   note float,
   id_matiere int not null,
   id_etudiant int not null,
   FOREIGN KEY(id_matiere) REFERENCES Matiere(id_matiere) , 
   FOREIGN KEY(id_etudiant) REFERENCES Etudiant(id_etudiant)
);


-- 

ALTER TABLE Note 
DROP CONSTRAINT `constaint_name`;

ALTER TABLE Note 
ADD FOREIGN KEY(id_matiere) REFERENCES Matiere(id_matiere) ON DELETE CASCADE;


