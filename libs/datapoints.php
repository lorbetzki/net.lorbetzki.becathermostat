<?php

$DP = [
//  Topicpath,           Description,                               Type,   SymconProfile,          Action, hide
    ['idx',              $this->Translate('Identifier'),            'STRING', '',                   false, true],
    ['ip',               $this->Translate('IP Address'),            'STRING', '',                   false, false],
    ['alive',            $this->Translate('Alive'),                 'BOOL', '~Switch',              false, false],
    ['firmware',         $this->Translate('firmware version'),      'STRING', '',                   false, false],
    ['temperature',      $this->Translate('actually temperature'),  'FLOAT', '~Temperature',        false, false],
    ['targetTemperature',$this->Translate('target temperature'),    'FLOAT', 'Beca.Temperature',    true, false],
    ['floorTemperature', $this->Translate('floor temperature'),     'FLOAT', '~Temperature',        false, false],
    ['deviceOn',         $this->Translate('power'),                 'BOOL', '~Switch',              true, false],
    ['schedulesMode',    $this->Translate('schedule mode'),         'INT', 'Beca.Schedulemode',     true, false],
    ['ecoMode',          $this->Translate('eco mode'),              'BOOL', '',                     false, true],
    ['locked',           $this->Translate('locked'),                'BOOL', '',                     false, true],
    ['state',            $this->Translate('state'),                 'BOOL', '~Switch',              false, false],
    ['fanMode',          $this->Translate('fan mode'),              'INT', '',                      false, true],
    ['systemMode',       $this->Translate('system mode'),           'INT', '',                      false, true],
    ['url',              $this->Translate('url'),                   'STRING', '',                   false, true],
    ['stateTopic',       $this->Translate('stateTopic'),            'STRING', '',                   false, true],
    ['setTopic',         $this->Translate('setTopic'),              'STRING', '',                   false, true],
];