<?php 
 
class Push {
    //notification title
    private $title;
 
    //notification message 
    private $message;
 
    //notification image url 
    private $image;
 
    //notification image url 
    private $complainId;
 
    //notification image url 
    private $rewards;
 
    //notification image url 
    private $discounts;
 
    //initializing values in this constructor
    function __construct($title, $message, $image, $complainId, $rewards, $discounts) {
         $this->title = $title;
         $this->message = $message; 
         $this->image = $image; 
         $this->complainId = $complainId;
         $this->rewards = $rewards;
         $this->discounts = $discounts; 
    }
    
    //getting the push notification
    public function getPush() {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['message'] = $this->message;
        $res['data']['image'] = $this->image;
        $res['data']['complainId'] = $this->complainId;
        $res['data']['rewards'] = $this->rewards;
        $res['data']['discounts'] = $this->discounts;
        return $res;
    }
}

?>