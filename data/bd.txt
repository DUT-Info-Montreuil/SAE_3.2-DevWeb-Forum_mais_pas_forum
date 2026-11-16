CREATE TABLE Jeux(
   id_jeux INT,
   nom_jeux VARCHAR(256) NOT NULL,
   description_jeux VARCHAR(256),
   configuration_minimal VARCHAR(256),
   configuration_requise VARCHAR(256),
   PRIMARY KEY(id_jeux)
);

CREATE TABLE Role(
   id_role INT,
   role VARCHAR(256) NOT NULL,
   PRIMARY KEY(id_role),
   UNIQUE(role)
);

CREATE TABLE Discussion(
   id_discussion INT,
   titre VARCHAR(256),
   id_jeux INT NOT NULL,
   PRIMARY KEY(id_discussion),
   FOREIGN KEY(id_jeux) REFERENCES Jeux(id_jeux)
);

CREATE TABLE Genre(
   id_genre INT,
   Genre VARCHAR(256) NOT NULL,
   PRIMARY KEY(id_genre),
   UNIQUE(Genre)
);

CREATE TABLE Studio(
   id_studio INT,
   nom_studio VARCHAR(256),
   nb_abonne INT,
   PRIMARY KEY(id_studio)
);

CREATE TABLE Extension(
   id_extension INT,
   nom_extension VARCHAR(256) NOT NULL,
   description_extension VARCHAR(256),
   configuration_minimal VARCHAR(256),
   configuration_requise VARCHAR(256),
   id_studio INT NOT NULL,
   id_jeux INT NOT NULL,
   PRIMARY KEY(id_extension),
   FOREIGN KEY(id_studio) REFERENCES Studio(id_studio),
   FOREIGN KEY(id_jeux) REFERENCES Jeux(id_jeux)
);

CREATE TABLE Demande(
   id_demande INT,
   description_demande VARCHAR(256),
   date_demande DATE,
   type_demande VARCHAR(256),
   PRIMARY KEY(id_demande)
);

CREATE TABLE Utilisateur(
   id_utilisateur INT,
   nom_utilisateur VARCHAR(256) NOT NULL,
   mot_de_passe VARCHAR(256) NOT NULL,
   email VARCHAR(256),
   id_demande INT NOT NULL,
   id_role INT NOT NULL,
   PRIMARY KEY(id_utilisateur),
   UNIQUE(email),
   FOREIGN KEY(id_demande) REFERENCES Demande(id_demande),
   FOREIGN KEY(id_role) REFERENCES Role(id_role)
);

CREATE TABLE Message(
   id_message INT,
   contenu VARCHAR(256),
   date_message DATE,
   id_utilisateur INT NOT NULL,
   id_discussion INT NOT NULL,
   PRIMARY KEY(id_message),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_discussion) REFERENCES Discussion(id_discussion)
);

CREATE TABLE Effectuer(
   id_utilisateur INT,
   id_demande INT,
   PRIMARY KEY(id_utilisateur, id_demande),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_demande) REFERENCES Demande(id_demande)
);

CREATE TABLE Enregistrer_Bibliothèque_(
   id_utilisateur INT,
   id_jeux INT,
   PRIMARY KEY(id_utilisateur, id_jeux),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_jeux) REFERENCES Jeux(id_jeux)
);

CREATE TABLE Donne_avis(
   id_utilisateur INT,
   id_jeux INT,
   description_avis VARCHAR(256),
   note INT,
   PRIMARY KEY(id_utilisateur, id_jeux),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_jeux) REFERENCES Jeux(id_jeux)
);

CREATE TABLE Detient(
   id_jeux INT,
   id_genre INT,
   PRIMARY KEY(id_jeux, id_genre),
   FOREIGN KEY(id_jeux) REFERENCES Jeux(id_jeux),
   FOREIGN KEY(id_genre) REFERENCES Genre(id_genre)
);

CREATE TABLE Suit(
   id_utilisateur INT,
   id_studio INT,
   date_abonnement DATE,
   PRIMARY KEY(id_utilisateur, id_studio),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_studio) REFERENCES Studio(id_studio)
);

CREATE TABLE Developper(
   id_jeux INT,
   id_studio INT,
   PRIMARY KEY(id_jeux, id_studio),
   FOREIGN KEY(id_jeux) REFERENCES Jeux(id_jeux),
   FOREIGN KEY(id_studio) REFERENCES Studio(id_studio)
);

CREATE TABLE Notification_demande(
   id_utilisateur INT,
   id_demande INT,
   date_notif_demande DATE,
   description_notif_demande VARCHAR(256),
   PRIMARY KEY(id_utilisateur, id_demande),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_demande) REFERENCES Demande(id_demande)
);

CREATE TABLE Avoir(
   id_genre INT,
   id_extension INT,
   PRIMARY KEY(id_genre, id_extension),
   FOREIGN KEY(id_genre) REFERENCES Genre(id_genre),
   FOREIGN KEY(id_extension) REFERENCES Extension(id_extension)
);


