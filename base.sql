CREATE TABLE client (
    idClient INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE TypeTravaux (
    idTypeTravaux INT AUTO_INCREMENT PRIMARY KEY,
    nomTypeTravaux VARCHAR(100),
    numero VARCHAR(100)
);
INSERT INTO TypeTravaux (nomTypeTravaux, numero) VALUES ('TRAVAUX PREPARATIORE', '000');
INSERT INTO TypeTravaux (nomTypeTravaux, numero) VALUES ('TRAVAUX DE TERRASSEMENT', '100');
INSERT INTO TypeTravaux (nomTypeTravaux, numero) VALUES ('TRAVAUX EN INFRASTRUCTURE', '200');


CREATE TABLE Travaux (
    idTravaux INT AUTO_INCREMENT PRIMARY KEY,
    nomTypeTraveaux VARCHAR(100),
    designation VARCHAR(100),
    numero VARCHAR(100),
    pu FLOAT,
    unite VARCHAR(100)
);
INSERT INTO Travaux (nomTypeTraveaux, designation, numero, pu, unite) VALUES 
('TRAVAUX PREPARATIORE', 'Mur de soutenement et demi Cloture ht 1m', '001', 190000.00, 'm3');

INSERT INTO Travaux (nomTypeTraveaux, designation, numero, pu, unite) VALUES 
('TRAVAUX DE TERRASSEMENT', 'Décapage des terrains meubles', '101',3072.87, 'm2'),
('TRAVAUX DE TERRASSEMENT', 'Dressage du plateforme', '102',3736.26, 'm2'),
('TRAVAUX DE TERRASSEMENT', 'Fouille d''ouvrage terrain ferme', '103',9390.93, 'm3'),
('TRAVAUX DE TERRASSEMENT', 'Remblai d''ouvrage', '104',37563.26, 'm3'),
('TRAVAUX DE TERRASSEMENT', 'Travaux d''implantation', '105',152656.00, 'fft');

INSERT INTO Travaux (nomTypeTraveaux, designation, numero, pu, unite) VALUES 
('TRAVAUX EN INFRASTRUCTURE', 'Maçonnerie de moellons, ep= 35cm', '201',172114.40, 'm3'),
('TRAVAUX EN INFRASTRUCTURE', 'Beton armée dosée à 350kg/m3 - semelles isolée', '202',573215.80, 'm3'),
('TRAVAUX EN INFRASTRUCTURE', 'Beton armée dosée à 350kg/m3 - amorces poteaux', '202',573215.80, 'm3'),
('TRAVAUX EN INFRASTRUCTURE', 'Beton armée dosée à 350kg/m3 -  chaînage bas de 20x20', '202',573215.80, 'm3'),
('TRAVAUX EN INFRASTRUCTURE', 'Remblai technique', '203',37563.26, 'm3'),
('TRAVAUX EN INFRASTRUCTURE', 'Herrissonage ep=10', '204',73245.40, 'm3'),
('TRAVAUX EN INFRASTRUCTURE', 'Beton ordinaire dosée à 300kg/m3 pour for', '205',487815.80, 'm3'),
('TRAVAUX EN INFRASTRUCTURE', 'Chape de 2cm', '205',33566.4, 'm3');


CREATE TABLE TypeMaison (
    idTypeMaison INT AUTO_INCREMENT PRIMARY KEY,
    nomMaison VARCHAR(100),
    duree INT
);
INSERT INTO TypeMaison (nomMaison, duree) VALUES ('Maison en boit', 100);
INSERT INTO TypeMaison (nomMaison, duree) VALUES ('Maison en pierre', 120);
INSERT INTO TypeMaison (nomMaison, duree) VALUES ('Maison en parping', 140);

CREATE TABLE Maison (
    idMaison INT AUTO_INCREMENT PRIMARY KEY,
    idTypeMaison INT,
    nbrChambre INT,
    nbrSalon INT,
    nbrToilette INT,
    nbrCuisine INT,
    FOREIGN KEY (idTypeMaison) REFERENCES TypeMaison(idTypeMaison)
);
insert into Maison (idTypeMaison, nbrChambre, nbrSalon, nbrToilette, nbrCuisine)
values
    (1, 2, 1, 1, 1),
    (2, 3, 2, 2,
    (3, 4, 3, 3, 3);

CREATE TABLE Finition (
    idFinition INT AUTO_INCREMENT PRIMARY KEY,
    nomFinition VARCHAR(100),
    pourcentage INT
);
INSERT INTO Finition (nomFinition,pourcentage) VALUES
('Standard',1),
('Gold',2),
('Premium',5),
('VIP',15);

CREATE TABLE DemandeDevis (
    idDemandeDevis INT AUTO_INCREMENT PRIMARY KEY,
    idMaison INT,
    idClient INT,
    idFinition INT,
    DateCreation DateTime,
    DateDebut DateTime,
    DateFin DateTime,
    FOREIGN KEY (idMaison) REFERENCES Maison(idMaison),
    FOREIGN KEY (idClient) REFERENCES client(idClient),
    FOREIGN KEY (idFinition) REFERENCES Finition(idFinition)
);

CREATE TABLE Devis (
    idDevis INT AUTO_INCREMENT PRIMARY KEY, 
    nomDevis VARCHAR(100),
    idTypeMaison INT,
    FOREIGN KEY (idTypeMaison) REFERENCES TypeMaison(idTypeMaison)
);
INSERT INTO Devis (nomDevis,idTypeMaison) VALUES ('Devis maison boit', 1);
INSERT INTO Devis (nomDevis,idTypeMaison) VALUES ('Devis maison pierre',2);
INSERT INTO Devis (nomDevis,idTypeMaison) VALUES ('Devis maison parping', 3);

CREATE TABLE DevisDetails (
    idDeviseDetails INT AUTO_INCREMENT PRIMARY KEY,
    idDevis INT,
    idTravaux INT,
    quantite FLOAT,
    pu FLOAT,
    prixTotal FLOAT,
    FOREIGN KEY (idDevis) REFERENCES Devis(idDevis),
    FOREIGN KEY (idTravaux) REFERENCES Travaux(idTravaux)
);
INSERT INTO DevisDetails (idDevis,idTravaux,quantite,pu,prixTotal)
values
    (1, 1, 26.98, (select pu from travaux where idTravaux = 1),(select pu from travaux where idTravaux = 1)*26.98),
    (1, 2, 101.36, (select pu from travaux where idTravaux = 2),(select pu from travaux where idTravaux = 2)*101.36),
    (1, 3, 101.36, (select pu from travaux where idTravaux = 3),(select pu from travaux where idTravaux = 3)*101.36),
    (1, 4, 24.44, (select pu from travaux where idTravaux = 4),(select pu from travaux where idTravaux = 4)*24.44),
    (1, 5, 15.59, (select pu from travaux where idTravaux = 5),(select pu from travaux where idTravaux = 5)*15.59),
    (1, 6, 1, (select pu from travaux where idTravaux = 6),(select pu from travaux where idTravaux = 6)*1),
    (1, 7, 9.62, (select pu from travaux where idTravaux = 7),(select pu from travaux where idTravaux = 7)*9.62),
    (1, 8, 0.53, (select pu from travaux where idTravaux = 8),(select pu from travaux where idTravaux = 8)*0.53),
    (1, 9, 0.56, (select pu from travaux where idTravaux = 9),(select pu from travaux where idTravaux = 9)*0.56),
    (1, 10, 2.44, (select pu from travaux where idTravaux = 10),(select pu from travaux where idTravaux = 10)*2.44),
    (1, 11, 15.59, (select pu from travaux where idTravaux = 11),(select pu from travaux where idTravaux = 11)*15.59),
    (1, 12, 7.90, (select pu from travaux where idTravaux = 12),(select pu from travaux where idTravaux = 12)*7.90),
    (1, 13, 9.62, (select pu from travaux where idTravaux = 13),(select pu from travaux where idTravaux = 13)*9.62),
    (1, 14, 9.22, (select pu from travaux where idTravaux = 14),(select pu from travaux where idTravaux = 14)*9.22),
    --
    (2, 1, 26.98, (select pu from travaux where idTravaux = 1),(select pu from travaux where idTravaux = 1)*26.98),
    (2, 2, 101.36, (select pu from travaux where idTravaux = 2),(select pu from travaux where idTravaux = 2)*101.36),
    (2, 3, 151.36, (select pu from travaux where idTravaux = 3),(select pu from travaux where idTravaux = 3)*151.36),
    (2, 4, 24.44, (select pu from travaux where idTravaux = 4),(select pu from travaux where idTravaux = 4)*24.44),
    (2, 5, 15.59, (select pu from travaux where idTravaux = 5),(select pu from travaux where idTravaux = 5)*15.59),
    (2, 6, 12, (select pu from travaux where idTravaux = 6),(select pu from travaux where idTravaux = 6)*12),
    (2, 7, 9.62, (select pu from travaux where idTravaux = 7),(select pu from travaux where idTravaux = 7)*9.62),
    (2, 8, 3.53, (select pu from travaux where idTravaux = 8),(select pu from travaux where idTravaux = 8)*3.53),
    (2, 9, 0.56, (select pu from travaux where idTravaux = 9),(select pu from travaux where idTravaux = 9)*0.56),
    --
    (3, 10, 12.44, (select pu from travaux where idTravaux = 10),(select pu from travaux where idTravaux = 10)*12.44),
    (3, 11, 115.59, (select pu from travaux where idTravaux = 11),(select pu from travaux where idTravaux = 11)*115.59),
    (3, 12, 7.90, (select pu from travaux where idTravaux = 12),(select pu from travaux where idTravaux = 12)*7.90),
    (3, 13, 49.62, (select pu from travaux where idTravaux = 13),(select pu from travaux where idTravaux = 13)*49.62),
    (3, 14, 29.22, (select pu from travaux where idTravaux = 14),(select pu from travaux where idTravaux = 14)*29.22);
    



CREATE TABLE HistoriquePaiement (
    idHistorique INT AUTO_INCREMENT PRIMARY KEY,
    datePaiement DateTime,
    payer FLOAT,
    idDemandeDevis INT,
    FOREIGN KEY (idDemandeDevis) REFERENCES DemandeDevis(idDemandeDevis)

);


-- details travaux typeMaison

CREATE OR REPLACE View prixMaison AS
select d.idDevis,m.idMaison,tm.idTypeMaison,tm.nomMaison,sum(dd.prixTotal) as prixDevisTotal,m.nbrChambre,m.nbrCuisine,m.nbrSalon,m.nbrToilette from maison m
join typeMaison tm on m.idTypeMaison = tm.idTypeMaison
join devis d on tm.idTypeMaison = d.idTypeMaison
join DevisDetails dd on d.idDevis = dd.idDevis
group by m.idMaison,d.idDevis,tm.idTypeMaison,tm.nomMaison,m.nbrChambre,m.nbrCuisine,m.nbrSalon,m.nbrToilette;

-- details demande de devis

CREATE OR REPLACE VIEW ViewDemandeDevisDetails AS
SELECT 
    m.idMaison,
    f.idFinition,
    f.nomFinition,
    f.pourcentage,
    demande.DateCreation,
    demande.DateDebut,
    demande.DateFin,
    demande.idDemandeDevis,
    c.idClient,
    c.numero
FROM 
    demandeDevis demande
JOIN 
    maison m ON m.idMaison = demande.idMaison
JOIN 
    finition f ON f.idFinition = demande.idFinition
JOIN 
    client c ON c.idClient = demande.idClient
ORDER BY 
    demande.idDemandeDevis;

-- details Prix pourcentage

CREATE OR REPLACE VIEW ViewListeDevis_Prix AS

select d.*,p.prixDevisTotal,p.idDevis, 
CASE 
    WHEN d.pourcentage = 1 THEN p.prixDevisTotal
    WHEN d.pourcentage != 1 THEN (p.prixDevisTotal*d.pourcentage)/100 + p.prixDevisTotal
    END AS prixTotal,
CASE
    WHEN d.pourcentage = 1 THEN 0
    ELSE (p.prixDevisTotal * d.pourcentage) / 100
    END AS prixPourcentage
from ViewDemandeDevisDetails d 
join prixMaison p on p.idMaison=d.idMaison 

-- details Paiement

CREATE OR REPLACE VIEW ViewListeDevis_Paiement AS
SELECT 
    v.*,
    COALESCE(h.payer, 0) AS payer,
    v.prixTotal - COALESCE(h.payer, 0) AS resteAPayer,
    CASE
        WHEN COALESCE(h.payer, 0) = 0 THEN 'Non payé'
        WHEN COALESCE(h.payer, 0) < v.prixTotal THEN 'En cours'
        ELSE 'Payé'
    END AS etatPaiement
FROM 
    ViewListeDevis_Prix v
LEFT JOIN 
    historiquePaiement h ON h.idDemandeDevis = v.idDemandeDevis;

CREATE OR REPLACE VIEW ViewDetailsDevis AS
SELECT t.numero, t.designation, t.unite, dd.quantite, dd.pu, dd.prixTotal
FROM devisDetails dd
JOIN travaux t ON t.idTravaux = dd.idTravaux
WHERE dd.idDevis = $idDevis;




-- state

select distinct EXTRACT(year FROM v.DateCreation) AS annee
from ViewListeDevis_Prix v 
group by EXTRACT(year FROM v.DateCreation);


SELECT
    MONTH(d.DateCreation) AS mois,
    SUM(d.prixTotal) AS montantDevis
FROM
    ViewListeDevis_Prix d
WHERE EXTRACT(year FROM d.DateCreation) = 2023
GROUP BY
    MONTH(d.DateCreation);



ALTER TABLE demandeDevis
ADD  FOREIGN KEY (idMaison) REFERENCES maison(idMaison);

ALTER TABLE demandeDevis DROP FOREIGN KEY demandedevis_ibfk_1;
