<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\OcJobs\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */

// curl -X GET http://admin:password@localhost/nextcloud/ocs/v1.php/api/ocjobs/list -H "OCS-APIRequest: true"

// jobs#getall > getAll method from JobsController will retrieve all jobs, url can be changed to anything
return [
    'ocs' => [
        ['root' => '/api', 'name' => 'jobs#getall', 'url' => '/ocjobs/list', 'verb' => 'GET'],
    ],
];
