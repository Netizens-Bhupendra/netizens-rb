<?php

namespace Netizens\RB\Services\NtRoleBase;

class NtRoleBaseServices
{

    public function index_services($data, $viewData)
    {
        $viewData['data'] = $data;

        return view('ntrolebaseView::ntrolebase.index', compact('viewData'));
    }
}
