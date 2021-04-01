<?php
 namespace OCA\OcJobs\Controller;

 use OCP\IRequest;
 use OCP\AppFramework\Controller;
 use OCP\IDBConnection;

 use OCP\AppFramework\Http;
 use OCP\AppFramework\Http\DataResponse;


 class JobsController extends Controller {

    private $connection;


    public function __construct(IDBConnection $connection, string $AppName, IRequest $request){
        parent::__construct($AppName, $request);
        $this->connection = $connection;
    }

     /**
	  * Retrieve all job from oc_jobs table
      * @NoAdminRequired
      * @NoCSRFRequired
      */
    public function getAll() {
        $query = $this->connection->getQueryBuilder();
		$query->select('*')
			->from('jobs');
        $result = $query->execute();
		// better use fetchAll than fetch loop
		$jobs = $result->fetchAll();
        $result->closeCursor();
        // DataResponse outputs json array
		return new DataResponse($jobs);
    }

 } 