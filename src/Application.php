<?php

/**
 * Created by PhpStorm.
 * User: reunan
 * Date: 01/04/2017
 * Time: 00:46
 */
class Application
{
    private $name;
    private $clusterName;
    private $created;
    public function __construct($name, $clusterName)
    {
        $this->name = $name;
        $this->clusterName = $clusterName;

        if(!$this->itExist()){
            $this->create();
        }
        $this->created = true;
    }

    public function create(){
        $ret = Helpers::exec("flynn -c " . $this->clusterName . " create -y " . $this->name );
        if (Helpers::contains($ret, "already exist")) {
            throw new Exception("The app '" . $this->name . "' already exist.");
        }
        $this->created = true;
    }

    public function delete(){
        $this->command("delete -y");
        return true;
    }

    public function getEnvs(){
        $ret = $this->command("env");
        $lignes = explode("\n",$ret);
        $envs = [];
        foreach ($lignes as $ligne){
            $env = explode("=",$ligne);
            if(sizeof($env) == 2) {
                $envs[explode("=", $ligne)[0]] = explode("=", $ligne)[1];
            }
        }

        return $envs;
    }

    public function getEnv($env){
        return rtrim($this->command("env get " . $env));
    }

    public function setEnv($env, $value){
        $this->command("env set " . $env . "=" . $value);
    }

    public function unSetEnv($env){
        $this->command("env unset " . $env);
    }

    public function setEnvs($envs){
        $envString = "";
        foreach ($envs as $key => $env){
            $envString .= " " . $key . "=" . $env;
        }
        $this->command("env set " . $envString);
    }

    public function isCreated(){
        return $this->created;
    }

    public function addMysqlProvider(){
        $ret = $this->command("resource add mysql");
        return true;
    }



    private function itExist(){
        $ret = Helpers::exec("flynn -c " . $this->clusterName . " apps");
        return Helpers::contains($ret, $this->name);
    }

    private function command($command){
        return Helpers::exec("flynn -c " . $this->clusterName . " -a ". $this->name . " " . $command);
    }

}