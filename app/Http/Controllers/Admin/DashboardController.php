<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipTransaction;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalMembers' => Member::count(),
            'activeMembers' => Member::where('status', 'Active')->count(),
            'pendingTransactions' => MembershipTransaction::where('status', 'pending')->count(),
            'collectedPayments' => Payment::sum('amount'),
        ]);
    }
}