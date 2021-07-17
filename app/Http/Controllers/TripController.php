<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Repository\FriendRepository;
use App\Repository\PositionRepository;
use App\Repository\TripRepository;
use App\Repository\TripUserRepository;
use App\Service\DatabaseRealtimeService;
use http\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Service\FirebaseService;

use App\Repository\UserRepository;

class TripController extends Controller
{
    private $userRepo;

    private $tripRepo;

    private $positionRepo;

    private $tripUserRepo;

    private $DbRealtime;
    private $friendRepo;

    public function __construct(
        UserRepository $userRepo,
        TripRepository $tripRepo,
        PositionRepository $positionRepo,
        TripUserRepository $tripUserRepo,
        DatabaseRealtimeService $DbRealtime,
        FriendRepository $friendRepo
    )
    {
        $this->middleware('auth');
        $this->DbRealtime = $DbRealtime;
        $this->userRepo = $userRepo;
        $this->tripRepo = $tripRepo;
        $this->positionRepo = $positionRepo;
        $this->tripUserRepo = $tripUserRepo;
        $this->friendRepo = $friendRepo;
    }

    public function followPosition($tripId)
    {
        $authUser = Auth::user();
        $this->DbRealtime->Trips($tripId, $authUser);
//        $trip = $this->tripRepo->with('tripUser')->find($tripId);
//        $authUser = Auth::user();
//        $members = $trip->tripUser;
//        if ($authUser->id === $trip->user_id) {
//            $firebaseToken = $this->dbRealtime->getFirebaseToken($trip->id);
//            $data = [
//                'user_join' => $members,
//                'trip' => $trip,
//                'firebase_token' => $firebaseToken
//            ];
//            return response()->json($data);
//        }
//        foreach ($members as $member) {
//            if ($member->id === $authUser->id) {
//                $firebaseToken = $this->dbRealtime->getFirebaseToken($trip->id);
//                $data = [
//                    'user_join' => $members,
//                    'trip' => $trip,
//                    'firebase_token' => $firebaseToken
//                ];
//                return response()->json($data);
//            }
//        }
//        return "Error";
    }

    public function createPositionFirebase(Request $request) {
        $authUser = Auth::user();
        $this->DbRealtime->createTrips($request->tripId, $authUser, $request->lat, $request->lng);
        $data = [
            'status' => 200,
            'message' => 'created successful in firebase'
        ];
        return response()->json($data);
    }

    public function store(CreateTripRequest $request)
    {
        $authUser = Auth::user();
        $trip = $this->tripRepo->create([
            'user_id' => $authUser->id,
            'title' => $request->title,
            'description' => $request->description,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
        ]);

        $this->positionRepo->createPositions($request->lat, $request->lng, $request->marker_description, $request->time_arrive, $request->time_leave, null, $trip->id);
        if ($request->member) {
            $this->tripUserRepo->inviteFriends($trip->id, $request->member);
        }
        return redirect()->route('trip.show', ['tripId' => $trip->id]);
    }

    public function delete(Request $request)
    {
        try {
            $trip = $this->tripRepo->find($request->trip_id);
            if ($trip && Auth::user()->can('delete', $trip)) {
                $this->tripUserRepo->deleteWhere(['trip_id' => $request->trip_id]);
                $this->positionRepo->deleteWhere(['trip_id' => $request->trip_id]);
                $this->tripRepo->delete($request->trip_id);
                $data = [
                    'status' => 200,
                    'message' => 'delete successful'
                ];
                return response()->json($data);
            } else {
                throw new \Exception("You can't delete this trip");
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //public function leave(Request $request)
    //{
    //    try {
    //        $authUser = Auth::user();
    //        $this->tripUserRepo->deleteWhere([
    //            'trip_id' => $request->trip_id,
    //            'user_id' => $authUser->id,
    //            'status' => 1,
    //        ]);
    //        $data = [
    //            "code" => 200,
    //            "status" => "success",
    //            "type" => 'leave_the_trip',
    //        ];
    //        return Response($data, 200)->header('Content-Type', 'text/plain');
    //    } catch (\Exception $e) {
    //        return $e->getMessage();
    //    }
    //}

    public function edit($trip_id)
    {
        try {
            $authUser = Auth::user();
            $trip = $this->tripRepo->with('position')->find($trip_id);;
            if ($trip && $authUser->can('update', $trip)) {
                return view('trip.edit')->with('trip', $trip)->with('authUser', $authUser);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //sangpt v2
    public function getMyFriends()
    {
        $authUser = Auth::user();
        $friends = $this->friendRepo->getAllFriendOfUser($authUser->id);
        $data = [
            'friends' => $friends
        ];
        return response()->json($data);
    }

    public function showList()
    {
        try {
            $authUser = Auth::user();
            $tripsCreateByUser = $this->tripRepo->findWhere(['user_id' => $authUser->id]);
            $invitations = $this->tripUserRepo->getAllTripUserBeInvited($authUser->id);
            $joiningTrips = $this->tripUserRepo->getAllTripUserBeJoining($authUser->id);
//            $joiningTrips = $this->tripUserRepo->with('trip')->findWhere(['user_id' => $authUser->id]);
            $data = [
                'listTripByUser' => $tripsCreateByUser,
                'invitations' => $invitations,
                'joiningTrips' => $joiningTrips,
            ];
            return response()->json($data);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        $authUser = Auth::user();
        $trip = $this->tripRepo->create([
            'user_id' => $authUser->id,
            'title' => $request->name_trip,
            'post_id' => $request->post_id,
            'time_start' => date("Y/m/d", strtotime($request->date_start)),
            'time_end' => date("Y/m/d", strtotime($request->date_end)),
        ]);
        $markers = $request->markers;
        $this->positionRepo->createMarkers($markers, null, $trip->id);
        if ($request->friends != null) {
            $this->tripUserRepo->inviteFriends($trip->id, $request->friends);
        }
        $data = [
            'status' => 200,
            'massage' => "successful !"
        ];
        return response()->json($data);
    }

    public function update(Request $request, $trip_id)
    {
        $authUser = Auth::user();
        $trip = $this->tripRepo->update([
            'user_id' => $authUser->id,
            'title' => $request->name_trip,
            'time_start' => date("Y/m/d", strtotime($request->date_start)),
            'time_end' => date("Y/m/d", strtotime($request->date_end)),
        ], $trip_id);
        $this->positionRepo->deleteOldMarkers(null, $trip->id);
        $markers = $request->markers;
        $this->positionRepo->createMarkers($markers, null, $trip->id);
        $this->tripUserRepo->deleteOldFriends($trip->id, $authUser->id);
        if ($request->friends != null) {
            $this->tripUserRepo->inviteFriends($trip->id, $request->friends);
        }
        $data = [
            'status' => 200,
            'massage' => "successful !"
        ];
        return response()->json($data);
    }

    // get detail trips
    public function show($tripId)
    {
        try {
            $authUser = Auth::user();
            $trip = $this->tripRepo->with('tripUser')->with('position')->find($tripId);
//            $invitations = $this->tripUserRepo->getAllInvitationOfTrip($tripId);
//            $joinRequests = $this->tripUserRepo->getAllJoinRequestOfTrip($tripId);
            $trip_info = [
                "title" => $trip->title,
                "time_start" => date("d/m/Y", strtotime($trip->time_start)),
                "time_end" => date("d/m/Y", strtotime($trip->time_end))
            ];
            $positions = [];
            foreach ($trip->position as $position) {
                $position = [
                    "lat" => floatval($position->lat),
                    "lng" => floatval($position->lng),
                    "type" => "new",
                    "time_start_marker" => $position->time_arrive,
                    "time_end_marker" => $position->time_leave,
                    "note" => $position->description,
                    "visible" => false
                ];
                array_push($positions, $position);
            }
            $trip_users = [];
            foreach ($trip->tripUser as $trip_user) {
                $trip_users[] = [
                    "id" => $trip_user->id,
                    "name" => $trip_user->name,
                    "email" => $trip_user->email,
                ];
            }
            $data = [
                'trip' => $trip_info,
                'positions' => $positions,
                'trip_users' => $trip_users,
                'author_id' => $trip->user_id,
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getLocationMyFriends($tripId) {

        //:todo Chưa chạy đc . . .
        $friends_ids = $this->tripUserRepo->getAllMemberOfTrip($tripId);
        $this->DbRealtime->locationMyFriends($tripId, $friends_ids);
        $data = [
            'status' => 200,
            'message' => 'created successful in firebase'
        ];
        return response()->json($data);
    }

    public function sendMessageInTrip(Request $request) {
        $authUser = Auth::user();
        $this->DbRealtime->sendMessageInTrip($request->all(), $authUser);
        $data = [
            'status' => 200,
            'message' => 'send message successful in firebase'
        ];
        return response()->json($data);
    }
}
