<?php

namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository;

class PositionRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Position";
    }

    public function deleteOldPositions($postId, $tripId)
    {
        if($postId) {
            $this->deleteWhere(['post_id' => $postId]);
        }
        if($tripId) {
            $this->deleteWhere(['trip_id' => $tripId]);
        }
    }

    public function createPositions(
        $lats,
        $lngs,
        $descriptions,
        $timeArrive,
        $timeLeave,
        $postId = null,
        $tripId = null
    ) {
        if (($postId || $tripId) && count($lats) > 0) {
            for ($i = 0; $i < count($lats); $i++) {
                $this->create([
                    'post_id' => $postId,
                    'trip_id' => $tripId,
                    'lat' => $lats[$i],
                    'lng' => $lngs[$i],
                    'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $descriptions[$i]),
                    'time_arrive' => $timeArrive[$i] ? date('Y-m-d', strtotime($timeArrive[$i])) : null,
                    'time_leave' => $timeLeave[$i] ? date('Y-m-d', strtotime($timeLeave[$i])) : null,
                ]);
            }
        }
    }

    //sangpt v2
    public function createMarkers($markers, $postId = null, $trip_id) {
        foreach($markers as $marker) {
            $time_arrive =  $marker['time_start'];
            $time_leave =  $marker['time_end'];
            echo $time_arrive."\n".$time_leave;
            $this->create([
                'post_id' => null,
                'trip_id' => $trip_id,
                'lat' => $marker['lat'],
                'lng' => $marker['lng'],
                'description' => preg_replace("/\r\n|\r|\n/", '<br/>', $marker['note']),
                'time_arrive' => $time_arrive,
                'time_leave' => $time_leave
            ]);
        }
    }
    public function deleteOldMarkers($postId, $tripId)
    {
        if($postId) {
            $this->deleteWhere(['post_id' => $postId]);
        }
        if($tripId) {
            $this->deleteWhere(['trip_id' => $tripId]);
        }
    }
}
