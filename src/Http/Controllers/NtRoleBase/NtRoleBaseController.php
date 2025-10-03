<?php

namespace Netizens\RB\Http\Controllers\NtRoleBase;

use Illuminate\Routing\Controller;

class NtRoleBaseController extends Controller
{
    public function index()
    {
        $data = [
            'message' => 'Welcome to Nt-RB',
        ];
        return view('ntrolebaseView::ntrolebase.index', compact('data'));
    }
}
