/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS,UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS,FOREIGN_KEY_CHECKS=0 */;

drop table if exists lekarze;
drop table if exists pacjenci;
drop table if exists terminy_przyjec;
drop table if exists urlopy;
drop table if exists wizyty;

create table lekarze(
  id_lekarza int(11) not null primary key auto_increment,
  imie varchar(20) not null,
  nazwisko varchar(20) not null
);

create table pacjenci(
  id_pacjenta int(11) not null primary key auto_increment,
  imie varchar(20) not null,
  nazwisko varchar(20) not null,
  adres_ulica varchar(50) default null,
  adres_miasto varchar(50) default null,
  adres_kodpocztowy varchar(5) default null,
  pesel varchar(11) default null,
  telefon varchar(9) default null
);
  
create table terminy_przyjec(
  id_terminu int(11) not null primary key auto_increment,
  id_lekarza int(11) not null,
  nazwa_poradni varchar(20) not null,
  dzien_tygodnia tinyint(1) not null,
  godzina_otwarcia time not null,
  godzina_zamkniecia time not null,
  pomieszczenie varchar(5) default null,
  constraint terminy_przyjec_ibfk_1 foreign key (id_lekarza) references lekarze (id_lekarza) on update cascade
);

create table urlopy(
  id_urlopu int(11) not null primary key auto_increment,
  id_lekarza int(11) not null,
  data_rozpoczecia date not null,
  data_zakonczenia date not null,
  constraint urlopy_ibfk_1 foreign key (id_lekarza) references lekarze (id_lekarza) on update cascade
);

create table wizyty(
  id_wizyty int(11) not null primary key auto_increment,
  id_lekarza int(11) not null,
  id_pacjenta int(11) not null,
  data date not null,
  godzina_rozpoczecia time not null,
  godzina_zakonczenia time not null,
  constraint wizyty_ibfk_1 foreign key (id_lekarza) references lekarze (id_lekarza) on update cascade,
  constraint wizyty_ibfk_2 foreign key (id_pacjenta) references pacjenci (id_pacjenta) on update cascade
);

insert into lekarze values
(4,'Adam','Nowak'),
(5,'Jan','Krawczyk'),
(6,'Grzegorz','Wojciechowski'),
(7,'Edyta','Michalak'),
(8,'Maciej','Jabłoński')
;

insert into pacjenci values
(1,'Bronisław','Adamski','Kaczeńcowa 120','Poznań','60175','01272369525','549209453'),
(2,'Judyta','Wieczorek','Ciekocka 50','Kielce','25422','77091521293','272650323'),
(3,'Kazimiera','Rutkowska','Grochowska 115','Warszawa','04368','94092814436','936804126'),
(4,'Barbara','Wysocka','Sukiennicza 149','Kraków','31069','86021718401','93765202'),
(5,'Marcelina','Zawadzka','Wyzwolenia 14','Poznań','61204','61071058888','10857654'),
(6,'Miłogost','Michalski','Falenicka 79','Warszawa','04965','68040765334','792893663'),
(7,'Ziemowit','Piotrowski','Kościańska 87','Wrocław','54027','61071503517','665096104'),
(8,'Gabriela','Olszewska','Połczyńska 137','Warszawa','01302','72101814545','538410111')
;

insert into terminy_przyjec values
(1,6,'pediatryczna',1,'12:00:00','14:00:00','5'),
(2,6,'pediatryczna',3,'10:00:00','12:00:00','5'),
(3,6,'pediatryczna',5,'09:00:00','11:30:00','5'),
(4,6,'internistyczna',2,'08:00:00','10:00:00','3'),
(5,4,'internistyczna',1,'13:00:00','15:00:00','2'),
(6,4,'internistyczna',2,'09:00:00','12:00:00','2'),
(7,4,'internistyczna',5,'14:00:00','16:00:00','2'),
(8,7,'laryngologiczna',2,'09:00:00','10:30:00','2'),
(9,5,'medycyny pracy',5,'14:00:00','16:30:00','1')
;

insert into wizyty values
(1,6,2,'2020-06-02','09:30:00','00:00:10'),
(2,7,6,'2020-06-02','09:30:00','10:00:00'),
(3,5,1,'2020-06-05','14:00:00','14:30:00'),
(4,4,3,'2020-06-05','15:30:00','16:00:00'),
(5,4,2,'2020-06-02','11:30:00','12:00:00')
;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;