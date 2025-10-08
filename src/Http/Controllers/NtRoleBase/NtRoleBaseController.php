<?php

namespace Netizens\RB\Http\Controllers\NtRoleBase;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Netizens\RB\DataTables\NtRoleBase\NtRoleDataTable;
use Netizens\RB\Services\NtRoleBase\NtRoleBaseServices;

class NtRoleBaseController extends Controller
{
    public $ntRoleBaseServices;

    public $roleViewData = [];

    public function __construct(NtRoleBaseServices $ntRoleBaseServices)
    {
        $this->ntRoleBaseServices = $ntRoleBaseServices;

        $this->roleViewData = [
            'title' => 'Role & Permissions',
            'permission' => '',
            'prefix' => 'role_',
            'dataTableID' => 'role-table',
            'canvasId' => 'manage-role',
            'canvasSize' => 'canvas-lg',
            'canvasHeading' => 'Manage Role',
            'deleteRoute' => route('ntrb.delete.role'),
            'manageRoute' => route('ntrb.manage.role'),
            'editRoute' => '',
            'additionalRoute' => [''],

            'permission_model_id' => 'permission-user-details',
            'permission_modal_heading' => 'Manage User Permission',
            'permission_modal_size' => 'modal-xl',
            'permission_model_class' => 'modal-user-permission-details',
            'permission_dynamic_data_id' => 'user-permission-details-content',
            'permission_formId' => 'manage-user-permission-form',
            'permission_manageRoute' => route('ntrb.permission.role'),
            'permission_saveRoute' => route('ntrb.save.permission.role'),

        ];
    }

    public function index(Request $request, NtRoleDataTable $dataTable)
    {
        return $dataTable->render('ntrolebaseView::ntrolebase.index', ['viewData' => $this->roleViewData]);
    }
}
