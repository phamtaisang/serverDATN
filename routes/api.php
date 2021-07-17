<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([

    'middleware' => ['api'],
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('/register', 'AuthController@register');
    Route::get('me', 'AuthController@me');

});
// gui loi nhan trong map
Route::post('trip/send-message','TripController@sendMessageInTrip');

//post
Route::post('/post/create', 'PostController@create');
Route::get('/home', 'HomeController@index');
Route::delete('/post/delete/{id}', 'PostController@destroy');
Route::get('/post/detail/{id}', 'PostController@getDetailPost');
Route::post('post/update/{id}', 'PostController@update');
Route::get('post/by-user/{id}', 'PostController@getPostByUser');
Route::post('/like', 'LikeController@addLike');
Route::post('trip/firebase', 'TripController@createPositionFirebase');
//comment
Route::post('comment/post', 'CommentController@storePostComment');
Route::get('comment/post/edit', 'CommentController@editPostComment');
Route::post('comment/post/remove', 'CommentController@removePostComment');

// user
Route::get('/user/detail-info/{id}', 'UserController@displayInfo');
Route::post('/user/edit/profile', 'UserController@updateProfile');

//friends
Route::get('trip/get-all-my-friends', 'TripController@getMyFriends');

//trip
Route::get('trip/list', 'TripController@showList');
Route::post('trip/create', 'TripController@create');
Route::get('trip/detail_info/{tripId}', 'TripController@show');
Route::delete('trip/delete', 'TripController@delete');
Route::post('trip/{trip_id}', 'TripController@update');
//Route::get('trip/{trip_id}/edit', 'TripController@edit');

//notification
Route::post('create-user-device', 'NotificationController@createUserDevice');
Route::post('delete-user-device', 'NotificationController@deleteUserDevice');
Route::get('notification/get-all', 'NotificationController@getAll');
Route::get('notification/seen_all_friend_notification', 'NotificationController@seenAllFriendNotify');
Route::get('notification/seen_all_member_notification', 'NotificationController@seenAllMemberNotify');
Route::get('notification/seen_all_other_notification', 'NotificationController@seenAllOtherNotify');

Route::get('trip/follow_position/{tripId}', 'TripController@followPosition');
Route::post('trip/store', 'TripController@store');

//search
Route::post('search/friend', 'SearchController@searchFriend');

//friends
Route::post('friends/send-request', 'FriendController@sendRequest');
Route::post('friends/cancel-request', 'FriendController@cancelRequest');
Route::post('friends/accept-request', 'FriendController@acceptRequest');

//invitation
Route::post('trip/invitation/add', 'MemberTripController@inviteFriend');
Route::post('trip/invitation/accept', 'MemberTripController@acceptInvitation'); //đồng ý lời mời chuyến đi từ người khác
Route::delete('trip/invitation/reject_or_delete', 'MemberTripController@rejectOrDeleteInvitation');

//join request (tham gia chuyen di)
Route::post('trip/join-request/create', 'MemberTripController@createJoinRequest'); //xin tham gia 1 chuyen di
Route::post('trip/join-request/accept', 'MemberTripController@acceptJoinRequest'); //dong y cho 1 nguoi khac tham gia chuyen di cua minh
Route::delete('trip/join-request/reject_or_cancel', 'MemberTripController@rejectJoinRequest'); //huy bo

//Route::get('trip/follow_position/{tripId}', 'TripController@followPosition');

Route::get('get-location-my-friends/{tripId}','TripController@getLocationMyFriends');

