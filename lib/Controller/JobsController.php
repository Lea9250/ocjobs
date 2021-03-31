<?php
 namespace OCA\OcJobs\Controller;

 use OCP\IRequest;
 use OCP\AppFramework\Controller;
 use OCP\IDBConnection;
 use OCP\BackgroundJob\JobList;

 use OCP\AppFramework\Http;
 use OCP\AppFramework\Http\DataResponse;


 class JobsController extends Controller {

    private $userId;
    private $connection;


    public function __construct(IDBConnection $connection, string $AppName, IRequest $request, $userId){
        parent::__construct($AppName, $request);
        $this->userId = $userId;
        $this->connection = $connection;
    }

    	/**
	 * get the job object from a row in the db
	 * COPIED FROM JobList ------------------------------------------
	 * @param array $row
	 * @return IJob|null
	 */
	private function buildJob($row) {
		try {
			try {
				// Try to load the job as a service
				/** @var IJob $job */
				$job = \OC::$server->query($row['class']);
			} catch (QueryException $e) {
				if (class_exists($row['class'])) {
					$class = $row['class'];
					$job = new $class();
				} else {
					// job from disabled app or old version of an app, no need to do anything
					return null;
				}
			}

			$job->setId((int) $row['id']);
			$job->setLastRun((int) $row['last_run']);
			$job->setArgument(json_decode($row['argument'], true));
			return $job;

		} catch (AutoloadNotAllowedException $e) {
			// job is from a disabled app, ignore
			return null;
		}
	}

	
     /**
      * @NoAdminRequired
      * @NoCSRFRequired
      * @param string $title
      * @param string $content
      */
    public function getAll() {
        $query = $this->connection->getQueryBuilder();
		$query->select('*')
			->from('jobs');
        $result = $query->execute();
		$jobs = [];
        while ($row = $result->fetch()) {
            $job = $this->buildJob($row);
            if ($job) {
                $jobs[] = (array) $job;
            }
        }
        $result->closeCursor();
        return new DataResponse($jobs);
    }

 }