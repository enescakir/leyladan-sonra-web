<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
  protected $table = 'sms';

  protected $guarded = [];

  public function send($people)
  {
    $to = "";
    if(is_array($people)){
      foreach ($people as $person) {
        $to = $to . "<number>" . $person . "</number>";
      }
    } else {
      $to = "<number>" . $people . "</number>";
    }
    $username   = env('ILETI_USERNAME');
    $password   = env('ILETI_PASSWORD');

    $xml = "<request>
    <authentication>
    <username>".$username."</username>
    <password>".$password."</password>
    </authentication>
    <order>
    <sender>". $this->attributes['title'] ."</sender>
    <sendDateTime>01/05/2013 18:00</sendDateTime>
    <message>
    <text><![CDATA[" . $this->attributes['message'] . "]]></text>
    <receipents>
    ". $to . "
    </receipents>
    </message>
    </order>
    </request>";

    $site_name = env('ILETI_URL') . "/send-sms";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $site_name);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,['Content-Type: text/xml']);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);

    $result = curl_exec($ch);
    return $result;
  }


}
