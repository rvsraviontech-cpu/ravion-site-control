<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DprController extends Controller
{
    // Handle form submission from Site Engineer
    public function store(Request $request)
    {
        // Insert data directly into the database table
        DB::table('dpr_logs')->insert([
            'project_name'      => $request->input('project_id'),
            'work_activity'     => $request->input('work_activity'),
            'contractor_name'   => $request->input('contractor_name'),
            'labor_count'       => $request->input('labor_count'),
            'quantity_completed'=> $request->input('quantity_completed'),
            'material_desc'     => $request->input('material_desc'),
            'material_qty'      => $request->input('material_qty'),
            'challan_no'        => $request->input('challan_no'),
            'status'            => 'pending_mapping',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return back()->with('success', 'Daily Progress Report successfully submitted to PMO!');
    }
}