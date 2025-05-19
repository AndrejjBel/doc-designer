<?php

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Constructor\Data\View;
use Hleb\Static\Request;
use App\Models\{
    PostModel,
    OrdersModel,
    GlampingModel,
    ReviewsModel,
    LocationModel
};

class AdminFetchController extends Controller
{
    public function index()
    {
        $allPost = Request::allPost();
        if ($allPost['action'] == 'edit_status') {
            $this->edit_status($allPost);
        }
        if ($allPost['action'] == 'edit_location') {
            $this->edit_location($allPost);
        }
    }

    public function edit_status($allPost)
    {
        if ($allPost['post_type'] == 'glampings') {
            GlampingModel::editStatus(
                [
                    'id'        => $allPost['id'],
                    'post_status' => $allPost['status']
                ]
            );
            $message = 'success';
            echo json_encode($message, true);
        }

        if ($allPost['post_type'] == 'posts') {
            PostModel::editStatus(
                [
                    'id'        => $allPost['id'],
                    'post_status' => $allPost['status']
                ]
            );
            $message = 'success';
            echo json_encode($message, true);
        }

        if ($allPost['post_type'] == 'reviews') {
            ReviewsModel::editStatus(
                [
                    'id'        => $allPost['id'],
                    'post_status' => $allPost['status']
                ]
            );
            $message = 'success';
            echo json_encode($message, true);
        }
    }

    public function edit_location($allPost)
    {
        $id = (int)str_replace('location', '', $allPost['loc_id']);
        $location = LocationModel::getLocationForId($id);
        echo json_encode($location, JSON_UNESCAPED_UNICODE);
    }
}
