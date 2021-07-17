<?php

namespace App\Repository;

use App\Model\Post;
use App\Model\PostImage;
use Prettus\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository
{
    private $tripUserRepo;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\Post";
    }

    public function __construct(\Illuminate\Container\Container $app, TripUserRepository $tripUserRepo)
    {
        $this->tripUserRepo = $tripUserRepo;
        parent::__construct($app);
    }

    public function deletePost($postId)
    {
        return $postId;
    }

    public function getList($authUserId)
    {
        //$allJoinRequestsOfUser = $this->joinRequestRepo->findWhere(['user_id'=>$authUserId]);
//        $allJoinRequestsOfUser = $this->tripUserRepo->findWhere(['user_id'=>$authUserId]);
        $posts = $this->with('trip')->with('like.user')->with('user:id,avatar,name')->orderBy('id', 'desc')->all();
        $posts = $posts->map(function ($post) {
            $post->postImage = $post->postImage->map(function ($image) use ($post) {
                $image->path = url('storage/images/post/'.$post->id.'/'.$image->image);
                return $image->path;
            });

            return $post;
        });


        //        foreach ($posts as $post) {
//            foreach ($allJoinRequestsOfUser as $joinRequest) {
//                if ($post->trip && $post->trip->id === $joinRequest->trip_id) {
//                    $post->member_info = $joinRequest;
//                }
//            }
//        }
        return $this->checkBeLiked($posts, $authUserId);
    }

    public function getListCreateByUser($userId, $authUserId)
    {
        $posts = $this->with('position')
            ->with('like')
            ->with('trip')
            ->with('user:id,avatar,name')
            ->orderBy('id', 'desc')
            ->findWhere(['user_id' => $userId])
        ;

        return $this->checkBeLiked($posts, $authUserId);
    }

    public function getOne($postId, $authUserId)
    {
        $post = $this->with('trip')
            ->with('like')
            ->with('user:id,avatar,name')
            ->find($postId)
        ;
        $post->postImage = $post->postImage->map(function ($image) use ($post) {
            $image->path = url('storage/images/post/'.$post->id.'/'.$image->image);
            return $image->path;
        });
        $likes = $post->like;
        $post->be_liked = false;

        foreach ($likes as $like) {
            if ($like->user_id == $authUserId) {
                $post->be_liked = true;
            }
        }

        return $post;
    }

    public function getPostByUser($userId, $authUserId) {
        $posts = $this
            ->with('like.user')
            ->with('user:id,avatar,name')
            ->orderBy('id', 'desc')
            ->findWhere(['user_id' => $userId])
        ;
        foreach($posts as $post) {
            $post->postImage = $post->postImage->map(function ($image) use ($post) {
                $image->path = url('storage/images/post/'.$post->id.'/'.$image->image);
                return $image->path;
            });
            $likes = $post->like;
            $post->be_liked = false;

            foreach ($likes as $like) {
                if ($like->user_id == $authUserId) {
                    $post->be_liked = true;
                }
            }
        }
        return $posts;
    }

    private function checkBeLiked($posts, $authUserId)
    {
        foreach ($posts as $key => $post) {
            $likes = $post->like;
            $post->be_liked = false;

            foreach ($likes as $like) {
                if ($like->user_id == $authUserId) {
                    $post->be_liked = true;
                }
            }
        }

        return $posts;
    }

    public function searchPost($searchText, $authUserId) {
        $posts = Post::where('description', 'like', '%'.$searchText.'%')->orderBy('created_at', 'desc')->get();
        return $this->checkBeLiked($posts, $authUserId);
    }

}
