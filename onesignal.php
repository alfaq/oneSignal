<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
  <script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
      appId: "d602f5d0-8f0f-48ac-a1dc-8352383d8320",
      autoRegister: true, /* Set to true to automatically prompt visitors */
      subdomainName: 'firjicom',
	  safari_web_id: 'web.onesignal.auto.0b751c21-4ab5-448f-a888-cd2e20e2cfd5',
      notifyButton: {
          enable: true /* Set to false to hide button */
      }
    }]);
  </script>

<?php
class OneSignal{
	private $app_id;
	private $rest_api_key;
	public function __construct($app_id, $rest_api_key){
		$this->app_id = $app_id;
		$this->rest_api_key = $rest_api_key;
	}

	public function sendMessage($title, $content, $url, $img, $lang = 'en'){
		
		$content = array(
			$lang => $content,
		);
			
		$heading = array(
			$lang => $title,
		);
		
		$fields = array(
			'app_id' => $this->app_id,
			'included_segments' => array('Active Users'),
			//'filters' => array(array("field" => "session_time", "relation" => "=", "value" => "1")),
			//'data' => array("foo" => "bar"),
			'url' => $url,
			'contents' => $content,
			'headings' => $heading,
			'chrome_web_icon' => $img,
		);
		
		$headers = array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic '.$this->rest_api_key,
		);
		
		$fields = json_encode($fields);

		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}	
}

$app_id = "d602f5d0-8f0f-48ac-a1dc-8352383d8320";
$rest_api_key = 'ZWEzZTE2ZDAtYWE2MS00YTg2LTliMDEtNWM5NTI5YWFhZjM5';
$on = new OneSignal($app_id, $rest_api_key);

$title = "Test title";
$content = "Test content";
$url = 'http://google.com';
$img = "http://firji.com/sites/all/themes/firji/img/firji-logo.png";
$res = $on->sendMessage($title, $content, $url, $img, $lang = 'en');
$a_res = json_decode($res);
print '<pre>';
print_r($a_res);