<body class="bg-slate-100 font-sans text-slate-900 dynamic-view antialiased">

    <!-- Page Title Bar -->
    <header class="bg-[#0b3b63] text-white p-4 text-xl lg:text-2xl font-bold shadow-md">
        Delegation of Authority (DAL)
    </header>

    <!-- Reactive Wrapper Container via Alpine.js -->
    <main class="container mx-auto max-w-6xl p-4" 
          x-data="{ 
              activeTab: 'capital', 
              searchQuery: '',
              matchesSearch(text) {
                  return text.toLowerCase().includes(this.searchQuery.toLowerCase());
              }
          }">

        <!-- Tabs Navigation -->
        <div class="flex gap-2 flex-wrap mb-4">
            <button type="button"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200"
                    :class="activeTab === 'capital' ? 'bg-[#0b3b63] text-white shadow' : 'bg-white text-[#0b3b63] border border-[#0b3b63]/30 hover:bg-slate-50'"
                    @click="activeTab = 'capital'; searchQuery = ''">
                Capital Expenditure
            </button>

            <button type="button"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200"
                    :class="activeTab === 'noncapital' ? 'bg-[#0b3b63] text-white shadow' : 'bg-white text-[#0b3b63] border border-[#0b3b63]/30 hover:bg-slate-50'"
                    @click="activeTab = 'noncapital'; searchQuery = ''">
                Non-Capital Expenditure
            </button>
        </div>

        <!-- Real-time Search Input -->
        <div class="mb-6">
            <input type="text"
                   x-model="searchQuery"
                   class="w-full px-4 py-3 text-base bg-white rounded-xl border border-slate-200 shadow-sm focus:border-[#0b3b63] focus:ring-2 focus:ring-[#0b3b63]/20 transition-all outline-none"
                   placeholder="Search visible DAL records...">
        </div>

        <!-- ========================================== -->
        <!-- CAPITAL EXPENDITURE SECTION                -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'capital'" x-cloak class="space-y-4">
            
            <!-- Mobile View (Hidden on screens larger than 1024px) -->
            <div class="block lg:hidden space-y-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden"
                     x-show="matchesSearch('Capital Expenditure Approval Malaysia > RM500k Singapore > SGD500k Approver CEO Approval Requires Board endorsement')">
                    
                    <div class="bg-[#f7d768] px-4 py-3 font-bold text-sm text-slate-800">
                        Capital Expenditure Approval
                    </div>
                    
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span class="text-sm font-semibold text-slate-500">Malaysia</span>
                            <span class="font-bold text-[#0b3b63]">&gt; RM500k</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span class="text-sm font-semibold text-slate-500">Singapore</span>
                            <span class="font-bold text-[#0b3b63]">&gt; SGD500k</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span class="text-sm font-semibold text-slate-500">Approver</span>
                            <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-bold tracking-wide">
                                CEO Approval
                            </span>
                        </div>
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-3 rounded-r-lg text-sm text-amber-900 mt-2">
                            Requires Board endorsement.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop View (Hidden on screens smaller than 1024px) -->
            <div class="hidden lg:block overflow-hidden bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-800 text-[#0b3b63] text-sm font-semibold">
                                <th class="p-4 w-16 text-center">No</th>
                                <th class="p-4">Malaysia</th>
                                <th class="p-4">Singapore</th>
                                <th class="p-4">Approver</th>
                                <th class="p-4">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm font-medium">
                            <tr class="hover:bg-slate-50/50 transition-colors"
                                x-show="matchesSearch('1 > RM500k > SGD500k CEO Requires Board endorsement')">
                                <td class="p-4 text-center text-slate-400 font-normal">1</td>
                                <td class="p-4 text-[#0b3b63] font-semibold">&gt; RM500k</td>
                                <td class="p-4 text-[#0b3b63] font-semibold">&gt; SGD500k</td>
                                <td class="p-4">
                                    <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-bold">CEO</span>
                                </td>
                                <td class="p-4 text-slate-600">Requires Board endorsement</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- NON-CAPITAL EXPENDITURE SECTION            -->
        <!-- ========================================== -->
        <div x-show="activeTab === 'noncapital'" x-cloak class="space-y-4">
            
            <!-- Mobile View -->
            <div class="block lg:hidden space-y-4">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden"
                     x-show="matchesSearch('Non-Capital Expenditure Malaysia ≤ RM250k Singapore ≤ SGD250k Approver Deputy CEO Consultation with Group Legal required')">
                    <div class="bg-[#f7d768] px-4 py-3 font-bold text-sm text-slate-800">
                        Non-Capital Expenditure
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span class="text-sm font-semibold text-slate-500">Malaysia</span>
                            <span class="font-bold text-[#0b3b63]">≤ RM250k</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span class="text-sm font-semibold text-slate-500">Singapore</span>
                            <span class="font-bold text-[#0b3b63]">≤ SGD250k</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span class="text-sm font-semibold text-slate-500">Approver</span>
                            <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-bold">
                                Deputy CEO
                            </span>
                        </div>
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-3 rounded-r-lg text-sm text-amber-900 mt-2">
                            Consultation with Group Legal required.
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden"
                     x-show="matchesSearch('Small Purchase Approval Malaysia ≤ RM50k Approver GM Approval')">
                    <div class="bg-[#f7d768] px-4 py-3 font-bold text-sm text-slate-800">
                        Small Purchase Approval
                    </div>
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span class="text-sm font-semibold text-slate-500">Malaysia</span>
                            <span class="font-bold text-[#0b3b63]">≤ RM50k</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <span class="text-sm font-semibold text-slate-500">Approver</span>
                            <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-bold">
                                GM Approval
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop View -->
            <div class="hidden lg:block overflow-hidden bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-800 text-white text-sm font-semibold">
                                <th class="p-4 w-16 text-center">No</th>
                                <th class="p-4">Malaysia</th>
                                <th class="p-4">Singapore</th>
                                <th class="p-4">Approver</th>
                                <th class="p-4">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm font-medium">
                            <tr class="hover:bg-slate-50/50 transition-colors"
                                x-show="matchesSearch('1 ≤ RM250k ≤ SGD250k Deputy CEO Consultation with Group Legal required')">
                                <td class="p-4 text-center text-slate-400 font-normal">1</td>
                                <td class="p-4 text-[#0b3b63] font-semibold">≤ RM250k</td>
                                <td class="p-4 text-[#0b3b63] font-semibold">≤ SGD250k</td>
                                <td class="p-4">
                                    <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-bold">Deputy CEO</span>
                                </td>
                                <td class="p-4 text-slate-600">Consultation with Group Legal required</td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors"
                                x-show="matchesSearch('2 ≤ RM50k - GM -')">
                                <td class="p-4 text-center text-slate-400 font-normal">2</td>
                                <td class="p-4 text-[#0b3b63] font-semibold">≤ RM50k</td>
                                <td class="p-4 text-slate-400">-</td>
                                <td class="p-4">
                                    <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-bold">GM</span>
                                </td>
                                <td class="p-4 text-slate-400">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

    <!-- Essential styling hack to prevent Alpine template flicker before initialization -->
    <style>[x-cloak] { display: none !important; }</style>
</body>