<?php 
	class ExtractCoordinates{
		public $path;
		public $format;
		private $xml;
		private $format_function = array(
			"kml" => "KML_to_JSON",
			"gpx" => "GPX_to_JSON"
		);

		 function __construct($path){
			$this->path = $path;
		}

		public function extract (){

			if(!$this->get_format())
				return false;

			if (!array_key_exists($this->format, $this->format_function) )
				return false;

			$func = $this->format_function[$this->format];

			$coordinates = array(
				"format" => $this->format,
				"coord" => json_decode(ExtractCoordinates::$func($this->xml)));
			return json_encode($coordinates);

		}

		 static function KML_to_JSON($kml = null){

			if ($kml == false)
				return false;

			$coordinates = explode("\n",$kml->Document->Placemark->LineString->coordinates);

			foreach ($coordinates as $key => $value) {
				$coordinates[$key] = explode(",", $value);
			}

			array_pop($coordinates);
			array_shift($coordinates);

			return (json_encode($coordinates));
		}

		static function GPX_to_JSON($gpx = null){

			if ($gpx == false)
				return false;

			$segments = $gpx->trk->trkseg;
			$coordinates = array();

			foreach ($segments as $value) {
				$segTraks = $value->trkpt;
				$i = 0;
				foreach ($segTraks as $value) {
					$attributes = $value->attributes();

					array_push($coordinates, array($attributes['lat'],$attributes['lon']));
				}
			}

			return json_encode($coordinates);

		}

		function get_format(){
			$this->xml = simplexml_load_file($this->path);

			if(!$this->xml)
				return false;

			$this->format = $this->xml->getName();

			return true;

		}
	}

	
	$ec = new ExtractCoordinates("/home/ismael/Descargas/example.gpx");
	$res = $ec->extract();
	// var_dump($res);
	header('Content-Type: application/json');
	echo $res;

 ?>