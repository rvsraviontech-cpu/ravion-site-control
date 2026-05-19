<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ravion Field Entry Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
	<link rel="manifest" href="/manifest.json">
</head>
<body class="bg-gray-900 text-gray-100 font-sans antialiased flex flex-col min-h-screen">

    <header class="bg-black/40 backdrop-blur border-b border-gray-800 px-4 py-3 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-2">
            <div class="bg-blue-600 px-2 py-1 rounded font-black text-xs tracking-wider text-white">RVS</div>
            <div>
                <h1 class="text-xs font-bold text-white leading-tight">Ravion Vertex Systems</h1>
                <p class="text-[10px] text-gray-400">Field Operations Reporting Node</p>
            </div>
        </div>
        <span class="text-[10px] bg-gray-800 px-2 py-1 rounded text-blue-400 border border-gray-700 font-medium">
            Role: Site Engineer
        </span>
    </header>

    <main class="flex-1 p-4 max-w-md mx-auto w-full space-y-4">
        
        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl p-5 space-y-4">
            <div>
                <h2 class="text-base font-extrabold text-white tracking-tight">Daily Progress Report (DPR)</h2>
                <p class="text-xs text-gray-400">Submit accurate physical work data & material entries below.</p>
            </div>

            <form action="{{ route('dpr.store') }}" method="POST" class="space-y-4">
                @csrf

                @if(session('success'))
                    <div class="bg-emerald-950/80 border border-emerald-500 text-emerald-400 p-3 rounded-xl text-xs font-bold shadow-md animate-fade-in">
                        ✔ {{ session('success') }}
                    </div>
                @endif

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1.5">Assigned Project Site *</label>
                    <select name="project_id" required class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2.5 text-xs text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition outline-none">
                        <option value="">-- Choose Assigned Site --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->name }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1.5">Work Activity Executed Today *</label>
                    <select name="work_activity" required class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2.5 text-xs text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition outline-none">
                        <option value="">-- Select From Approved Task List --</option>
                        <option value="Excavation & Earthwork">Excavation & Earthwork (CC-001)</option>
                        <option value="RCC Footing Concrete Laying">RCC Footing Concrete Laying (CC-042)</option>
                        <option value="Brickwork Masonry">Brickwork Masonry (CC-109)</option>
                        <option value="Gypsum False Ceiling Framing">Gypsum False Ceiling Framing (CC-512)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1.5">Accountable Sub-Contractor *</label>
                    <select name="contractor_name" required class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2.5 text-xs text-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition outline-none">
                        <option value="">-- Select Sub-Contractor --</option>
                        <option value="Alpha Earthmovers & Co.">Alpha Earthmovers & Co.</option>
                        <option value="Prime Concrete Contractors">Prime Concrete Contractors</option>
                        <option value="Apex Interior Fitouts">Apex Interior Fitouts</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1.5">Labor Count (Mandays) *</label>
                        <input type="number" name="labor_count" required placeholder="e.g. 14" class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2.5 text-xs text-gray-200 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1.5">Qty Completed (SqFt / CuM) *</label>
                        <input type="text" name="quantity_completed" required placeholder="e.g. 450" class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2.5 text-xs text-gray-200 focus:border-blue-500 outline-none">
                    </div>
                </div>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-800"></div>
                    </div>
                    <div class="relative flex justify-center text-[10px] uppercase font-bold tracking-widest">
                        <span class="bg-gray-900 px-3 text-gray-500">Materials Inflow (Optional Ledger)</span>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">Material Component Received</label>
                    <select name="material_desc" class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2 text-xs text-gray-300 outline-none">
                        <option value="">-- No Material Received Today --</option>
                        <option value="OPC Cement 53 Grade">OPC Cement 53 Grade (Bags)</option>
                        <option value="TMT Steel Rebars">TMT Steel Rebars (Metric Tons)</option>
                        <option value="Premium Gypsum Boards">Premium Gypsum Boards (Nos)</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">Received Vol / Qty</label>
                        <input type="number" name="material_qty" placeholder="Quantity" class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2 text-xs text-gray-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1.5">Inflow Challan No</label>
                        <input type="text" name="challan_no" placeholder="Challan #" class="w-full bg-gray-950 border border-gray-700 rounded-xl px-3 py-2 text-xs text-gray-200 outline-none">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-3.5 px-4 rounded-xl shadow-lg active:scale-[0.99] transition duration-150 uppercase tracking-wider">
                        Submit Daily Report to PMO
                    </button>
                </div>
            </form>
        </div>
    </main>
<script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('Ravion Service Worker Registered Cleanly!'))
                    .catch(err => console.log('Service Worker registration failed: ', err));
            });
        }
    </script>
</body>
</body>
</html>