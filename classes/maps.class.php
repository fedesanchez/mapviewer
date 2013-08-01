<?php


class Maps {
    private $items;
    public $connection;
    
    
    function __construct() { 
        include("../classes/db.class.php");
        try {
            $this->connection=new DBconnection();
            $this->initDB();
        }
        catch (Exception $e) {
            die($e->getMessage());
        }
        
    }
    
    
    function initDB(){

        $statement = "CREATE TABLE IF NOT EXISTS maps (id serial PRIMARY KEY, config text , description text);";        
        try {
            $sql = $this->connection->prepare($statement);          
            $sql->execute();    
        } catch (Exception $e) {
            die("Error: $e");
        }
        
        
    }


    function getMapList($request) {    
        try {
            $statement ="SELECT id,config,description FROM maps;";
            $sql = $this->connection->prepare($statement);
            $sql->execute();
            $results=$sql->fetchAll();
            return $results;
            //$this->createResponse($results,"200");
        /*
        $items = array();
        //$config;
        foreach($results as $key) {
            //$config = JSON.parse(results.getString("config"));
            array_push($items,{
                id: $key["id"], 
                description:$key["description"]
                //title: config.about && config.about.title,
                //"abstract": config.about && config.about["abstract"],
                //created: config.created,
                //modified: config.modified
            });
        }
        */
        } catch(Exception $e) {
            error_log("Error al traer la lista de mapas : $e");
        }
    
   
    }

    function isAuthorized($request) {
        //return auth.getStatus(request) !== 401;
        return true;
    }

    function getId($request) {
        if (!isset($request[0]) || $request[0]=="") {
            // null means no id            
            $id = null;
        } else {            
            $id=$request[0];                      
            $id += 0;
            if (!is_numeric($id)) {
                // false means invalid id
                $id = false;
            }
        }
        return $id;
    }

    function getConfig($request) {
        $config = $request["config"];
      /*  var obj;
        try {
        obj = JSON.parse(config);
        } catch (err) {
            config = null;
        }
        if (typeof obj !== "object" || Array.isArray(obj)) {
            config = null;
        }
        */
        $config=str_replace(" ","", $config);
        $config=str_replace("\t","", $config);
        $config=str_replace(PHP_EOL,"", $config);
        
        return trim($config)    ;
    }

    function getDescription($request) {
        $description = $request["description"];     
        return $description;
    }

    function createResponse($data, $status) {
        if(!$status)$status=200;
        $response= array(
                        'status' => $status,
                        'request' => array($data)
                        );
        
        $encoded = json_encode($response,true);
        header('Content-type: application/json');
        exit("var AppResponse=$encoded");

    }

    function GET($request) {
        $resp;
        $id = $this->getId($request);
        if ($id === null) {
            // retrieve all map identifiers
            $resp = $this->createResponse($this->getMapList($request),200);
        } else if ($id === false) {
            // invalid id
            $resp = $this->createResponse("Invalid map id.", 400);
        } else {
            // retrieve single map config
            $resp = $this->createResponse($this->readMap($id, $request),200);
        }
        return $resp;
    }

    function POST($request) {
        $resp;
        if ($this->isAuthorized($request)) {
            $id = $this->getId($request);
            if ($id !== null) {
                $resp = $this->createResponse("Can't POST to map $id", 405);
            } else {
                $config = $this->getConfig($request);
                $description= $this->getDescription($request);
                if (!$config) {
                    $resp = $this->createResponse("Bad map config.", 400);
                } else {
                    // return the map id                    
                    $resp = $this->createResponse($this->createMap($config, $description),200);
                }
            }
        } else {
            $resp = $this->createResponse("Not authorized", 401);
        }
        //return $resp;
    }

    function PUT($request) {
        $resp;
        if ($this->isAuthorized($request)) {
            $id = $this->getId($request);
            if ($id === null) {
                $resp = $this->createResponse("Can't PUT without map id.", 405);
            } else if ($id === false) {
                $resp = $this->createResponse("Invalid map id.", 400);
            } else {
                // valid map id
                $config = $this->getConfig($request);
                if (!$config) {
                    $resp = $this->createResponse("Bad map config.", 400);
                } else {
                    $resp = $this->createResponse($this->updateMap($id, $config, $request));
                }
            }
        } else {
            $resp = $this->createResponse("Not authorized", 401);
        }
        return $resp;
    }

    function DELETE($request) {
        $resp;
        if ($this->isAuthorized($request)) {
            $id = $this->getId($request);
            if ($id === null) {
                $resp = $this->createResponse("Can't DELETE without map id.", 405);
            } else if ($id === false) {
                $resp = $this->createResponse("Invalid map id.", 400);
            } else {
                $resp = $this->deleteMap($id, $request);
            }
        } else {
            $resp = $this->createResponse("Not authorized", 401);
        }
        //return $resp;
    }


    function readMap($id, $request) {
        $config;
        try {
            $statement="SELECT config FROM maps WHERE id = $id;"; // todo: avoid sql injections
            $sql = $this->connection->prepare($statement);
            $sql->execute();
            
            $results = $sql->fetchAll();
            if (count($results)==1) {
                // found map by id              
                $config = $this->getConfig($results[0]);
             } else {
                // not found
                $this->createResponse("No map with id $id",404);
                }
        
        } catch(Exception $e){
            error_log("Error reading Map : $e");
        }
    return $config;
    }

    function createMap($config, $description) {
    //if (typeof config === "string") {
      //  config = JSON.parse(config);
    //}
    // add creation & modified date
    //var now = Date.now();
    //config.created = now;
    //config.modified = now;
    //config = JSON.stringify(config);
    //var connection = SQLITE.open(getDb(request));
    try {
        // store the new map config
        $statement="INSERT INTO maps (config,description) VALUES (?,?) RETURNING id;";
        $sql = $this->connection->prepare($statement);
        $sql->execute(array($config,$description));
        $results = $sql->fetchAll();
        $id=$results[0]["id"];
        
        } catch (Exception $e) {
            $this->createResponse("Error : unable to save map. $e",405);
        }
        // return the map id
        return array('id' => $id);
    }

    function deleteMap($id, $request) {
        $result;
        try {
            $statement="DELETE FROM maps WHERE id = ? returning id;";
            $sql = $this->connection->prepare($statement);
            $sql->execute(array($id));
            $results = $sql->fetchAll();
            $DeletedId=$results[0]["id"];
            if($DeletedId){
                $this->createResponse(array('id' => $DeletedId,'message'=>'success: deleted'),200);
            }else{
                $this->createResponse("No map with id $id",400);    
            }
        } catch (Exception $e) {
            $this->createResponse("Error: Unable to delete map $id",405);
        }             
    }

    function updateMap($id, $config, $request) {
       /*
        if (typeof config === "string") {
            config = JSON.parse(config);
        }
        // update modified date
        config.modified = Date.now();
        config = JSON.stringify(config);
        */        
        try {
             $statement="UPDATE maps SET config = ? WHERE id = ? returning id;";
             $sql = $this->connection->prepare($statement);
             $sql->execute(array($config,$id));
             $results = $sql->fetchAll();
             $UpdatedId=$results[0]["id"];
             $this->createResponse(array('id' => $UpadtedId,'message'=>'success: updated'),200);
        } catch (Exception $e) {
            $this->createResponse("No map with id $id",400);
        }  
    }



}
?>