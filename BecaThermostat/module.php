<?php

declare(strict_types=1);
	class BecaThermostat extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->RegisterPropertyString('Topic', '');

			$this->ConnectParent('{C6D2AEB3-6E1F-4B2E-8E69-3A1A00246850}');
			
			if (!IPS_VariableProfileExists('Beca.Schedulemode')) {
				IPS_CreateVariableProfile('Beca.Schedulemode', 1);
				IPS_SetVariableProfileAssociation('Beca.Schedulemode', 0, $this->Translate('off'), '', 0xFFFFFF);
				IPS_SetVariableProfileAssociation('Beca.Schedulemode', 1, $this->Translate('auto'), '', 0xFFFFFF);
			}

			if (!IPS_VariableProfileExists('Beca.Temperature')) {
				IPS_CreateVariableProfile('Beca.Temperature', 2);
				IPS_SetVariableProfileIcon('Beca.Temperature', 'Temperature');
				IPS_SetVariableProfileDigits('Beca.Temperature', 1);
				IPS_SetVariableProfileText('Beca.Temperature', "", " °C");
				IPS_SetVariableProfileValues("Beca.Temperature", 15, 30, 0.5);
			}
			if (!IPS_VariableProfileExists('Beca.Alive')) {
				IPS_CreateVariableProfile('Beca.Alive', 0);
				IPS_SetVariableProfileAssociation('Beca.Alive', 0, $this->Translate('no'), '', 0xFF0000);
				IPS_SetVariableProfileAssociation('Beca.Alive', 1, $this->Translate('yes'), '', 0x00FF00);
			}
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();

			$Topic = $this->ReadPropertyString('Topic');

			//Setze Filter für ReceiveData
			$this->SetReceiveDataFilter('.*' . $Topic . '.*');
		}
		
		protected function sendMQTT($Topic, $Payload)
		{
			$mqtt['DataID'] = '{043EA491-0325-4ADD-8FC2-A30C8EEB4D3F}';
			$mqtt['PacketType'] = 3;
			$mqtt['QualityOfService'] = 0;
			$mqtt['Retain'] = false;
			$mqtt['Topic'] = $Topic;
			$mqtt['Payload'] = $Payload;
			$mqttJSON = json_encode($mqtt, JSON_UNESCAPED_SLASHES);
			$mqttJSON = json_encode($mqtt);
			$result = $this->SendDataToParent($mqttJSON);
		}		

		public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString,true);
			$Topic = $this->ReadPropertyString('Topic');

			if($data['DataID'] == '{7F7632D9-FA40-4F38-8DEA-C83CD4325A32}')
			{
				$this->SendDebug(__FUNCTION__,$data['Topic'], 0);
				$this->SendDebug(__FUNCTION__,$JSONString, 0);

				// include Datapoints to match and create only variables we received from the car
				if($Topic.'/thermostat/properties' == $data['Topic'])
				{
					$this->CheckDB($data);
				}	
			}		
		}

		public function RequestAction($Ident, $Value = NULL)
		{
			$Topic = $this->ReadPropertyString('Topic');

			switch($Ident)
			{
				case 'deviceOn':
					$Topic = $Topic.'/thermostat/set/'.$Ident;
					$Payload = json_encode($Value);
					$this->SendDebug(__FUNCTION__,"Topic: ".$Topic." Payload: ".$Payload, 0);
					$this->sendMQTT($Topic, $Payload);
				break;
				case 'targetTemperature':
					$Topic = $Topic.'/thermostat/set/'.$Ident;
					$Payload = json_encode($Value);
					$this->SendDebug(__FUNCTION__,"Topic: ".$Topic." Payload: ".$Payload, 0);
					$this->sendMQTT($Topic, $Payload);
				break;
				case 'schedulesMode':
					$Topic = $Topic.'/thermostat/set/'.$Ident;
					if ($Value == 0)
					{
						$Value = "off";
						$this->EnableAction('targetTemperature');
					}
					else
					{
						$Value = "auto";
						$this->DisableAction('targetTemperature');
					}
					$Payload = json_encode($Value);
					$this->SendDebug(__FUNCTION__,"Topic: ".$Topic." Payload: ".$Payload, 0);
					$this->sendMQTT($Topic, $Payload);
				break;
			}

		}

		private function CheckDB($data)
		{
			require_once __DIR__ . '/../libs/datapoints.php';

			$encodePayload = $data['Payload'];
			$Payload = json_decode($encodePayload, true);
			$Topic = $this->ReadPropertyString('Topic');

			foreach($DP as $Datapoint)
			{
				//  Topicpath(0), Description(1), Type(2), SymconProfile(3), Action(4), hide(5)
				$DP_Path 	= $Datapoint['0'];
				$DP_Desc 	= $Datapoint['1'];
				$DP_DataType= $Datapoint['2'];
				$DP_Profile = $Datapoint['3'];
				$DP_Action 	= $Datapoint['4'];
				$DP_Hide 	= $Datapoint['5'];
				
				if (array_key_exists($DP_Path, $Payload) == false) {
					$this->SendDebug("Not in Payload:","Topic: ".$DP_Path." is not in Payload.", 0);
					return;
				}				

				$DP_Value = $Payload[''.$DP_Path.''];

				// make symcon happy to create idents without special characters
				$DP_Identname = str_replace("-","_",$DP_Path);

				if (!$DP_Hide)
				{
					$this->SendDebug("Value:","Set ".$DP_Path." to Value ".$DP_Value, 0);
				}

				// for some values we need to change the type
				switch($DP_Path)
				{
					case "schedulesMode":
						switch($DP_Value)
						{
							case 'off':
								$DP_Value = 0;
								$this->EnableAction('targetTemperature');
							break;
							case 'auto':
								$DP_Value = 1;
								$this->DisableAction('targetTemperature');
							break;
						}
					break;
					case 'state':
						switch($DP_Value)
						{
							case 'off':
								$DP_Value = false;
								break;
							case 'heating':
								$DP_Value = true;
								break;
						}
					break;
				}

				// in case the datatype is hidden, dont do anything
				if (!$DP_Hide)
				{

					if (!@$this->GetIDForIdent(''.$DP_Identname.''))
					{

						$this->MaintainVariable($DP_Identname, $this->Translate("$DP_Desc"), $DP_DataType, "$DP_Profile", 0, true); 
						$this->SendDebug("MaintainVariable:","Create Variable with IDENT ".$DP_Identname, 0);

						if ($DP_Action)
						{
							$this->EnableAction($DP_Identname);
							$this->SendDebug("EnableAction:","Create Action for IDENT ".$DP_Identname, 0);
						}
					}
										
					// now we can set the value.... yeah!
					$this->SendDebug("Set Value:","Update ".$DP_Identname." to ".$DP_Value, 0);
					$this->SetValue($DP_Identname, $DP_Value);
				}
			}
		}
	}