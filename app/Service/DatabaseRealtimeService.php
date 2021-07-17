<?php

namespace App\Service;

class DatabaseRealtimeService extends BaseFirebase
{
    public function storeComment($postId, $tripId, $authUser, $commentContent)
    {
        $database = $this->firebase->getDatabase();
        if ($postId) {
            $comment = $database->getReference('comments/posts/' . $postId);
        } elseif ($tripId) {
            $comment = $database->getReference('comments/trips/' . $tripId);
        }
        return $comment->push(
            [
                'avatar' => $authUser->avatar,
                'user_id' => $authUser->id,
                'content' => $commentContent,
                'user_name' => $authUser->name
            ]
        );

    }

    public function editComment($postId, $tripId, $commentId, $authUser, $commentContent)
    {
        $database = $this->firebase->getDatabase();

        if ($postId) {
            $comment = $database->getReference('comments/posts/' . $postId. '/' . $commentId);
        } elseif ($tripId) {
            $comment = $database->getReference('comments/trips/' . $tripId . '/' . $commentId);
        }
        return $comment->update(
            [
                'content' => $commentContent,
            ]
        );
    }

    public function removeComment($postId, $tripId, $commentId, $authUser)
    {
        $database = $this->firebase->getDatabase();
        if ($postId) {
            $comment = $database->getReference('comments/posts/' . $postId . '/' . $commentId)->remove();
        } elseif
        ($tripId) {
            $comment = $database->getReference('comments/trips/' . $tripId . '/' . $commentId)->remove();
        }
        return $comment;
    }

    public function createTrips($tripId, $authUser, $lat, $lng) {
        $database = $this->firebase->getDatabase();
        if ($tripId) {
            $trip = $database->getReference('trips/' . $tripId.'/'.$authUser->id);
        }
        if ($trip != null) {
            return $trip->update(
                [
                    'avatar' => $authUser->avatar,
                    'user_id' => $authUser->id,
                    'user_name' => $authUser->name,
                    'trip_id' => $tripId,
                    'lat' => $lat,
                    'lng' => $lng,
                ]
            );
        }else {
            return $trip->push(
                [
                    'avatar' => $authUser->avatar,
                    'user_id' => $authUser->id,
                    'user_name' => $authUser->name,
                    'trip_id' => $tripId,
                    'lat' => $lat,
                    'lng' => $lng,
                ]
            );
        }
    }

    public function locationMyFriends($tripId, $friends_ids) {
        $database = $this->firebase->getDatabase();
        foreach($friends_ids as $friend_id) {
            $comment = $database->getReference('trips/' . $tripId. '/' . $friend_id)->getSnapshot()->getValue();
        }
        //Todo chưa chạy
        var_dump($comment);
    }

    //send message in map
    public function sendMessageInTrip($request, $authUser) {
        $database = $this->firebase->getDatabase();
        $tripId = $request['trip_id'];

        if ($request['trip_id']) {
            $trip = $database->getReference('trips/' . $tripId.'/'.$request['user_id'].'/message/');
        }
        if ($trip != null) {

            return $trip->push(
                [
                    "name" => $authUser->name,
                    "content" => $request['message']
                ]
            );
        }else {
            return $trip->push(
                [
                    "name" => $authUser->name,
                    "content" => $request['message']
                ]
            );
        }
    }
}
