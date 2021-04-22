# Oc Jobs
Place this app in **nextcloud/apps/**

This will retrieve all jobs from oc_jobs table and make them available when requesting OCS API
To do so, a new route is created to send back a json output containing all jobs informations from oc_jobs table.


Ex : curl -X GET http://admin:password@localhost/nextcloud/ocs/v1.php/api/ocjobs/list -H "OCS-APIRequest: true"