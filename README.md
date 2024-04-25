# Beca Thermostat
Diese Modul hilft dabei, Thermostate von Beca, geflasht mit einer [Firmware](https://github.com/klausahrenberg/WThermostatBeca) in Symcon einzubinden.


### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [PHP-Befehlsreferenz](#6-php-befehlsreferenz)

### 1. Funktionsumfang

* Diese Modul hilft dabei, Thermostate von Beca, geflasht mit einer [Firmware](https://github.com/klausahrenberg/WThermostatBeca) in Symcon einzubinden.

### 2. Voraussetzungen

- IP-Symcon ab Version 7.1
- Beca Wandthermostat geflasht mit der [Firmware](https://github.com/klausahrenberg/WThermostatBeca) 

### 3. Software-Installation

* Über den Module Store das 'Beca Thermostat'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'Beca Thermostat'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Name     | Beschreibung
-------- | ------------------
  topic  | hier wird der Topic eingetragen, dieses befindet in der Firmware unter -> "Configure network" -> "Advanced MQTT options" -> MQTT Topic
         |

### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

#### Statusvariablen

Name   | Typ     | Beschreibung
------ | ------- | ------------
Aktuelle Temperatur  | FLOAT       | Aktuelle Temperautur des Raumes gemessen am Wandthermostat
Online               | BOOL        | Onlinestatus des Wandthermostat
Betriebsart          | BOOL        | Betriebsart Ein/Aus
Boden Temperatur     | FLOAT       | Aktuelle Temperatur des Boden gemessen mit externem Bodenthermostat
Firmware Version     | STRING      | Firmware Version des Wandthermostat
Heizmodus            | BOOL        | Heizmodus An/Aus
IP Adresse           | STRING      | IP Adresse des Wandthermostat
Kalendermodus        | INTEGER     | Kalender aus/auto
Ziel Temperatur      | FLOAT       | gewünschte Zieltemperatur kann eingestellt werden. Wenn Kalendermodus auf auto steht, kann man keine Zieltemperatur eingeben!


#### Profile

Name   | Typ
------ | -------
Beca.Schedulemode       | INTEGER
Beca.Temperature | FLOAT
Beca.Alive | BOOL

### 6. PHP-Befehlsreferenz
