<?php
use PHPUnit\Framework\TestCase;


final class FlynnTest extends TestCase {

    protected $config;
    protected function setUp()
    {
        require('config.php');
        $this->config = $config;
        $this->flynn = new Flynn();
    }


    /*
     * Can connect to a cluster
     */
    public function testCanConnectToACluster()
    {
        $cluster = new Cluster($this->config);
        $this->assertTrue($cluster->isConnected());
    }


    /*
     * Can connect to an existant cluster
     */
    public function testCantConnectToAnExistantCluster()
    {
        $cluster = new Cluster($this->config);
        $this->assertTrue($cluster->isConnected());
    }

    /*
     * Can create an application
     */
    public function testCanCreateAnApplication()
    {
        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $this->assertTrue($application->isCreated());
    }

    /*
     * Can create an existing application
     */
    public function testCreateAddAnExistingApplication()
    {
        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $this->assertTrue($application->isCreated());
    }

    /*
     * Can create an a mysql provider
     */
    public function testCanCreateAMysqlProvider()
    {
        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $this->assertTrue($application->addMysqlProvider());

    }

    /*
     * Can get environnement variable
     */
    public function testCanGetEnvironmentVariable()
    {
        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $this->assertNotNull($application->getEnv("MYSQL_PWD"));
    }


    /*
     * Can get environnements variables
     */
    public function testCanGetEnvironmentsVariables()
    {
        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $this->assertNotNull($application->getEnvs());
    }

    /*
     * Can set environnement variable
     */
    public function testCanSetEnvironmentVariable()
    {
        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $application->setEnv("PHP_NINX","HELLO");
        $this->assertSame($application->getEnv("PHP_NINX"),"HELLO");
    }

    /*
     * Can unset environnement variable
     */
    public function testCanUnSetEnvironmentVariable()
    {
        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $application->unsetEnv("PHP_NINX");
        $this->assertArrayNotHasKey("PHP_NINX",$application->getEnvs());
    }

    /*
     * Can set environnements variables
     */
    public function testCanSetEnvironmentsVariables()
    {
        $envs = [
            "MYSQL" => "5.6",
            "PHP" => "7.1",
            "NODE" => "7.5"
        ];

        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $application->setEnvs($envs);
        $this->assertArrayHasKey("MYSQL",$application->getEnvs());
        $this->assertArrayHasKey("PHP",$application->getEnvs());
        $this->assertArrayHasKey("NODE",$application->getEnvs());
    }

    public function testCanDestroyAnApplication()
    {
        $cluster = new Cluster($this->config);
        $application = $cluster->application("myapp");
        $this->assertTrue($application->delete());
    }

    public function testCanUnSubscribeACluster()
    {
        $cluster = new Cluster($this->config);
        $cluster->disconnect();
        $this->assertFalse($cluster->isConnected());
    }

}