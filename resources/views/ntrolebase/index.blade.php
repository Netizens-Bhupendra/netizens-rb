@extends('layouts.master')

@section('title', $viewData['title'])

@section('css')
@endsection

@section('style')

@endsection

@section('breadcrumb')
    <x-common.bread-crumb-component>
        <li class="breadcrumb-item active">User Management</li>
        <li class="breadcrumb-item active">Role & Permissions</li>
    </x-common.bread-crumb-component>
@endsection

@section('content')
    <div class="row">
        <div class="container-fluid">
            <div class="row starter-main">
                <div class="card">

                    <div class="border-0 collapse" id="filterSidebar">
                        <div class="row justify-content-start align-items-center gap-sm-0 gap-3 px-4 mt-3">

                        </div>
                        <div class="col-md-3 justify-content-start align-items-center gap-sm-0 gap-3 card-body" id="reset-filters-container">
                            <button class="btn btn-primary waves-effect waves-light" type="button" id="reset-filters-btn">
                                <i class="ti ti-reset me-sm-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <div class="card-body table-search-label">
                        {!! $dataTable->table(['class' => 'table dataTable'], true) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" id="{{ $viewData['canvasId'] ?? '' }}" data-bs-backdrop="true">
    </div>

    <!-- Toast with Animation -->
    <div class="bs-toast toast toast-ex animate__animated my-2" role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-delay="2000">
        <div class="toast-header">
            <i class="ti ti-bell ti-xs me-2"></i>
            <div class="me-auto fw-medium toast-title"></div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
    <!--/ Toast with Animation -->

         <x-modal.common
        modal-id="{{ $viewData['permission_model_id'] ?? '' }}"
        modal-class="{{ $viewData['permission_model_class'] ?? '' }}"
        modal-size="{{ $viewData['permission_modal_size'] ?? '' }}"
        dynamic-data-id="{{ $viewData['permission_dynamic_data_id'] ?? '' }}"
        title="{{ $viewData['permission_modal_heading'] ?? '' }}"
        isFooter="true"
        submitBtnClass="permission-submit-btn"
        submitBtnName="Save"
    />

@endsection
@section('script')
<script src="{{ asset('assets/vendor/libs/notyf/notyf.min.js')}}"></script>
    {{ $dataTable->scripts() }}

    <x-common.datatable-script :prefix="$viewData['prefix']" :dataTableID="$viewData['dataTableID']" :canvasHeading="$viewData['canvasHeading']" :canvasId="$viewData['canvasId']" :canvasSize="$viewData['canvasSize']"
        :manageRoute="$viewData['manageRoute']" :deleteRoute="$viewData['deleteRoute']" :editRoute="$viewData['editRoute']" :additionalRoute="$viewData['additionalRoute']" />
<script>


        $(document).ready(function () {
             {{ $viewData['prefix'] ?? '' }}bindClickedEvents();
        });

        function {{ $viewData['prefix'] ?? '' }}bindClickedEvents() {
            $("#{{ $viewData['dataTableID'] ?? '' }}").on('click', '.view-permission-btn', function () {
                var id = $(this).data('role_id');
                // console.log(id);

                {{ $viewData['prefix'] ?? '' }}manage_permission(id);
            });

            $('.permission-submit-btn').click(function(e) {
                var form = $("#{{ $viewData['permission_formId'] ?? '' }}");
                var formData = new FormData(form[0]);
                {{ $viewData['prefix'] ?? '' }}submit_data(formData);
            });

            $.validator.addMethod("regular_expression", function(value, element) {
                value = $.trim(value);

                // ❌ Empty after trim (means only spaces entered)
                if (value.length === 0) {
                    $.validator.messages.regular_expression = "Role name cannot be empty or just spaces";
                    return false;
                }

                // ❌ Starts or ends with a space
                if (/^\s|\s$/.test(value)) {
                    $.validator.messages.regular_expression = "Role name cannot start or end with a space";
                    return false;
                }

                // ❌ Only letters, numbers, spaces, and dash allowed
                if (!/^[A-Za-z0-9]+(?:[- ]?[A-Za-z0-9]+)*$/.test(value)) {
                    $.validator.messages.regular_expression = "Only letters, numbers, single spaces, and dash (-) are allowed";
                    return false;
                }

                // ❌ Prevent multiple spaces
                if (/\s{2,}/.test(value)) {
                    $.validator.messages.regular_expression = "Multiple spaces are not allowed";
                    return false;
                }

                // ❌ Cannot be only numbers
                if (/^[0-9]+$/.test(value)) {
                    $.validator.messages.regular_expression = "Role name cannot contain only numbers.";
                    return false;
                }

                // ❌ Cannot be only dashes
                if (/^-+$/.test(value)) {
                    $.validator.messages.regular_expression = "Role name cannot contain only dashes.";
                    return false;
                }

                return true;
            }, function(value, element) {
                value = $.trim(value);

                if (value.length === 0) {
                    return "Role name cannot be empty or just spaces";
                }

                if (/^\s|\s$/.test(value)) {
                    return "Role name cannot start or end with a space";
                }

                if (!/^[A-Za-z0-9]+(?:[- ]?[A-Za-z0-9]+)*$/.test(value)) {
                    return "Only letters, numbers, single spaces, and dash (-) are allowed";
                }

                if (/\s{2,}/.test(value)) {
                    return "Multiple spaces are not allowed";
                }

                if (/^[0-9]+$/.test(value)) {
                    return "Role name cannot contain only numbers.";
                }

                if (/^-+$/.test(value)) {
                    return "Role name cannot contain only dashes.";
                }

                return "Invalid role name."; // fallback
            });

        }

        function {{ $viewData['prefix'] ?? '' }}manage_permission(id = null){
            $.ajax({
                type: "POST",
                url: "{{ $viewData['permission_manageRoute'] ?? ''}}",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#{{ $viewData['permission_dynamic_data_id'] ?? '' }}").html("");
                        $("#{{ $viewData['permission_dynamic_data_id'] ?? '' }}").html(response.view);
                        $(".{{ $viewData['permission_model_id'] ?? '' }}").modal('show');
                    }
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
</script>
@endsection
