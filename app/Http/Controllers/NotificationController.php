<?php

namespace App\Http\Controllers;

use App\Repository\FriendRepository;
use App\Repository\NotificationRepository;
use App\Repository\TripUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\UserDeviceRepository;

class NotificationController extends Controller
{
    private $notificationRepo;

    private $friendRepo;
    private $tripUserRepo;
    private $userDevice;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        NotificationRepository $notificationRepo,
        FriendRepository $friendRepo,
        TripUserRepository $tripUserRepo,
        UserDeviceRepository $userDevice
    ) {
        $this->middleware('auth');
        $this->notificationRepo = $notificationRepo;
        $this->friendRepo = $friendRepo;
        $this->tripUserRepo = $tripUserRepo;
        $this->userDevice = $userDevice;
    }

    public function getAll()
    {
        try {
            $authUser = Auth::user();
            $allNotification = $this->notificationRepo->getAllNotifyByUserId($authUser->id);
            return $allNotification;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function seenAllFriendNotify()
    {
        try {
            $authUser = Auth::user();
            $this->friendRepo->setSeenForAllNotify($authUser->id);
            return Response('successful', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function seenAllMemberNotify() {
        try {
            $authUser = Auth::user();
            $this->notificationRepo->setSeenAllForMemberNotify($authUser->id);
            return Response('successful', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function seenAllOtherNotify() {
        try {
            $authUser = Auth::user();
            $this->notificationRepo->setSeenAllForOtherNotify($authUser->id);
            return Response('successful', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //sangpt create user device
    public function createUserDevice(Request $request) {
        $authUser = Auth::user();
        if($request->device_token) {
            $this->userDevice->firstOrCreate(['user_id' => $authUser->id, 'device_token' => $request->device_token]);
        }
        $data = [
            'status' => 200,
            'massage' => "successful !"
        ];
        return response()->json($data);
    }
    public function deleteUserDevice(Request $request) {
            $authUser = Auth::user();
            $this->userDevice->deleteWhere(['user_id' => $authUser->id]);
        $data = [
            'status' => 200,
            'massage' => "successful !"
        ];
        return response()->json($data);
    }

}
