<?php 
	class KML{
		static public $xml = "/home/ismael/Descargas/example.gpx";

		static function KML_to_JSON($kml){
			$kml = self::$xml;

			$xml = simplexml_load_file($kml);

			$coordinates = explode("\n",$xml->Document->Placemark->LineString->coordinates);

			foreach ($coordinates as $key => $value) {
				$coordinates[$key] = explode(",", $value);
			}

			array_pop($coordinates);
			array_shift($coordinates);

			return (json_encode($coordinates));
		}

		static function GPX_to_JSON($gpx){
			$gpx = self::$xml;

			$xml = simplexml_load_file($gpx);

			$segments = $xml->gpx->trk->trkseg;
			$coordinates = array();

			// foreach ($segments as $value) {
			// 	$segTraks = $value->trkpt;

			// 	foreach ($segTraks as $value) {
			// 		$attributes = $value->attributes();
			// 		$coordinates[] = [$attributes['lat'],$attributes['lon']];
			// 	}
			// }

			var_dump($segments);
			// return json_encode($coordinates);

		}
	}

	$res = KML::GPX_to_JSON();
	// var_dump(KML::KML_to_JSON());

	// header('Content-Type: application/json');
	// echo $res;

 ?>