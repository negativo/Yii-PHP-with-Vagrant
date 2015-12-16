<?php

class Util {

	/**
	 * Required for making a http request
	 * @param string $url The URL to send the request to
	 */
	public static function curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		return curl_exec($ch);
		curl_close ($ch);
	}

	public static function dumpdb(){

		Yii::import('ext.dumpDB.dumpDB');
  		$dumper = new dumpDB();
  		$current = $dumper->getTextDump();
  		$file = dirname(__FILE__).'/../data/backupdb.mysql';

		file_put_contents($file, $current);
  		return;

  	}

	public static function importdb(){

  		$file = dirname(__FILE__).'/../data/backupdb.mysql';
  		$pdo = Yii::app()->db->pdoInstance;
        try
        {
            if (file_exists($file))
            {
                $sqlStream = file_get_contents($file);
                $sqlStream = rtrim($sqlStream);
                $newStream = preg_replace_callback("/\((.*)\)/", create_function('$matches', 'return str_replace(";"," $$$ ",$matches[0]);'), $sqlStream);
                $sqlArray = explode(";", $newStream);
                foreach ($sqlArray as $value)
                {
                    if (!empty($value))
                    {
                        $sql = str_replace(" $$$ ", ";", $value) . ";";
                        $pdo->exec($sql);
                    }
                }
                //echo "succeed to import the sql data!";
                return true;
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            exit;
        }
        return;
  	}
	public static function curlLowPriority($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,2);
		return curl_exec($ch);
		curl_close ($ch);
	}

	public static function mailcurl($url, $args){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Tell curl not to return headers, but do return the response
		curl_setopt($ch, CURLOPT_HEADER, false);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		 // Set the POST arguments to pass on
		curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		return curl_exec($ch);
		curl_close ($ch);
	}

	public static function imageToPNG($srcFile, $type){
		switch ($type)
		{
			case IMAGETYPE_GIF:
				return imagecreatefromgif($srcFile);
				break;
			case IMAGETYPE_JPEG:
				return imagecreatefromjpeg($srcFile);
				break;
			case IMAGETYPE_PNG:
				return imagecreatefrompng($srcFile);
				break;
			default:
				throw new Exception('Unrecognized image type ' . $type);
		}
	}

	public static function sendTransactionalEmail($toAddress, $subject, $htmlMessage, $encryptedId = null){

		// for now the encryptedId is just the hash that was made for activation
		$header = '
			<div id="container" style="width: 750px; margin: 0 auto; border: 2px solid gray; padding: 25px;">
				<div id="header">
					aH!
				</div>
				<div id="message" style="min-height: 200px; padding: 20px;">
			';
		$footer = ($encryptedId) ? '
			</div>
			<div id="footer" style="font-size: 10px;">
				 <a href="http://www.site.com/profile/emailPreferences/?cd=' . $encryptedId . '">click here</a>.

			</div>
			</div>
			' : '
			</div>
			</div>
			';

		$args = array(
				'key' => '{mandrillapp-key}',
				'message' => array(
						"html" => $header . $htmlMessage . $footer,
						"text" => null,
						"from_email" => "info@site.com",
						"from_name" => "vagrant yii1 site",
						"subject" => $subject,
						"to" => array(array("email" => $toAddress)),
						"track_opens" => true,
						"track_clicks" => true,
						"auto_text" => true
				)
		);

		Util::mailcurl('https://mandrillapp.com/api/1.0/messages/send.json', json_encode($args));

	}


}
