# mrpdatabase
Applicazione php Mrpdatabase – rel. 2.8
Linguaggio Php 5 - database Mysql

Applicazione scritta in linguaggio php 5 utilizzata dal Museo Della Resistenza Piacentina per gestire il database dei Partigiani.


Vedere il file readme.odt per altre notizie e per gli screenshot.

I files che dovranno contenere le credenziali per accedere al database Mysql sono i seguenti:
atti_connect.php
cleanup_text.php
config.php
db_conn_i.php

L’Applicazione utilizza un database mysql chiamato mrpdatabase contenente 2 tabelle 
Struttura delle tabelle da utilizzare

 	mysql> describe partigiani;
+---------------+-------------+------+-----+---------+-------+
| Field         | Type        | Null | Key | Default | Extra |
+---------------+-------------+------+-----+---------+-------+
| codice        | bigint(20)  | NO   | PRI | NULL    |       |
| nome          | varchar(40) | NO   |     | NULL    |       |
| cognome       | varchar(40) | NO   |     | NULL    |       |
| paternit      | varchar(40) | NO   |     | NULL    |       |
| data_nasc     | date        | NO   |     | NULL    |       |
| luogonasci    | varchar(35) | NO   |     | NULL    |       |
| formazione    | varchar(50) | NO   |     | NULL    |       |
| qualifica     | varchar(40) | NO   |     | NULL    |       |
| grado         | varchar(30) | NO   |     | NULL    |       |
| inizio_arruol | date        | YES  |     | NULL    |       |
| fine_arruol   | date        | NO   |     | NULL    |       |
| nazionalit    | varchar(30) | NO   |     | NULL    |       |
| caduto        | varchar(2)  | NO   |     | no      |       |
| luogomorte    | varchar(50) | NO   |     | NULL    |       |
| data_morte    | date        | NO   |     | NULL    |       |
| evento        | varchar(50) | NO   |     | NULL    |       |
| associato     | varchar(2)  | NO   |     | no      |       |
| comitatopr    | varchar(2)  | YES  |     | no      |       |
| commission    | varchar(2)  | NO   |     | no      |       |
| ferito        | varchar(2)  | NO   |     | no      |       |
| mutilato      | varchar(2)  | NO   |     | no      |       |
| note          | text        | NO   |     | NULL    |       |
| pubblica      | varchar(2)  | NO   |     | no      |       |
| nome_batt     | varchar(35) | NO   |     | NULL    |       |
| tipologia     | int(11)     | NO   |     | NULL    |       |
+---------------+-------------+------+-----+---------+-------+

mysql> describe mediabank;
+-------------+--------------+------+-----+---------+-------+
| Field       | Type         | Null | Key | Default | Extra |
+-------------+--------------+------+-----+---------+-------+
| codice      | bigint(20)   | NO   | PRI | NULL    |       |
| n_ord       | bigint(20)   | NO   | PRI | NULL    |       |
| file        | varchar(200) | NO   |     | NULL    |       |
| descrizione | varchar(50)  | NO   |     | NULL    |       |
+-------------+--------------+------+-----+---------+-------+
