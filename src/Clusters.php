<?php

class Cluster {
    private $certificatePin;
    private $clusterName;
    private $controllerDomain;
    private $controllerName;
    private $connected;

    public function __construct($config){
        $this->certificatePin = $config['certificatePin'];
        $this->clusterName = $config['clusterName'];
        $this->controllerDomain = $config['controllerDomain'];
        $this->controllerName = $config['controllerName'];
        if(!$this->itExist()){
            $this->connect();
        }
        $this->connected = true;
    }

    public function disconnect(){
        Helpers::exec("flynn cluster remove " . $this->clusterName);
        $this->connected = false;
    }

    public function isConnected(){
        return $this->connected;
    }

    public function getName(){
        return $this->clusterName;
    }

    public function application($name){
        return new Application($name, $this->clusterName);
    }

    private function itExist(){
        $ret = Helpers::exec("flynn cluster ");
        return Helpers::contains($ret,$this->clusterName . " ");
    }


    private function connect(){
        $ret = Helpers::exec($this->createClusterCommand());
        if (Helpers::contains($ret, "already exist")) {
            throw new Exception("The cluster '" . $this->clusterName . "' already exist.");
        }
        $this->connected = true;
    }

    private function createClusterCommand(){
        return "flynn cluster add -p "
            . $this->certificatePin
            . " "
            . $this->clusterName
            . " "
            . $this->controllerDomain
            . " "
            . $this->controllerName;
    }
}