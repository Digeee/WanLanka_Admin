<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UIManagementController extends Controller
{
    public function index()
    {
        return view('admin.ui_management.UI_index');
    }
}
