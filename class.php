<?php

# 	this is demo of my code in PHP. You can use, copy or modify
#
#	@author Rym2 (pl)



//IPv4 class
class IpV4 {
	private $ip;
	private $binnaryIpV4;
	protected $array;
	
	public function __construct($ip, $array = array(128, 64, 32, 16, 8, 4, 2, 1), $binnaryIpV4 = null) {
		$this->ipv4 = $ip;
		$this->array = $array;
		$this->binIpV4 = $binnaryIpV4;
	}
	
	//divade ip to Octets
	private function getOctets() {
		$octets = explode(".", $this->ipv4);
		return $octets;
	}
	
	//validate octets - shoudl be 4 and values are between 0 to 255. If values are correct null is return.
	public function checkIp() {
		$nr_of = 0;
		foreach($this->getOctets() as $octet) {
			$nr_of++;
			$x = $octet;
			if($x < 0 || $x > 255) {
				return("Niepoprawna wartosc IP w ".$nr_of." bajcie - ".$octet);
			}
		}
		if ($nr_of != 4) {
			return("Niepoprawna wartosc IP!");
		}
		
	}
	
	//change dec ip addres to binnary
	public function getBinnaryIpV4() {
	
		foreach($this->getOctets() as $octet) {
		
			$x = $octet;
		
			for($key=0; $key<=7; $key++) {
				if($x>=$this->array[$key]) {
					$x = $x-$this->array[$key];
					$this->binIpV4 .= 1;
				} else {
					$this->binIpV4 .= 0;
				}
			}
		}

		return $this->binIpV4;
	}
	
	
}

//Mask
class Mask extends IpV4 {
	public $mask;
	public $binMask;
	public $binWildMask;
	
	
	public function __construct($mask, $binMask = null, $binWildMask = null) {
		parent::__construct($array = array(128, 64, 32, 16, 8, 4, 2, 1));
		$this->mask = $mask;
		$this->binMask = $binMask;
		$this->binWildMask = $binWildMask;
	}
	
	
	//validate mask - should be number between 0 to 32
	public function checkMask() {
		if($this->mask < 0 || $this->mask > 32) {
			return("maska musi miescic się w przedziale od 0 do 32. Wprowadzona wartosc: ".$this->mask);
		}
	}
	
	//get binnary mask 
	public function getBinMask() {
		
		for($nrOfBit=1; $nrOfBit<=32; $nrOfBit++) {
			if($this->mask>=$nrOfBit) {
				$this->binMask .= 1;
			} else {
				$this->binMask .= 0;
			}
		}
		return $this->binMask;
	}
	
	//get binnary wildmask 
	public function getBinWildMask() {
		for($nrOfBit=1; $nrOfBit<=32; $nrOfBit++) {
			if($this->mask>=$nrOfBit) {
				$this->binWildMask .= 0;
			} else {
				$this->binWildMask .= 1;
			}
		}
		return $this->binWildMask;
	}
	
}

//broadcast
class Broadcast {  //największy adres IP
	public function __construct($ip, $mask) {
		$this->ip = $ip;
		$this->mask = $mask;
	}
	
	// get binnary broadcast
	public function getBinBroadcast() {
		$broadcast = null;
		$mask = $this->mask;
		$mask = str_split($mask);
		$ip = $this->ip;
		$ip = str_split($ip);
		for($key=0; $key<=31; $key++){
			if($mask[$key] == 1) {
				$broadcast .= $ip[$key];
			} else {
				$broadcast .= 1;
			}
		}
		return $broadcast;
	}
}


//network address
class NetworkIp { //adres sieci
	public function __construct($ip, $mask) {
		
		$this->ip = $ip;
		$this->mask = $mask;
	}
	
	//get binnary network address
	public function getBinNetwork() {
		$network = null;
		$mask = $this->mask;
		$mask = str_split($mask);
		$ip = $this->ip;
		$ip = str_split($ip);
		for($key=0; $key<=31; $key++){
			if($mask[$key] == 1) {
				$network .= $ip[$key];
			} else {
				$network .= 0;
			}
		}
		return $network;
	}
}


//change binnary values to dec
class DecIpAddres extends IpV4 {
	public function __construct($ipBin) {
		parent::__construct($array = array(128, 64, 32, 16, 8, 4, 2, 1));
		$this->array = $array;
		$this->ip = $ipBin;
	}
	
	//get dec ip using
	public function getDecNetwork() {
		$octDec1 = 0;
		$octDec2 = 0;
		$octDec3 = 0;
		$octDec4 = 0;
		for($key=0; $key<=7; $key++) {
			if(Octets::getBinFirOctet($this->ip)[$key] == 1) {
				$octDec1 += $this->array[$key];
			}
				
			if(Octets::getBinSecOctet($this->ip)[$key] == 1) {
				$octDec2 += $this->array[$key];
			}
				
			if(Octets::getBinThrOctet($this->ip)[$key] == 1) {
				$octDec3 += $this->array[$key];
			}
				
			if(Octets::getBinFouOctet($this->ip)[$key] == 1) {
				$octDec4 += $this->array[$key];
			}
				
		}
		
		return $octDec1.".".$octDec2.".".$octDec3.".".$octDec4;
		}	
}


//octets binnary to dec 
class Octets {
	public static function getBinFirOctet($ip) {
		$octet1 = substr($ip, 0, 8);
		$octet1 = str_split($octet1);
		return $octet1;
	}
	public static function getBinSecOctet($ip) {
		$octet2 = substr($ip, 8, 8);
		$octet2 = str_split($octet2);
		return $octet2;
	}
	public static function getBinThrOctet($ip) {
		$octet3 = substr($ip, 16, 8);
		$octet3 = str_split($octet3);
		return $octet3;
	}
	public static function getBinFouOctet($ip) {
		$octet4 = substr($ip, 24, 8);
		$octet4 = str_split($octet4);
		return $octet4;
	}
}

//function to see result. I'm using table.
function main($getIp, $getMask) {
	
	$ipv4 = new IpV4($getIp);
	$mask = new Mask($getMask);
	
	if($mask -> checkMask()) {													//SPRAWDZA POPRAWNOŚĆ WPISU DOTYCZĄCEGO MASKI
		exit("<table class='error'><tr><td>Wystąpił błąd! ".$mask -> checkMask()."</td></tr></table>");
	}
	if($ipv4 -> checkIp()) {													//SPRAWDZA POPRAWNOŚĆ WPISANEGO ADRESU IPv4
		exit("<table class='error'><tr><td>Wystąpił błąd! ".$ipv4 -> checkIp()."</td></tr></table>");
	}
	
	
	print("<table><thead>
		<tr><td class = 'center' colspan='3'>WYNIKI OBLICZEŃ</td></tr>
		<tr><td></td><td  class = 'center'>Wersja binarna</td><td  class = 'center'>Wersja dziesiętna</td></tr></thead>");
	
	//User address
	print("<tbody><tr><td class = 'right'>Wpisany adres: </td><td class = 'center' >");
	print($ipv4 -> getBinnaryIpV4()."</td><td >"); 								//WYŚWIETLA IPv4 w wersji binarnej
	$ip_v4 = new DecIpAddres($ipv4 -> getBinnaryIpV4());						//PRZETWARZANIE ADRESU BINARNEGO NA DZIESIĘTNY
	print($ip_v4 -> getDecNetwork()."</td></tr>");								//WYŚWIETLA IPv4 w wersji dziesiętnej
	
	//User mask
	print("<tr><td class = 'right'>Maska: </td><td  class = 'center'>");
	print($mask -> getBinMask()."</td><td  >"); 								//WYŚWIELA MASKĘ W wersji binarnej
	$dec_mas = new DecIpAddres($mask -> getBinMask()); 							//PRZETWARZANIE ADRESU BINARNEGO MASKI NA DZIESIETNY
	print($dec_mas -> getDecNetwork()."</td></tr>");							//WYSWIETLANIE MASKI w wersji dziesiętnej

	//Wild Mask
	print("<tr><td class = 'right'>Dzika maska: </td><td  class = 'center'>");
	print($mask -> getBinWildMask()."</td><td  >"); 							//WYŚWIELA DZIKĄ MASKĘ W wersji binarnej
	$dec_wild_mas = new DecIpAddres($mask -> getBinWildMask()); 				//PRZETWARZANIE ADRESU BINARNEGO DZIKIEJ MASKI NA DZIESIETNY
	print($dec_wild_mas -> getDecNetwork()."</td></tr>");						//WYSWIETLANIE DZIKIEJ MASKI w wersji dziesiętnej
	
	//Broadcast
	print("<tr><td class = 'right'>Broadcast: </td><td  class = 'center'>");
	$broadcast = new Broadcast($ipv4->getBinnaryIpV4(), $mask -> getBinMask()); 	// LICZY BROADCAST
	print($broadcast->getBinBroadcast()."</td><td >"); 								//WYŚWIETlA BROADCAST W WERSJI BINARNEJ
	$bro = new DecIpAddres($broadcast->getBinBroadcast()); 							//PRZETWARZANIE ADRESU BINARNEGO BROADCASTU NA DZIESIETNY
	print ($bro -> getDecNetwork()."</td></tr>"); 									//WYSWIETLANIE BROADCASTU w wersji dziesiętnej
	
	//Network address
	print("<tr><td class = 'right'>Adres sieci: </td><td  class = 'center'>");
	$network = new NetworkIp($ipv4->getBinnaryIpV4(), $mask -> getBinMask());		//TWORZY ADRES SIECI
	print($network->getBinNetwork()."</td><td >"); 									// WYSWIETLA ADRES SIECI W WERSJI BINARNEJ
	$ip_ad = new DecIpAddres($network->getBinNetwork()); 							//PRZETWARZANIE ADRESU BINARNEGO SIECI NA DZIESIETNY
	print ($ip_ad -> getDecNetwork()."</td></tr>"); 								//WYSWIETLANIE ADRESU SIECI w wersji dziesiętnej
	
	print("</tbody></table>");
		
}


?>