<?php

namespace Netizens\RB\Http\Controllers\NtRoleBase;

use Illuminate\Routing\Controller;
use Netizens\RB\Services\NtRoleBase\NtRoleBaseServices;

class NtRoleBaseController extends Controller
{
    public $ntRoleBaseServices;

    public $viewData = [];

    public function __construct(NtRoleBaseServices $ntRoleBaseServices)
    {
        $this->ntRoleBaseServices = $ntRoleBaseServices;

        $this->viewData = [
            'title' => 'System Users',
            'prefix' => 'managing_user_',
            'dataTableID' => 'managinguser-table',

            'canvasId' => '',
            'canvasSize' => '',
            'canvasHeading' => '',

            'model_id' => "managing-user-details",
            'modal_heading' => 'Manage User',
            'modal_size' => 'modal-xl',
            'model_class' => "modal-managing-user-details",
            'dynamic_data_id' => "managing-user-details-content",
            'formId' => 'manage-managing-user-form',

            'manageRoute' => route('manage.managing-user'),
            'editRoute' => '',
            'saveRoute' => route('save.managing-user'),
            'deleteRoute' => route('delete.managing-user'),

            'permission_model_id' => "permission-managing-user-details",
            'permission_modal_heading' => 'Role Permissions',
            'permission_modal_size' => 'modal-xl',
            'permission_model_class' => "modal-managing-user-permission-details",
            'permission_dynamic_data_id' => "managing-user-permission-details-content",
            'permission_formId' => 'manage-managing-user-permission-form',
            'permission_manageRoute' => route('permission.managing-user'),
            'permission_saveRoute' => '',
            'additionalRoute' => [
                'childUser' => route('child-parent-managing-user'),
                'breadcrumb_list' => route('managing-child-parent-breadcrumb'),
            ],
        ];
    }

    public function index()
    {
        $data = [
            'message' => 'Welcome to Nt-RB',
        ];

        return $this->ntRoleBaseServices->index_services($data, $this->viewData);
    }
}
