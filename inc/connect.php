<?php
try {

	/* credentials for database access  */
    protected $con;
    private $host = "us-cdbr-azure-southcentral-f.cloudapp.net";
    private $user = "bb2888a2afc292";
    private $pass = "63fbe536";
    private $db = "db-4244f585-ae0a;Data Source=us-cdbr-azure-southcentral-f.cloudapp.net;User Id=bb2888a2afc292;Password=63fbe536";
    
	/*$user = 'root';
	$pass = '';
    $db = new PDO('mysql:host=localhost;dbname=BibliographyManager', $user, $pass);*/
    $db = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pwd);
    db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>