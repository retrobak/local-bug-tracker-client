<?php


namespace RetroBak\LocalBugTracker;


class ClientReporter
{
    const LEVEL_CRITICAL  = 'critical';
    const LEVEL_ERROR     = 'error';
    const LEVEL_INFO      = 'info';
    const LEVEL_DEBUG     = 'debug';
    
    /**
     * @var string url
     */
    public $url;
    
    /**
     * @var array key => value
     */
    private $data;
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * Submits it to the given server
     * @return bool|string
     */
    public function submit()
    {
        if (! $this->getUrl() || count($this->getData()) == 0) {
            return false;
        }
        
        $data_string = json_encode($this->getData());
    
        $ch = curl_init($this->getUrl());
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
    
        $result = curl_exec($ch);
        return true;
    }
}
