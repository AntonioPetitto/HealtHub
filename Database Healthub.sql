CREATE TABLE utente(

  id_utente INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(100) UNIQUE,
  pass VARCHAR(100),
  data_registrazione DATE
  );

CREATE TABLE anagrafica(

  id_anagrafica INT PRIMARY KEY AUTO_INCREMENT,
  codice_fiscale VARCHAR(16) UNIQUE, 
  cie VARCHAR(9) UNIQUE,
  nome VARCHAR(55), 
  cognome VARCHAR(55),
  telefono DECIMAL(12) UNIQUE,
  data_nascita DATE,  
  sesso CHAR(1),          
  nazionalità VARCHAR(55),
  città VARCHAR(55),
  indirizzo VARCHAR(55),
  id_utente INT,
  FOREIGN KEY (id_utente) REFERENCES utente(id_utente)
 ); 

CREATE TABLE paziente(

  id_paziente INT PRIMARY KEY AUTO_INCREMENT,
  id_utente INT,
  FOREIGN KEY (id_utente) REFERENCES utente(id_utente)
 );

CREATE TABLE ambulatorio(

    id_ambulatorio INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) UNIQUE,
    ora_apertura TIME,
    ora_chiusura TIME
);

CREATE TABLE compagnie_assicurative(

    id_compagnie INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45),
    telefono DECIMAL(12) UNIQUE,
    email VARCHAR(255) UNIQUE
); 

CREATE TABLE assicurazione(

    numero_polizza INT PRIMARY KEY,
    tipo VARCHAR(55),
    data_scadenza DATE,
    id_paziente INT UNIQUE,
    id_compagnie INT,
    FOREIGN KEY (id_paziente) REFERENCES paziente(id_paziente),
    FOREIGN KEY (id_compagnie) REFERENCES compagnie_assicurative(id_compagnie)
);

CREATE TABLE farmaci(

    id_farmaco varchar(11) PRIMARY KEY,
    nome VARCHAR(255)
);

CREATE TABLE farmacie(

    id_farmacia INT PRIMARY KEY AUTO_INCREMENT,
    id_ambulatorio INT,
    FOREIGN KEY (id_ambulatorio) REFERENCES ambulatorio(id_ambulatorio)
);
                   
CREATE TABLE farmaci_disponibili(

    id_farmaco_disponibile INT PRIMARY KEY AUTO_INCREMENT,
    id_farmaco varchar(11),
    id_farmacia INT,
    quantità INT CHECK (quantità >= 0),
    scadenza DATE,
    FOREIGN KEY (id_farmaco) REFERENCES farmaci(id_farmaco),
    FOREIGN KEY (id_farmacia) REFERENCES farmacie(id_farmacia)
);

CREATE TABLE modalita(
    id_modalità INT PRIMARY KEY AUTO_INCREMENT,
    metodo VARCHAR(40)
);


CREATE TABLE calendario(
  
   id_calendario INT PRIMARY KEY AUTO_INCREMENT,
   settimana INT,
   mese INT,
   anno INT
   
);

CREATE TABLE dipendente(
    id_dipendente INT PRIMARY KEY AUTO_INCREMENT,        
    ruolo VARCHAR(30),
    id_utente INT,
    id_ambulatorio INT,
    FOREIGN KEY (id_utente) REFERENCES UTENTE(id_utente),
    FOREIGN KEY (id_ambulatorio) REFERENCES AMBULATORIO(id_ambulatorio)
);

CREATE TABLE contratto (
    id_contratto INT PRIMARY KEY AUTO_INCREMENT,
    stipendio DECIMAL,
    tipo VARCHAR(30),
    data_cessazione DATE,
    id_dipendente INT,
    FOREIGN KEY (id_dipendente) REFERENCES dipendente(id_dipendente)
);

CREATE TABLE turno(
    id_turno INT PRIMARY KEY AUTO_INCREMENT,
    id_dipendente INT,
    id_calendario INT,
    giorno varchar(10),
    ora_inizio TIME,
    ora_fine TIME,
    FOREIGN KEY (id_dipendente) REFERENCES dipendente(id_dipendente),
    FOREIGN KEY (id_calendario) REFERENCES calendario(id_calendario)
);
                   
CREATE TABLE visita(
    id_visita INT PRIMARY KEY AUTO_INCREMENT,
    id_paziente INT,
    id_dipendente INT,
    id_ambulatorio INT,
    data_visita DATE,
    ora_visita TIME,
    stato VARCHAR(255),
    FOREIGN KEY (id_paziente) REFERENCES paziente(id_paziente),
    FOREIGN KEY (id_dipendente) REFERENCES dipendente(id_dipendente),
    FOREIGN KEY (id_ambulatorio) REFERENCES ambulatorio(id_ambulatorio)
);

CREATE TABLE fattura(
  
    numero_fattura INT PRIMARY KEY AUTO_INCREMENT,
    importo DECIMAL,
    data_pagamento DATE,
    pagato VARCHAR(255),
    id_modalità INT,
    numero_polizza INT,
    id_visita INT,
    FOREIGN KEY(id_modalità) REFERENCES modalita(id_modalità),
    FOREIGN KEY(numero_polizza) REFERENCES assicurazione(numero_polizza),
    FOREIGN KEY(id_visita) REFERENCES visita(id_visita)
);

CREATE TABLE referto (
    id_referto INT PRIMARY KEY AUTO_INCREMENT,
    nome_file VARCHAR(255) UNIQUE NOT NULL,
    peso_file INT NOT NULL,
    tipo_file varchar(100) NOT NULL,
    data_upload timestamp NOT NULL DEFAULT current_timestamp(),
    id_visita INT,
    FOREIGN KEY (id_visita) REFERENCES visita(id_visita)    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


                   
CREATE OR REPLACE VIEW UteAna AS SELECT utente.id_utente, email, pass, data_registrazione, id_anagrafica, codice_fiscale, cie, nome, cognome, telefono, data_nascita, nazionalità, sesso, indirizzo 
FROM utente JOIN anagrafica on utente.id_utente = anagrafica.id_utente;

CREATE OR REPLACE VIEW UteAnaDipConAmb AS SELECT utente.id_utente, email, pass, dipendente.id_dipendente, anagrafica.nome, cognome, ruolo, ambulatorio.id_ambulatorio, ambulatorio.nome AS nome_ambulatorio, stipendio, tipo, contratto.data_cessazione 
FROM utente JOIN anagrafica ON utente.id_utente = anagrafica.id_utente JOIN dipendente ON utente.id_utente = dipendente.id_utente JOIN contratto ON dipendente.id_dipendente = contratto.id_dipendente LEFT JOIN ambulatorio ON dipendente.id_ambulatorio = ambulatorio.id_ambulatorio;

CREATE OR REPLACE VIEW UteAnaPazAssCom AS SELECT utente.id_utente, paziente.id_paziente, anagrafica.nome, cognome, numero_polizza, tipo, data_scadenza, compagnie_assicurative.nome as nome_compagnia 
FROM utente JOIN anagrafica on utente.id_utente = anagrafica.id_utente JOIN paziente on utente.id_utente = paziente.id_utente LEFT JOIN assicurazione on paziente.id_paziente = assicurazione.id_paziente LEFT JOIN compagnie_assicurative on assicurazione.id_compagnie = compagnie_assicurative.id_compagnie;

CREATE OR REPLACE VIEW UteAnaPazVisDipAmb AS SELECT utente.id_utente, visita.id_paziente, visita.id_visita, anagrafica.nome, cognome, data_visita, ora_visita, visita.stato, ambulatorio.nome AS nome_ambulatorio, nome_file 
FROM utente JOIN anagrafica ON utente.id_utente = anagrafica.id_utente JOIN paziente ON utente.id_utente = paziente.id_utente JOIN visita ON paziente.id_paziente = visita.id_paziente JOIN dipendente ON visita.id_dipendente = dipendente.id_dipendente JOIN ambulatorio ON visita.id_ambulatorio = ambulatorio.id_ambulatorio LEFT JOIN referto on visita.id_visita = referto.id_visita 
WHERE visita.stato = 'corso';

CREATE OR REPLACE VIEW UteAnaPazVisAmbDip AS SELECT utente.id_utente, visita.id_paziente, visita.id_visita, anagrafica.nome, cognome, data_visita, ora_visita, visita.stato, ambulatorio.nome AS nome_ambulatorio, nome_file 
FROM utente JOIN anagrafica ON utente.id_utente = anagrafica.id_utente JOIN paziente ON utente.id_utente = paziente.id_utente JOIN visita ON paziente.id_paziente = visita.id_paziente JOIN dipendente ON visita.id_dipendente = dipendente.id_dipendente JOIN ambulatorio ON visita.id_ambulatorio = ambulatorio.id_ambulatorio LEFT JOIN referto on visita.id_visita = referto.id_visita 
WHERE visita.stato = 'svolta';

CREATE OR REPLACE VIEW AmbFarFarFar AS SELECT farmaci_disponibili.id_farmaco_disponibile, farmacie.id_farmacia, farmaci.id_farmaco, ambulatorio.nome as nome_ambulatorio, farmaci.nome as nome_farmaco, quantità, scadenza 
FROM ambulatorio JOIN farmacie ON ambulatorio.id_ambulatorio = farmacie.id_ambulatorio JOIN farmaci_disponibili ON farmacie.id_farmacia = farmaci_disponibili.id_farmacia JOIN farmaci ON farmaci_disponibili.id_farmaco = farmaci.id_farmaco;

CREATE OR REPLACE VIEW UteAnaDipConTurCal AS SELECT utente.id_utente, dipendente.id_dipendente, dipendente.id_ambulatorio, ambulatorio.nome as nome_ambulatorio, dipendente.ruolo, anagrafica.nome, cognome, id_turno, calendario.id_calendario, ora_inizio, ora_fine, giorno, settimana, mese, anno, contratto.data_cessazione 
FROM utente JOIN anagrafica ON utente.id_utente = anagrafica.id_utente JOIN dipendente ON utente.id_utente = dipendente.id_utente JOIN contratto ON dipendente.id_dipendente = contratto.id_dipendente JOIN turno ON dipendente.id_dipendente = turno.id_dipendente JOIN calendario on turno.id_calendario = calendario.id_calendario JOIN ambulatorio on dipendente.id_ambulatorio = ambulatorio.id_ambulatorio;

CREATE OR REPLACE VIEW UteAnaDipConTurCal2 AS SELECT DISTINCT utente.id_utente, dipendente.id_dipendente, dipendente.id_ambulatorio, ambulatorio.nome as nome_ambulatorio, calendario.id_calendario, dipendente.ruolo, anagrafica.nome, cognome, settimana, mese, anno, contratto.tipo, contratto.data_cessazione 
FROM utente JOIN anagrafica ON utente.id_utente = anagrafica.id_utente JOIN dipendente ON utente.id_utente = dipendente.id_utente JOIN contratto ON dipendente.id_dipendente = contratto.id_dipendente JOIN turno ON dipendente.id_dipendente = turno.id_dipendente JOIN calendario on turno.id_calendario = calendario.id_calendario JOIN ambulatorio on dipendente.id_ambulatorio = ambulatorio.id_ambulatorio;

CREATE OR REPLACE VIEW UteAnaDipVisAmbRef AS SELECT visita.id_visita, visita.id_paziente, anagrafica.nome, cognome, ambulatorio.nome AS nome_ambulatorio, data_visita, ora_visita, visita.stato, nome_file 
FROM utente JOIN anagrafica ON utente.id_utente = anagrafica.id_utente JOIN dipendente on utente.id_utente = dipendente.id_utente JOIN visita on dipendente.id_dipendente = visita.id_dipendente JOIN ambulatorio on dipendente.id_ambulatorio = ambulatorio.id_ambulatorio LEFT JOIN referto on visita.id_visita = referto.id_visita;









