<?php

namespace App\Service;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
//use LRedis;

class BaseFirebase
{
    protected $firebase;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile( __DIR__.'/my-project.json');
        $firebase 		  = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://travel-6651b-default-rtdb.firebaseio.com/')
            ->asUser('admin')
            ->create();
        $this->firebase = $firebase;
    }

    public function getFirebaseToken($tripId) {
        return (string) $this->firebase->getAuth()->createCustomToken($tripId);
    }

}
