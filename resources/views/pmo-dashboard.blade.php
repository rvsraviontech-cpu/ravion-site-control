<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ravion PMO Control Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">

    <nav class="bg-slate-900 text-white shadow-md px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-600 p-2 rounded-lg font-bold text-lg tracking-wider">RVS</div>
            <div>
                <h1 class="text-md font-bold leading-tight">Ravion Vertex Systems</h1>
                <p class="text-xs text-slate-400">PMO Control & Verification Dashboard</p>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-xs bg-slate-800 px-3 py-1.5 rounded border border-slate-700 text-blue-400 font-medium">Role: DGM / PMO Controller</span>
            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center font-bold text-sm text-white">PM</div>
        </div>
    </nav>

    <main class="p-6 max-w-7xl mx-auto space-y-6">

        @if(session('verified_success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl shadow-sm text-xs font-bold">
                {{ session('verified_success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Active Sites</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalActiveSites }} Projects</p>
                <span class="text-[11px] text-emerald-600 font-medium">Live from Ledger</span>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-500">DPR Submissions Today</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $submissionsToday }} Submitted</p>
                <span class="text-[11px] text-gray-500">Real-time counter</span>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-purple-600">Pending Mapping Queue</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $pendingMappingCount }} Items</p>
                <span class="text-[11px] text-purple-600 bg-purple-50 px-1.5 py-0.5 rounded">Action Required Below</span>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">Material Inflow Logs</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">Active</p>
                <span class="text-[11px] text-gray-500">Ready for Accountant Check</span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 text-sm tracking-wide uppercase">Incoming Field Site Reports Queue</h3>
                    <span class="text-xs text-gray-500 font-medium">Awaiting PMO Ledger Assignment</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100/70 text-[11px] uppercase tracking-wider font-semibold text-gray-500 border-b border-gray-200">
                                <th class="p-4">Project Information</th>
                                <th class="p-4">Reported Work Activity</th>
                                <th class="p-4 text-center">Labor Count</th>
                                <th class="p-4">Material Status</th>
                                <th class="p-4">Assign Cost Account & Verify</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs">
                            @forelse($pendingLogs as $log)
                                <tr class="hover:bg-gray-50/80 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-gray-900">{{ $log->project_name }}</p>
                                        <p class="text-[11px] text-gray-400">Sub: {{ $log->contractor_name }}</p>
                                    </td>
                                    <td class="p-4">
                                        <p class="font-medium text-gray-800">{{ $log->work_activity }}</p>
                                        <p class="text-[11px] text-blue-600 font-medium">Vol Comp: {{ $log->quantity_completed }}</p>
                                    </td>
                                    <td class="p-4 text-center font-bold text-gray-700">{{ $log->labor_count }} Mandays</td>
                                    <td class="p-4">
                                        @if($log->material_desc)
                                            <p class="font-medium text-amber-700">{{ $log->material_desc }}</p>
                                            <p class="text-[10px] text-gray-500">Qty: {{ $log->material_qty }} | Ch: {{ $log->challan_no }}</p>
                                        @else
                                            <span class="text-gray-400 italic">None logged</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <form action="{{ route('dpr.verify', $log->id) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            <select name="cost_code" required class="bg-gray-50 border border-gray-300 rounded-lg p-2 text-xs text-gray-700 focus:ring-1 focus:ring-blue-500 outline-none">
                                                <option value="">-- Link Cost Code --</option>
                                                @foreach($costCodes as $code)
                                                    <option value="{{ $code->code }}">{{ $code->code }} - {{ $code->activity_name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-sm transition shrink-0">
                                                Verify & Map
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400 italic text-sm">
                                        No pending entries left in the queue! All reports verified.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

</body>
</html>