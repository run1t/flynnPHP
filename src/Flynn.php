<?php

class Flynn{

    public function test(){
        $cluster = new Cluster();
        $reunan = $cluster->application("reunan");
        $envs = $reunan->addMysqlProvider();
        $reunan->setEnv("PHINX_MYSQL", $envs['MYSQL_DATABASE']);
        $reunan->setEnv("PHINX_MYSQL", $envs['MYSQL_DATABASE']);
        $reunan->setEnv("PHINX_MYSQL", $envs['MYSQL_DATABASE']);
        $envs = $reunan->addMysqlProvider();
        $reunan->setEnv("PHINX_MYSQL", $envs['MYSQL_DATABASE']);
        $reunan->setEnv("PHINX_MYSQL", $envs['MYSQL_DATABASE']);
        $reunan->setEnv("PHINX_MYSQL", $envs['MYSQL_DATABASE']);
        $reunan->deploy("origin","master");
    }

}
