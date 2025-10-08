<?php

namespace Netizens\RB\DataTables\NtRoleBase;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Netizens\RB\Models\NtrbUserHasRole;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NtRoleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public $i = 1;

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $userIds = $this->query(new NtrbUserHasRole)
            ->get()
            ->pluck('role.name')
            ->map(fn ($roleName) => preg_replace('/.*([0-9a-fA-F\-]{36})$/', '$1', $roleName))
            ->filter()
            ->unique();
        // Fetch users in bulk
        $users = User::withTrashed()
            ->whereIn('id', $userIds)
            ->pluck('name', 'id');

        $this->i = $this->request()->get('start') + 1;

        return (new EloquentDataTable($query))
            ->addColumn('#', function ($query) {
                return $this->i++;
            })
            ->addColumn('role_name', function ($query) {
                $return = isset($query->role_name) ? $query->role_name : 'NA';

                return $return;
            })
            ->addColumn('created_at', function ($query) {
                $return = Carbon::parse($query->created_at)->format('d-m-Y');

                return $return;
            })
            ->filterColumn('role_name', function ($query, $keyword) {
                $query->where('role_name', 'like', '%'.$keyword.'%');
            })
            ->addColumn('created_by', function ($query) use ($users) {
                $roleName = $query->role->name ?? '';
                $userId = $roleName ? preg_replace('/.*([0-9a-fA-F\-]{36})$/', '$1', $roleName) : null;

                return $userId && isset($users[$userId]) ? $users[$userId] : 'NA';
            })

            ->addColumn('user_count', function ($query) {
                return $query->role->users_count ?? 0;
            })

            ->addColumn('delete_checkbox', function ($query) {
                $id = $query->role_id;
                $name = $query->role_name ?? '';

                return '<div class="appTimes" id="appTimes">
                    <input type="checkbox"
                        class="select-row form-check-input"
                        value="'.$id.'"
                        data-id="'.$id.'"
                        data-name="'.htmlspecialchars($name, ENT_QUOTES).'">
                </div>';
            })

            ->addColumn('action', function ($query) {
                $btnUpdate = '';
                $btnDelete = '';
                $btnView = '';
                // if (auth()->user()->canAny(['custom_role_update', 'custom_role_delete', 'manage_custom_role_permission'])) {
                //     if (auth()->user()->can('custom_role_update')) {
                $btnUpdate = '<a href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit" data-id="'.$query->role_id.'" data-title="'.$query->title.'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill edit-record-btn">
                                        <i class="ti ti-pencil ti-md"></i>
                                    </a>';
                // }

                // if (auth()->user()->can('custom_role_delete')) {
                $btnDelete = '<a href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete" data-id="'.$query->role_id.'" data-title="'.$query->title.'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record-btn">
                                        <i class="ti ti-trash ti-md"></i>
                                    </a>';
                // }

                // if (auth()->user()->can('manage_custom_role_permission')) {
                $btnView = '<a href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Permisisons" data-role_id="'.$query->role_id.'" class="btn btn-icon btn-text-secondary view-permission-btn">
                                        <i class="ti ti-eye ti-md"></i>
                                    </a>';
                //     }
                // } else {
                //     return '<span class="large-tag badge badge-light text-danger">No Permission</span>';
                // }

                return '<div class="d-flex align-items-center">'.$btnView.$btnUpdate.$btnDelete.'</div>';
            })

            ->orderColumn('role_name', 'role_name $1')
            ->orderColumn('created_at', 'user_has_roles.created_at $1')

            ->setRowId('id')
            ->rawColumns(['#', 'role_name', 'created_at', 'action', 'delete_checkbox']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(NtrbUserHasRole $model): QueryBuilder
    {
        $auth_user = Auth::user();

        return $model->newQuery()
            ->with(['role' => function ($q) {
                $q->withCount('users'); // counts users per role
            }])
            ->where('user_id', $auth_user->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {

        $buttons = [];

        // if (auth()->user()->can('custom_role_create')) {
        $buttons[] = [
            'text' => '<i class="ti ti-plus me-sm-1"></i>',
            'className' => 'dt-button create-new-record btn btn-sm btn-primary ms-2',
            'attr' => [
                'type' => 'button',
            ],
        ];
        // }

        // if (auth()->user()->can('custom_role_delete')) {
        $buttons[] = [
            'text' => '<i class="ti ti-trash me-sm-1"></i><span class="d-none d-sm-inline-block">Delete</span>',
            'className' => 'dt-button btn btn-sm btn-danger ms-2',
            'attr' => [
                'id' => 'delete-selected',
                'type' => 'button',
            ],
        ];
        // }

        return $this->builder()
            ->setTableId('role-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->responsive(true)
            ->orderBy(1)
            ->parameters([
                'drawCallback' => 'function() { events() }',
                'pageLength' => 50,
                'language' => [
                    'lengthMenu' => '_MENU_',
                    'search' => 'Search:',
                    'zeroRecords' => 'No records found',
                ],
                'dom' => '<"top"l<"search-container"f>B<"clear">>rt<"bottom"ip>', // Show length, search, and buttons at the top, and pagination at the bottom
                'buttons' => $buttons,
                'initComplete' => 'function(settings, json) {
                    $(".dataTables_wrapper .dt-buttons").removeClass("btn-group").addClass("d-flex");
                }',
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {

        $columns = []; // Initialize the $columns array

        // if (auth()->user()->can('custom_role_delete')) {
        $columns[] = Column::make('delete_checkbox')
            ->title('<input type="checkbox" id="select-all" class="form-check-input"/>')
            ->titleAttr('Select All')
            ->orderable(false);
        // }

        $columns = array_merge($columns, [

            Column::make('#')
                ->title('Sr No')
                ->searchable(false)
                ->orderable(false)
                ->addClass('text-wrap'),

            Column::make('role_name')
                ->searchable(true)
                ->addClass('text-wrap all'),

            Column::make('user_count')
                ->title('Users')
                ->orderable(false),

            Column::make('created_at')
                ->searchable(true)
                ->addClass('text-wrap'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-right all'),
        ]);

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Role_'.date('YmdHis');
    }
}
