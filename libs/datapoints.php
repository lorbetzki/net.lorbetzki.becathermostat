<?php

$DP = [
//  Topicpath,           Description,                               Type,                    SymconProfile,          Action, hide
    ['idx',              $this->Translate('Identifier'),            VARIABLETYPE_STRING,    '',                   false, true],
    ['ip',               $this->Translate('IP Address'),            VARIABLETYPE_STRING,    '',                   false, false],
    ['alive',            $this->Translate('Online'),                VARIABLETYPE_BOOLEAN,   'Beca.Alive',         false, false],
    ['firmware',         $this->Translate('firmware version'),      VARIABLETYPE_STRING,    '',                   false, false],
    ['temperature',      $this->Translate('actually temperature'),  VARIABLETYPE_FLOAT,     '~Temperature',       false, false],
    ['targetTemperature',$this->Translate('target temperature'),    VARIABLETYPE_FLOAT,     'Beca.Temperature',   true, false],
    ['floorTemperature', $this->Translate('floor temperature'),     VARIABLETYPE_FLOAT,     '~Temperature',       false, false],
    ['deviceOn',         $this->Translate('power'),                 VARIABLETYPE_BOOLEAN,   '~Switch',            true, false],
    ['schedulesMode',    $this->Translate('schedule mode'),         VARIABLETYPE_INTEGER,   'Beca.Schedulemode',  true, false],
    ['ecoMode',          $this->Translate('eco mode'),              VARIABLETYPE_BOOLEAN,   '',                   false, true],
    ['locked',           $this->Translate('locked'),                VARIABLETYPE_BOOLEAN,   '',                   false, true],
    ['state',            $this->Translate('state'),                 VARIABLETYPE_BOOLEAN,   '~Switch',            false, false],
    ['fanMode',          $this->Translate('fan mode'),              VARIABLETYPE_INTEGER,   '',                   false, true],
    ['systemMode',       $this->Translate('system mode'),           VARIABLETYPE_INTEGER,   '',                   false, true],
    ['url',              $this->Translate('url'),                   VARIABLETYPE_STRING,    '',                   false, true],
    ['stateTopic',       $this->Translate('stateTopic'),            VARIABLETYPE_STRING,    '',                   false, true],
    ['setTopic',         $this->Translate('setTopic'),              VARIABLETYPE_STRING,    '',                   false, true],
];