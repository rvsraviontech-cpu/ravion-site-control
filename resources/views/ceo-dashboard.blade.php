<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ravion Executive Command Node</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-100 font-sans antialiased">

    <header class="bg-[#111827]/80 backdrop-blur border-b border-gray-800 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-tr from-blue-600 to-indigo-600 p-2 rounded-xl font-black text-xl tracking-wider shadow-lg shadow-blue-500/20 text-white">RVS</div>
            <div>
                <h1 class="text-sm font-bold tracking-tight text-white uppercase">Ravion Vertex Systems</h1>
                <p class="text-[11px] text-gray-400">Enterprise Executive Intelligence System</p>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-[10px] bg-blue-950/50 border border-blue-800 px-3 py-1.5 rounded-full text-blue-400 font-bold tracking-wide uppercase">
                Access Level: Chief Executive Officer
            </span>
        </div>
    </header>

    <main class="p-6 max-w-7xl mx-auto space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            <div class="bg-gradient-to-br from-[#111c44] to-[#111827] border border-blue-900/40 p-5 rounded-2xl shadow-xl relative overflow-hidden">
                <p class="text-xs font-bold uppercase tracking-widest text-blue-400">Total Operational Manpower</p>
                <p class="text-3xl font-extrabold text-white mt-2 tracking-tight">{{ $totalManpowerDeployed }} Headcount</p>
                <span class="text-[10px] text-gray-400 block mt-1">Sum of active field mandays deployed across verified projects</span>
            </div>

            <div class="bg-gradient-to-br from-[#1e1035] to-[#111827] border border-purple-900/40 p-5 rounded-2xl shadow-xl relative overflow-hidden">
                <p class="text-xs font-bold uppercase tracking-widest text-purple-400">Verified Task Metrics</p>
                <p class="text-3xl font-extrabold text-white mt-2 tracking-tight">{{ $totalVerifiedTasks }} Activities</p>
                <span class="text-[10px] text-gray-400 block mt-1">Physical engineering line items parsed and mapped by PMO</span>
            </div>

            <div class="bg-gradient-to-br from-[#0c231a] to-[#111827] border border-emerald-900/40 p-5 rounded-2xl shadow-xl relative overflow-hidden">
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-400">Material Inflows Documented</p>
                <p class="text-3xl font-extrabold text-white mt-2 tracking-tight">{{ $materialChallansCount }} Challans</p>
                <span class="text-[10px] text-gray-400 block mt-1">Verified site material arrival items cataloged in ledger</span>
            </div>

        </div>

        <div class="bg-[#111827] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800 bg-[#161f30]/40 flex justify-between items-center">
                <div>
                    <h3 class="font-extrabold text-white text-xs tracking-wider uppercase">Verified Project Ledger Stream</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">Real-time certified production logs from across all locations.</p>
                </div>
                <span class="text-[10px] bg-emerald-950 text-emerald-400 font-bold px-2.5 py-1 rounded-md border border-emerald-800 uppercase tracking-widest">
                    Live Feed SECURE
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#161f30]/20 text-[10px] uppercase tracking-widest font-bold text-gray-400 border-b border-gray-800">
                            <th class="p-4">Project / Location</th>
                            <th class="p-4">Activity Matrix</th>
                            <th class="p-4">Assigned Cost Code</th>
                            <th class="p-4 text-center">Labor Force</th>
                            <th class="p-4">Material Audit Logs</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800 text-xs text-gray-300">
                        @forelse($verifiedLogs as $log)
                            <tr class="hover:bg-gray-800/30 transition duration-150">
                                <td class="p-4">
                                    <p class="font-bold text-white text-sm">{{ $log->project_name }}</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Contractor: {{ $log->contractor_name }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="font-semibold text-gray-200">{{ $log->work_activity }}</p>
                                    <p class="text-[11px] text-blue-400 font-medium mt-0.5">Volume Done: {{ $log->quantity_completed }}</p>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-blue-950/60 text-blue-400 rounded-lg font-mono font-bold border border-blue-900/60 text-[11px]">
                                        {{ $log->cost_code_mapped }}
                                    </span>
                                </td>
                                <td class="p-4 text-center font-bold text-white text-sm">
                                    {{ $log->labor_count }} <span class="text-xs text-gray-500 font-normal">Pax</span>
                                </td>
                                <td class="p-4">
                                    @if($log->material_desc)
                                        <p class="font-medium text-amber-400">{{ $log->material_desc }}</p>
                                        <p class="text-[11px] text-gray-500 mt-0.5">Volume: {{ $log->material_qty }} | Challan: #{{ $log->challan_no }}</p>
                                    @else
                                        <span class="text-gray-600 italic">No supply items logged</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-500 italic text-sm tracking-wide">
                                    No verified progress items found in the data pipeline. Awaiting PMO approvals.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>