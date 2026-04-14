@extends('layouts.app')

@php
    $currentView = request()->query('view', 'fleet-overview');
    $isFullScreenView = $currentView !== 'all';
@endphp

@section('content')
    <!-- View Mode Styles for Fleet Overview -->
    <style>
        .list-view-active .fleet-cards[style*="grid"] {
            display: flex !important;
        }
        .list-view-active .fleet-cards {
            flex-direction: column;
            gap: 0.5rem;
        }
        .list-view-active .fleet-card {
            flex-direction: row;
            align-items: center;
            padding: 0.75rem 1.5rem;
            height: auto;
            justify-content: space-between;
        }
        .list-view-active .fleet-card-header {
            width: 250px;
            margin-bottom: 0;
            flex-shrink: 0;
            flex-direction: row-reverse;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
        }
        .list-view-active .fleet-card-icon {
            font-size: 1.5rem;
            margin-bottom: 0;
        }
        .list-view-active .fleet-card-stats {
            flex-direction: row;
            border-top: none;
            margin-top: 0;
            padding-top: 0;
            gap: 2rem;
            align-items: center;
            justify-content: flex-start;
            flex-grow: 1;
        }
        .list-view-active .fleet-stat {
            flex-direction: row;
            gap: 0.6rem;
            align-items: center;
        }
        .list-view-active .fleet-stat-value {
            font-size: 1.1rem;
        }
        .list-view-active .fleet-card-progress {
            display: none;
        }
        .list-view-active .fleet-card-footer {
            border-top: none;
            margin-top: 0;
            padding-top: 0;
            flex-shrink: 0;
            width: auto;
            justify-content: flex-end;
        }
        .list-view-active .fleet-card-action {
            display: none;
        }
    </style>

    <!-- Full-Screen View Styles -->
    @if($isFullScreenView)
        <style>
            .dashboard-container {
                display: flex;
                flex-direction: column;
                height: 100%;
            }
            
            .dashboard-content {
                flex: 1;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
            }
            
            .summary-section { display: {{ $currentView === 'fleet-overview' ? 'block' : 'none' }}; }
            .airline-section { display: {{ $currentView === 'fleet-overview' ? 'block' : 'none' }}; }
            #life-vest-summary-section { display: {{ $currentView === 'life-vest-summary' ? 'block' : 'none' }}; }
            .stats-section { display: {{ str_starts_with($currentView, 'replacement-') ? 'block' : 'none' }}; }
            
            /* Filter only shown in full view */
            #top { display: none !important; }
            #filterPanel { display: none !important; }
            
            /* Back button for full-screen view */
            .view-back-btn {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 1rem;
                margin-bottom: 1rem;
                background: var(--bg-card);
                border: 1px solid var(--border-subtle);
                border-radius: 6px;
                color: var(--primary);
                text-decoration: none;
                cursor: pointer;
                font-weight: 500;
                transition: all 0.2s ease;
            }
            
            .view-back-btn:hover {
                background: var(--bg-hover);
                border-color: var(--primary);
            }
        </style>
    @endif

    <!-- Back Button for Full-Screen Views -->
    @if($isFullScreenView)
        <a href="{{ route('dashboard') }}" class="view-back-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
            <span>Back to Dashboard</span>
        </a>
    @endif

    <!-- Filter Toggle Button -->
    <div id="top" style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
        <button type="button" id="toggleFilters" class="btn-jump-pn"
            style="display: flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <span>Filter</span>
            <span id="filterArrow" style="transition: transform 0.2s; font-size: 0.65rem;">▼</span>
        </button>
        <span id="filterCount" style="color: var(--text-muted); font-size: 0.8rem;"></span>
    </div>

    <!-- Collapsible Filter Bar -->
    <div id="filterPanel" class="filter-bar"
        style="display: none; flex-wrap: wrap; gap: 0.75rem; align-items: center; margin-bottom: 1.5rem; padding: 1rem; background: var(--bg-secondary); border-radius: 8px;">

        <!-- Search Registration -->
        <input type="text" id="searchInput" class="form-input" placeholder="Search registration..."
            style="min-width: 200px; max-width: 250px;">

        <select id="filterAirline" class="form-select" style="min-width: 180px; cursor: pointer;">
            <option value="">All Airlines</option>
            @foreach($fleetByAirline as $airlineId => $airline)
                <option value="{{ $airline['name'] }}">{{ $airline['name'] }}</option>
            @endforeach
        </select>

        <select id="filterType" class="form-select" style="min-width: 150px; cursor: pointer;">
            <option value="">All Types</option>
            @php
                $uniqueTypes = collect($fleet)->pluck('type')->unique()->sort();
            @endphp
            @foreach($uniqueTypes as $type)
                <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>

        <select id="filterStatus" class="form-select" style="min-width: 130px; cursor: pointer;">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="prolong">Prolong</option>
        </select>

        <select id="filterHealth" class="form-select" style="min-width: 160px; cursor: pointer;">
            <option value="">All Health</option>
            <option value="critical">🔴 Critical/Expired</option>
            <option value="warning">🟡 Warning</option>
            <option value="safe">🟢 Safe</option>
        </select>

        <button type="button" id="clearFilters" class="btn-jump-pn" style="cursor: pointer; border: none;">Clear</button>
    </div>

    <!-- Summary Section -->
    <section class="summary-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                <h2>Fleet Overview</h2>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <!-- Fleet Multi-Select Dropdown -->
                <div class="fleet-dropdown" style="position: relative;">
                    <button type="button" id="fleetDropdownBtn" class="btn-jump-pn"
                        style="display: flex; align-items: center; gap: 6px; cursor: pointer; border: none;">
                        <span>Filter Fleet</span>
                        <span style="font-size: 0.6em;">▼</span>
                    </button>
                    <div id="fleetDropdownMenu" class="fleet-dropdown-menu">
                        <!-- Select All Option -->
                        <label class="fleet-checkbox-item all-fleets"
                            style="border-bottom: 1px solid var(--border); margin-bottom: 4px; padding-bottom: 8px;">
                            <input type="checkbox" id="fleetCheckAll" class="fleet-checkbox-all" checked>
                            <span class="fleet-name">All Fleets</span>
                        </label>

                        @foreach($perFleetStats as $baseType => $stats)
                            <label class="fleet-checkbox-item">
                                <input type="checkbox" class="fleet-checkbox" checked data-fleet="{{ $baseType }}"
                                    data-safe="{{ $stats['safe'] }}" data-warning="{{ $stats['warning'] }}"
                                    data-critical="{{ $stats['critical'] }}" data-expired="{{ $stats['expired'] }}">
                                <span class="fleet-name">{{ $baseType }}</span>
                                <span class="fleet-count">{{ $stats['count'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Global Expand/Collapse & View Toggle -->
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <div style="display: flex; background: var(--bg-card); border: 1px solid var(--border); border-radius: 6px; overflow: hidden; margin-right: 0.25rem;">
                        <button type="button" onclick="document.body.classList.remove('list-view-active'); this.style.background='var(--primary)'; this.style.color='white'; this.nextElementSibling.style.background='transparent'; this.nextElementSibling.style.color='var(--text-secondary)';" style="background: var(--primary); color: white; border: none; padding: 0.4rem 0.8rem; font-size: 0.85rem; cursor: pointer; transition: 0.2s;">Grid</button>
                        <button type="button" onclick="document.body.classList.add('list-view-active'); this.style.background='var(--primary)'; this.style.color='white'; this.previousElementSibling.style.background='transparent'; this.previousElementSibling.style.color='var(--text-secondary)';" style="background: transparent; color: var(--text-secondary); border: none; padding: 0.4rem 0.8rem; font-size: 0.85rem; cursor: pointer; transition: 0.2s;">List</button>
                    </div>
                    <button type="button" class="btn-jump-pn" onclick="document.querySelectorAll('.fleet-cards').forEach(c => c.style.display = document.body.classList.contains('list-view-active') ? 'flex' : 'grid'); document.querySelectorAll('.collapse-icon').forEach(i => i.style.transform = 'rotate(90deg)');">Expand All</button>
                    <button type="button" class="btn-jump-pn" onclick="document.querySelectorAll('.fleet-cards').forEach(c => c.style.display = 'none'); document.querySelectorAll('.collapse-icon').forEach(i => i.style.transform = 'rotate(0deg)');">Collapse All</button>
                </div>
            </div>
        </div>

        <div class="summary-cards">
            <div class="summary-card safe">
                <div class="summary-icon">🟢</div>
                <div class="summary-value" id="overviewSafe" data-initial="{{ $totalStats['safe'] }}">
                    {{ $totalStats['safe'] }}
                </div>
                <div class="summary-label">Safe</div>
                <div class="summary-desc">> 6 months</div>
            </div>
            <div class="summary-card warning">
                <div class="summary-icon">🟡</div>
                <div class="summary-value" id="overviewWarning" data-initial="{{ $totalStats['warning'] }}">
                    {{ $totalStats['warning'] }}
                </div>
                <div class="summary-label">Warning</div>
                <div class="summary-desc">3-6 months</div>
            </div>
            <div class="summary-card critical">
                <div class="summary-icon">🔴</div>
                <div class="summary-value" id="overviewCritical" data-initial="{{ $totalStats['critical'] }}">
                    {{ $totalStats['critical'] }}
                </div>
                <div class="summary-label">Critical</div>
                <div class="summary-desc">
                    < 3 months</div>
                </div>
                <div class="summary-card expired">
                    <div class="summary-icon">🟣</div>
                    <div class="summary-value" id="overviewExpired" data-initial="{{ $totalStats['expired'] }}">
                        {{ $totalStats['expired'] }}
                    </div>
                    <div class="summary-label">Expired</div>
                    <div class="summary-desc">Past due</div>
                </div>
            </div>
    </section>

    <!-- Airline Master Overview Section -->
    <section class="master-airline-section" id="airline-master-overview" style="display: {{ ($currentView === 'fleet-overview' || $currentView === 'all') ? 'grid' : 'none' }}; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem; margin-top: 1rem;">
        @foreach($fleetByAirline as $airlineId => $airline)
            @php
                $aSafe = 0; $aWarn = 0; $aCrit = 0; $aExp = 0;
                foreach($airline['types'] as $typeGroup) {
                    foreach($typeGroup['aircraft'] as $ac) {
                        $aSafe += $ac['stats']['safe'] ?? 0;
                        $aWarn += $ac['stats']['warning'] ?? 0;
                        $aCrit += $ac['stats']['critical'] ?? 0;
                        $aExp += $ac['stats']['expired'] ?? 0;
                    }
                }
                $aTotal = $aSafe + $aWarn + $aCrit + $aExp;
                $aHealth = $aTotal > 0 ? round((($aSafe + ($aWarn * 0.5)) / $aTotal) * 100) : 100;
            @endphp
            <div class="fleet-card airline-master-card" style="cursor: pointer; padding: 2rem 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; border: 1px solid var(--border-subtle); transition: transform 0.2s, box-shadow 0.2s; background: var(--bg-card); border-radius: 12px; position: relative; overflow: hidden;" onclick="showAirlineDetails('{{ $airline['name'] }}')" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='var(--shadow-lg)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow)';">
                <div style="margin-bottom: 1.5rem;">
                    <h2 style="margin: 0; font-size: 1.6rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.01em;">{{ $airline['name'] }}</h2>
                    <span style="color: var(--text-muted); font-size: 0.9rem;">{{ $airline['code'] }} • {{ $airline['aircraft_count'] }} Aircraft</span>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <div style="font-size: 3rem; font-weight: 800; line-height: 1; color: {{ $aHealth >= 70 ? 'var(--success)' : ($aHealth >= 40 ? 'var(--warning)' : 'var(--danger)') }};">
                        {{ $aHealth }}<span style="font-size: 1.5rem;">%</span>
                    </div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-top: 0.5rem;">Overall Fleet Health</div>
                </div>

                <div style="display: flex; gap: 1rem; font-size: 0.85rem; width: 100%; justify-content: center; margin-bottom: 1.5rem;">
                    <span style="color: var(--success); font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">🟢 {{ $aSafe }}</span>
                    <span style="color: var(--warning); font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">🟡 {{ $aWarn }}</span>
                    <span style="color: var(--danger); font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">🔴 {{ $aCrit }}</span>
                    <span style="color: purple; font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">🟣 {{ $aExp }}</span>
                </div>

                <div style="width: 100%; height: 6px; background: var(--bg); border-radius: 3px; display: flex; overflow: hidden; margin-top: auto;">
                    @if($aTotal > 0)
                        <div style="width: {{ ($aSafe/$aTotal)*100 }}%; background: var(--success); height: 100%;"></div>
                        <div style="width: {{ ($aWarn/$aTotal)*100 }}%; background: var(--warning); height: 100%;"></div>
                        <div style="width: {{ (($aCrit+$aExp)/$aTotal)*100 }}%; background: var(--danger); height: 100%;"></div>
                    @endif
                </div>
            </div>
        @endforeach
    </section>

    <!-- Fleet Details Container -->
    <div id="airline-fleet-details" style="display: none;">
        <!-- Back Button Header -->
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
             <button onclick="hideAirlineDetails()" class="btn-jump-pn" style="background: transparent; border: 1px solid var(--border); color: var(--text-primary); padding: 0.4rem 0.8rem; font-size: 0.9rem;">← Back to Airlines Menu</button>
             <h2 id="airline-details-title" style="margin: 0; font-size: 1.5rem; color: var(--primary);">Airline Fleet Profile</h2>
        </div>

    <!-- Fleet Cards Section - Grouped by Airline then by Type -->
    @foreach($fleetByAirline as $airlineId => $airline)
        <section class="airline-section" data-airline="{{ $airline['name'] }}" style="margin-bottom: 2rem;">
            <div class="airline-header"
                style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border);">
                <div>
                    <h2 style="margin: 0; font-size: 1.35rem; font-weight: 700; letter-spacing: -0.02em;">{{ $airline['name'] }}</h2>
                    <span style="color: var(--text-muted); font-size: 0.8rem;">{{ $airline['code'] }} ·
                        <span class="airline-count">{{ $airline['aircraft_count'] }}</span> aircraft</span>
                </div>
            </div>

            @foreach($airline['types'] as $baseType => $typeGroup)
                <section class="fleet-section" style="margin-left: 0.5rem;">
                    <h3 style="display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.65rem; font-size: 1rem; font-weight: 600; color: var(--text-secondary); cursor: pointer; user-select: none;"
                        onclick="const cards = this.nextElementSibling; const isHidden = cards.style.display==='none'; cards.style.display=isHidden?(document.body.classList.contains('list-view-active')?'flex':'grid'):'none'; this.querySelector('.collapse-icon').style.transform=isHidden?'rotate(90deg)':'rotate(0deg)';">
                        <span class="collapse-icon" style="font-size: 0.7em; transition: transform 0.2s; transform: rotate(0deg); display: inline-block;">▶</span>
                        {{ $typeGroup['icon'] }} {{ $typeGroup['name'] }}
                        <span class="type-count"
                            style="color: var(--text-muted); font-weight: 400; font-size: 0.8rem;">({{ count($typeGroup['aircraft']) }})</span>
                    </h3>
                    <div class="fleet-cards" style="display: none;">
                        @foreach($typeGroup['aircraft'] as $registration => $aircraft)
                            <a href="{{ route('aircraft.show', $registration) }}"
                                class="fleet-card {{ $aircraft['health'] >= 70 ? 'healthy' : ($aircraft['health'] >= 40 ? 'warning' : 'critical') }}"
                                data-status="{{ $aircraft['status'] ?? 'active' }}"
                                data-health="{{ $aircraft['health'] >= 70 ? 'safe' : ($aircraft['health'] >= 40 ? 'warning' : 'critical') }}"
                                data-airline="{{ $airline['name'] }}" data-type="{{ $aircraft['type'] }}">
                                <div class="fleet-card-header">
                                    <div>
                                        <div class="fleet-card-type">
                                            {{ $aircraft['type'] }}
                                            <span class="status-badge {{ $aircraft['status'] ?? 'active' }}">
                                                {{ strtoupper($aircraft['status'] ?? 'active') }}
                                            </span>
                                        </div>
                                        <div class="fleet-card-reg">{{ $registration }}</div>
                                    </div>
                                    <div class="fleet-card-icon">{{ $aircraft['icon'] }}</div>
                                </div>
                                <div class="fleet-card-stats">
                                    <div class="fleet-stat safe">
                                        <div class="fleet-stat-value">{{ $aircraft['stats']['safe'] }}</div>
                                        <div class="fleet-stat-label">Safe</div>
                                    </div>
                                    <div class="fleet-stat warning">
                                        <div class="fleet-stat-value">{{ $aircraft['stats']['warning'] }}</div>
                                        <div class="fleet-stat-label">Warning</div>
                                    </div>
                                    <div class="fleet-stat critical">
                                        <div class="fleet-stat-value">{{ $aircraft['stats']['critical'] }}</div>
                                        <div class="fleet-stat-label">Critical</div>
                                    </div>
                                    <div class="fleet-stat expired">
                                        <div class="fleet-stat-value">{{ $aircraft['stats']['expired'] }}</div>
                                        <div class="fleet-stat-label">Expired</div>
                                    </div>
                                </div>
                                <div class="fleet-card-progress">
                                    @php
                                        $total = array_sum($aircraft['stats']) ?: 1;
                                    @endphp
                                    <div class="progress-bar">
                                        <div class="progress-segment safe"
                                            style="width: {{ ($aircraft['stats']['safe'] / $total) * 100 }}%"></div>
                                        <div class="progress-segment warning"
                                            style="width: {{ ($aircraft['stats']['warning'] / $total) * 100 }}%"></div>
                                        <div class="progress-segment critical"
                                            style="width: {{ ($aircraft['stats']['critical'] / $total) * 100 }}%"></div>
                                        <div class="progress-segment expired"
                                            style="width: {{ ($aircraft['stats']['expired'] / $total) * 100 }}%"></div>
                                        <div class="progress-segment no-data"
                                            style="width: {{ ($aircraft['stats']['no_data'] / $total) * 100 }}%"></div>
                                    </div>
                                </div>
                                <div class="fleet-card-footer">
                                    <span
                                        class="health-score {{ $aircraft['health'] >= 70 ? 'good' : ($aircraft['health'] >= 40 ? 'medium' : 'bad') }}">
                                        {{ $aircraft['health'] }}% Health
                                    </span>
                                    <span class="fleet-card-action">Open →</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </section>
    @endforeach

    <div class="airline-section" style="text-align: center; margin-top: 2rem; margin-bottom: 2rem; width: 100%;">
        <a href="#" onclick="document.querySelector('.dashboard-content').scrollTo({top: 0, behavior: 'smooth'}); return false;" class="btn-jump-pn" style="display: inline-block; padding: 0.5rem 1.5rem;">Back to Top ↑</a>
    </div>
    
    </div> <!-- End Fleet Details Container -->

    <!-- Life Vest Replacement Summary -->
    @if(count($pnSummary) > 0)
        <section class="replacement-section" id="life-vest-summary-section">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Life Vest Replacement Summary</h2>
            </div>
            <div class="replacement-grid">
                @foreach($pnSummary as $idx => $item)
                    @php
                        $hasAttention = $item['expired'] > 0 || $item['critical'] > 0 || $item['warning'] > 0;
                    @endphp
                    <div class="replacement-card {{ $hasAttention ? 'has-expired' : 'all-good' }}">
                        <div class="replacement-header">
                            <div>
                                <span class="replacement-pn">{{ $item['pn'] }}</span>
                                <span
                                    class="replacement-category {{ $item['category'] }}">{{ strtoupper($item['category']) }}</span>
                            </div>
                            <div class="replacement-counts">
                                <span class="replacement-total">{{ $item['total'] }} total</span>
                            </div>
                        </div>

                        {{-- Clickable status badges (act as filter tabs) --}}
                        <div class="replacement-badges">
                            @if($item['expired'] > 0)
                                <span class="badge-btn badge-expired {{ $item['expired'] > 0 ? 'active' : '' }}" data-tab="expired"
                                    data-card="{{ $idx }}">🟣 {{ $item['expired'] }} expired</span>
                            @endif
                            @if($item['critical'] > 0)
                                <span
                                    class="badge-btn badge-critical {{ $item['expired'] == 0 && $item['critical'] > 0 ? 'active' : '' }}"
                                    data-tab="critical" data-card="{{ $idx }}">🔴 {{ $item['critical'] }} critical</span>
                            @endif
                            @if($item['warning'] > 0)
                                <span
                                    class="badge-btn badge-warning {{ $item['expired'] == 0 && $item['critical'] == 0 && $item['warning'] > 0 ? 'active' : '' }}"
                                    data-tab="warning" data-card="{{ $idx }}">🟡 {{ $item['warning'] }} warning</span>
                            @endif
                            @if(!$hasAttention)
                                <span class="replacement-ok">✅ All safe</span>
                            @endif
                        </div>

                        {{-- Breakdowns --}}
                        @if(count($item['aircraft']) > 0)
                            <div class="replacement-breakdown" data-card="{{ $idx }}" data-type="expired"
                                style="{{ $item['expired'] > 0 ? '' : 'display:none' }}">
                                @foreach($item['aircraft'] as $ac)
                                    @if($ac['expired'] > 0)
                                        <span class="breakdown-item bd-expired">{{ $ac['reg'] }}: {{ $ac['expired'] }}</span>
                                    @endif
                                @endforeach
                            </div>

                            <div class="replacement-breakdown" data-card="{{ $idx }}" data-type="critical"
                                style="{{ $item['expired'] == 0 && $item['critical'] > 0 ? '' : 'display:none' }}">
                                @foreach($item['aircraft'] as $ac)
                                    @if($ac['critical'] > 0)
                                        <span class="breakdown-item bd-critical">{{ $ac['reg'] }}: {{ $ac['critical'] }}</span>
                                    @endif
                                @endforeach
                            </div>

                            <div class="replacement-breakdown" data-card="{{ $idx }}" data-type="warning"
                                style="{{ $item['expired'] == 0 && $item['critical'] == 0 && $item['warning'] > 0 ? '' : 'display:none' }}">
                                @foreach($item['aircraft'] as $ac)
                                    @if($ac['warning'] > 0)
                                        <span class="breakdown-item bd-warning">{{ $ac['reg'] }}: {{ $ac['warning'] }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Replacement Plans -->
    @if(isset($replacementPlans))
        @foreach(['weekly', 'monthly', 'yearly'] as $interval)
            @php
                $plan = $replacementPlans[$interval];
                $titleText = ucfirst($interval) . ' Replacement Plan';
                $subtitleText = 'Timeline kebutuhan penggantian life vest per ' . ($interval === 'weekly' ? 'minggu' : ($interval === 'monthly' ? 'bulan' : 'tahun'));
                $isPlanVisible = ($currentView === 'replacement-'.$interval);
            @endphp
            @if(count($plan) > 0)
                <section class="replacement-section replacement-interval-section stats-section" data-interval="{{ $interval }}" id="replacement-{{ $interval }}-plan" style="display: {{ $isPlanVisible ? 'block' : 'none' }}">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <h2>{{ $titleText }}</h2>
                            <span class="monthly-plan-subtitle">{{ $subtitleText }}</span>
                        </div>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <a href="{{ route('reports.excel') }}" class="btn-jump-success" title="Download Excel Report">
                                Export Excel
                            </a>
                            <button type="button" class="btn-jump-pn toggleAllPlanBtn" data-interval="{{ $interval }}" style="cursor: pointer;">Expand All</button>
                        </div>
                    </div>

                    {{-- Grand Total Summary --}}
                    @php
                        $grandTotal = collect($plan)->sum('total');
                        $overdueTotal = isset($plan['overdue']) ? $plan['overdue']['total'] : 0;
                    @endphp
                    <div class="monthly-grand-summary">
                        <div class="monthly-grand-item">
                            <span class="monthly-grand-value">{{ $grandTotal }}</span>
                            <span class="monthly-grand-label">Total Life Vests</span>
                        </div>
                        <div class="monthly-grand-item overdue">
                            <span class="monthly-grand-value">{{ $overdueTotal }}</span>
                            <span class="monthly-grand-label">Overdue</span>
                        </div>
                        <div class="monthly-grand-item">
                            <span class="monthly-grand-value">{{ count($plan) - (isset($plan['overdue']) ? 1 : 0) }}</span>
                            <span class="monthly-grand-label">Periods Ahead</span>
                        </div>
                    </div>

                    {{-- Timeline --}}
                    <div class="monthly-timeline" id="timeline-{{$interval}}">
                        @foreach($plan as $bucketKey => $bucket)
                            <div class="monthly-card {{ $bucket['urgency'] }}" data-month="{{ $bucketKey }}">
                                {{-- Header (clickable) --}}
                                <div class="monthly-card-header" onclick="toggleMonth('{{ $interval }}-{{ $bucketKey }}')">
                                    <div class="monthly-card-left">
                                        <span class="monthly-urgency-dot {{ $bucket['urgency'] }}"></span>
                                        <div>
                                            <div class="monthly-card-title">
                                                {{ $bucket['label'] }}
                                                @if($bucket['urgency'] === 'overdue')
                                                    <span class="monthly-badge overdue">OVERDUE</span>
                                                @elseif($bucket['urgency'] === 'critical')
                                                    <span class="monthly-badge critical">CRITICAL</span>
                                                @elseif($bucket['urgency'] === 'warning')
                                                    <span class="monthly-badge warning">WARNING</span>
                                                @endif
                                                @if($bucket['isCurrentMonth'] ?? false)
                                                    <span class="monthly-badge current-month">CURRENT PERIOD</span>
                                                @endif
                                            </div>
                                            <div class="monthly-card-meta">
                                                {{ count($bucket['pn_breakdown']) }} Part Number(s) • {{ count($bucket['aircraft_breakdown']) }} Aircraft
                                            </div>
                                        </div>
                                    </div>
                                    <div class="monthly-card-right">
                                        <span class="monthly-card-total">{{ $bucket['total'] }}</span>
                                        <span class="monthly-card-unit">vests</span>
                                        <span class="monthly-card-arrow" id="arrow-{{ $interval }}-{{ $bucketKey }}">▼</span>
                                    </div>
                                </div>

                                {{-- Detail (collapsible) --}}
                                <div class="monthly-card-body" id="body-{{ $interval }}-{{ $bucketKey }}" style="display: none;">
                                    {{-- P/N Breakdown --}}
                                    @foreach($bucket['pn_breakdown'] as $pnKey => $pnData)
                                        <div class="monthly-pn-row">
                                            <div class="monthly-pn-header" onclick="togglePnDetails('{{ $interval }}-{{ $bucketKey }}-{{ str_replace('|', '-', $pnKey) }}'); event.stopPropagation();">
                                                <div style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; flex: 1;">
                                                    <span class="monthly-pn-toggle" id="toggle-{{ $interval }}-{{ $bucketKey }}-{{ str_replace('|', '-', $pnKey) }}">▶</span>
                                                    <div class="monthly-pn-info">
                                                        <span class="monthly-pn-name">{{ $pnData['pn'] }}</span>
                                                        <span class="monthly-pn-category {{ $pnData['category'] }}">{{ strtoupper($pnData['category']) }}</span>
                                                    </div>
                                                </div>
                                                <span class="monthly-pn-count">× {{ $pnData['count'] }}</span>
                                            </div>
                                            <div class="monthly-aircraft-list" id="details-{{ $interval }}-{{ $bucketKey }}-{{ str_replace('|', '-', $pnKey) }}" style="display: none;">
                                                @foreach($pnData['aircraft'] as $reg => $count)
                                                    <a href="{{ route('aircraft.show', $reg) }}" class="monthly-aircraft-chip" title="Open {{ $reg }}">
                                                        {{ $reg }}: {{ $count }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Aircraft Summary --}}
                                    <div class="monthly-aircraft-summary">
                                        <div class="monthly-aircraft-summary-title">Aircraft Summary:</div>
                                        <div class="monthly-aircraft-summary-list">
                                            @foreach($bucket['aircraft_breakdown'] as $reg => $acData)
                                                <a href="{{ route('aircraft.show', $reg) }}" class="monthly-ac-summary-chip">
                                                    <span class="monthly-ac-reg">{{ $reg }}</span>
                                                    <span class="monthly-ac-type">{{ $acData['type'] }}</span>
                                                    <span class="monthly-ac-count">{{ $acData['count'] }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach
        
        {{-- Map specific data for Excel export function (Currently Monthly, as default) --}}
        <script>
            window.monthlyPlanData = @json($replacementPlans['monthly'] ?? []);
        </script>
    @endif

    <!-- Quick Stats -->
    <section class="stats-section" id="quick-stats">
        <h2>Quick Stats</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ count($fleetByAirline) }}</div>
                <div class="stat-label">Airlines</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ count($fleet) }}</div>
                <div class="stat-label">Aircraft</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ array_sum($totalStats) }}</div>
                <div class="stat-label">Total Seats Tracked</div>
            </div>
            <div class="stat-item">
                @php
                    $totalTracked = $totalStats['safe'] + $totalStats['warning'] + $totalStats['critical'] + $totalStats['expired'];
                    $healthScore = $totalTracked > 0 ? round(($totalStats['safe'] / $totalTracked) * 100) : 0;
                @endphp
                <div class="stat-value">{{ $healthScore }}%</div>
                <div class="stat-label">Health Score</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $totalStats['critical'] + $totalStats['expired'] }}</div>
                <div class="stat-label">Needs Attention</div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Fleet Overview Multi-Select Logic
            const fleetCheckboxes = document.querySelectorAll('.fleet-checkbox');
            const checkAllBox = document.getElementById('fleetCheckAll');
            const overviewSafe = document.getElementById('overviewSafe');
            const overviewWarning = document.getElementById('overviewWarning');
            const overviewCritical = document.getElementById('overviewCritical');
            const overviewExpired = document.getElementById('overviewExpired');

            // Initial totals (all checked by default or none checked = all)
            const initialStats = {
                safe: parseInt(overviewSafe.dataset.initial),
                warning: parseInt(overviewWarning.dataset.initial),
                critical: parseInt(overviewCritical.dataset.initial),
                expired: parseInt(overviewExpired.dataset.initial)
            };

            function updateOverview() {
                let totalSafe = 0, totalWarning = 0, totalCritical = 0, totalExpired = 0;
                let checkedCount = 0;

                fleetCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        checkedCount++;
                        totalSafe += parseInt(cb.dataset.safe);
                        totalWarning += parseInt(cb.dataset.warning);
                        totalCritical += parseInt(cb.dataset.critical);
                        totalExpired += parseInt(cb.dataset.expired);
                    }
                });

                // If nothing checked, show ALL (or show 0? Usually "All" is better UX, but let's stick to selection)
                // Let's make it: if nothing checked -> Show 0 (or revert to All? Let's revert to All for better UX)
                if (!checkedCount) { // Changed from !anyChecked to !checkedCount
                    totalSafe = initialStats.safe;
                    totalWarning = initialStats.warning;
                    totalCritical = initialStats.critical;
                    totalExpired = initialStats.expired;
                }

                // Update "Check All" state
                if (checkAllBox) {
                    checkAllBox.checked = (checkedCount === fleetCheckboxes.length);
                    checkAllBox.indeterminate = (checkedCount > 0 && checkedCount < fleetCheckboxes.length);
                }

                overviewSafe.textContent = totalSafe;
                overviewWarning.textContent = totalWarning;
                overviewCritical.textContent = totalCritical;
                overviewExpired.textContent = totalExpired;

                // Simple animation
                [overviewSafe, overviewWarning, overviewCritical, overviewExpired].forEach(el => {
                    el.style.transform = 'scale(1.15)';
                    setTimeout(() => el.style.transform = 'scale(1)', 200);
                });
            }

            // "Check All" Event Listener
            checkAllBox?.addEventListener('change', function () {
                const isChecked = this.checked;
                fleetCheckboxes.forEach(cb => {
                    cb.checked = isChecked;
                });
                updateOverview();
            });

            // Individual Checkbox Listener
            fleetCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateOverview);
            });

            // Initial update to set correct state for "Check All" and overview totals
            updateOverview();

            // Toggle Dropdown
            const dropdownBtn = document.getElementById('fleetDropdownBtn');
            const dropdownMenu = document.getElementById('fleetDropdownMenu');

            dropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
                if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
            const toggleBtn = document.getElementById('toggleFilters');
            const filterPanel = document.getElementById('filterPanel');
            const filterArrow = document.getElementById('filterArrow');
            const filterAirline = document.getElementById('filterAirline');
            const filterType = document.getElementById('filterType');
            const filterStatus = document.getElementById('filterStatus');
            const filterHealth = document.getElementById('filterHealth');
            const searchInput = document.getElementById('searchInput');
            const clearBtn = document.getElementById('clearFilters');
            const filterCount = document.getElementById('filterCount');

            const cards = Array.from(document.querySelectorAll('.fleet-card'));
            const airlineSections = Array.from(document.querySelectorAll('.airline-section'));
            const fleetSections = Array.from(document.querySelectorAll('.fleet-section'));

            // Toggle filter panel
            toggleBtn?.addEventListener('click', function () {
                const isHidden = filterPanel.style.display === 'none';
                filterPanel.style.display = isHidden ? 'flex' : 'none';
                filterArrow.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
            });

            function applyFilters() {
                const airlineFilter = filterAirline?.value || '';
                const typeFilter = filterType?.value || '';
                const statusFilter = filterStatus?.value || '';
                const healthFilter = filterHealth?.value || '';
                const searchQuery = (searchInput?.value || '').toLowerCase().trim();

                let visibleCount = 0;
                const totalCount = cards.length;

                cards.forEach(card => {
                    const cardAirline = card.dataset.airline || '';
                    const cardType = card.dataset.type || '';
                    const cardStatus = card.dataset.status || '';
                    const cardHealth = card.dataset.health || '';
                    // Get registration from the card (looking for fleet-card-reg class)
                    const cardRegElement = card.querySelector('.fleet-card-reg');
                    const cardReg = (cardRegElement?.textContent || '').toLowerCase();

                    let show = true;

                    // Registration search filter
                    if (searchQuery && !cardReg.includes(searchQuery)) {
                        show = false;
                    }

                    // Airline filter
                    if (airlineFilter && cardAirline !== airlineFilter) {
                        show = false;
                    }

                    // Type filter
                    if (typeFilter && cardType !== typeFilter) {
                        show = false;
                    }

                    // Status filter
                    if (statusFilter && cardStatus !== statusFilter) {
                        show = false;
                    }

                    // Health filter
                    if (healthFilter && cardHealth !== healthFilter) {
                        show = false;
                    }

                    card.style.display = show ? '' : 'none';
                    if (show) visibleCount++;
                });

                // Hide empty fleet sections (type groups)
                const hasFilters = (airlineFilter || typeFilter || statusFilter || healthFilter || searchQuery) !== '';
                fleetSections.forEach(section => {
                    const visibleCards = section.querySelectorAll('.fleet-card:not([style*="display: none"])');
                    section.style.display = visibleCards.length > 0 ? '' : 'none';

                    // Update type count
                    const typeCount = section.querySelector('.type-count');
                    if (typeCount) {
                        typeCount.textContent = `(${visibleCards.length})`;
                    }
                    
                    // Auto Expand if filtered
                    const cardsContainer = section.querySelector('.fleet-cards');
                    const headerIcon = section.querySelector('.collapse-icon');
                    if (cardsContainer && headerIcon && hasFilters) {
                        cardsContainer.style.display = 'grid';
                        headerIcon.style.transform = 'rotate(90deg)';
                    }
                });

                // Hide empty airline sections
                airlineSections.forEach(section => {
                    const visibleCards = section.querySelectorAll('.fleet-card:not([style*="display: none"])');
                    section.style.display = visibleCards.length > 0 ? '' : 'none';

                    // Update airline count
                    const airlineCount = section.querySelector('.airline-count');
                    if (airlineCount) {
                        airlineCount.textContent = visibleCards.length;
                    }
                });

                // Update filter count display
                if (airlineFilter || typeFilter || statusFilter || healthFilter || searchQuery) {
                    filterCount.textContent = `Showing ${visibleCount} of ${totalCount} aircraft`;
                } else {
                    filterCount.textContent = '';
                }
            }

            function updateTypeDropdown() {
                const selectedAirline = filterAirline?.value || '';
                const currentSelectedType = filterType?.value || '';
                
                // Get all valid types for the selected airline
                const validTypes = new Set();
                cards.forEach(card => {
                    const cardAirline = card.dataset.airline || '';
                    const cardType = card.dataset.type || '';
                    if (!selectedAirline || cardAirline === selectedAirline) {
                        if (cardType) validTypes.add(cardType);
                    }
                });
                
                // Update dropdown options
                if (filterType) {
                    // Keep the first option "All Types"
                    while (filterType.options.length > 1) {
                        filterType.remove(1);
                    }
                    
                    // Populate with valid types, sorted alphabetically
                    Array.from(validTypes).sort().forEach(type => {
                        const option = document.createElement('option');
                        option.value = type;
                        option.textContent = type;
                        filterType.appendChild(option);
                    });
                    
                    // Maintain previous selection if still valid, otherwise reset
                    if (validTypes.has(currentSelectedType)) {
                        filterType.value = currentSelectedType;
                    } else {
                        filterType.value = '';
                    }
                }
            }

            // Event listeners
            filterAirline?.addEventListener('change', function() {
                updateTypeDropdown();
                applyFilters();
            });
            filterType?.addEventListener('change', applyFilters);
            filterStatus?.addEventListener('change', applyFilters);
            filterHealth?.addEventListener('change', applyFilters);
            searchInput?.addEventListener('input', applyFilters); // Real-time search

            clearBtn?.addEventListener('click', function () {
                if (filterAirline) filterAirline.value = '';
                if (filterType) filterType.value = '';
                if (filterStatus) filterStatus.value = '';
                if (filterHealth) filterHealth.value = '';
                if (searchInput) searchInput.value = '';
                updateTypeDropdown(); // Ensure dropdown options reset
                applyFilters();
            });

            // Replacement Summary - Clickable Badge Filtering
            document.querySelectorAll('.badge-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const cardIdx = this.dataset.card;
                    const tab = this.dataset.tab;

                    // Toggle active badge
                    document.querySelectorAll(`.badge-btn[data-card="${cardIdx}"]`).forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Toggle breakdown visibility
                    document.querySelectorAll(`.replacement-breakdown[data-card="${cardIdx}"]`).forEach(bd => {
                        bd.style.display = bd.dataset.type === tab ? '' : 'none';
                    });
                });
            });

            // Replacement Plan - Toggle All
            document.querySelectorAll('.toggleAllPlanBtn').forEach(toggleBtn => {
                let allExpanded = false;
                toggleBtn.addEventListener('click', function() {
                    const interval = this.dataset.interval;
                    const section = document.getElementById(`timeline-${interval}`);
                    
                    allExpanded = !allExpanded;
                    section.querySelectorAll('.monthly-card-body').forEach(body => {
                        body.style.display = allExpanded ? 'block' : 'none';
                    });
                    section.querySelectorAll('.monthly-card-arrow').forEach(arrow => {
                        arrow.style.transform = allExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
                    });
                    section.querySelectorAll('.monthly-card').forEach(card => {
                        if (allExpanded) {
                            card.classList.add('expanded');
                        } else {
                            card.classList.remove('expanded');
                        }
                    });
                    this.textContent = allExpanded ? 'Collapse All' : 'Expand All';
                });
            });

            // SPA-like tab switching for instantaneous load times between Dashboard views
            const sidebarLinks = document.querySelectorAll('.sidebar-nav-item');
            
            sidebarLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    // Check if the link points to the dashboard
                    const isDashboardLink = link.href.includes('view=') && (link.href.includes('/dashboard') || link.href.includes('localhost') || link.href.includes('127.0.0.1'));
                    if (isDashboardLink) {
                        try {
                            const url = new URL(link.href);
                            const targetView = url.searchParams.get('view') || 'fleet-overview';
                            
                            // Only handle the dashboard views
                            if (['fleet-overview', 'life-vest-summary', 'replacement-weekly', 'replacement-monthly', 'replacement-yearly', 'all'].includes(targetView)) {
                                const currentUrl = new URL(window.location.href);
                                const currentView = currentUrl.searchParams.get('view') || 'fleet-overview';
                                
                                // Prevent full page reload
                                e.preventDefault();
                                
                                if (targetView !== currentView) {
                                    // Change the URL without reloading
                                    history.pushState(null, '', url.href);
                                    
                                    // Update active styling on sidebar
                                    sidebarLinks.forEach(l => l.classList.remove('active'));
                                    // Notice: we also need to activate the parent 'Replacement Plan' if a submenu is clicked
                                    if (targetView.startsWith('replacement-')) {
                                        const parentDropdownMenu = link.closest('.dropdown-submenu');
                                        if (parentDropdownMenu) {
                                            const toggleBtn = parentDropdownMenu.previousElementSibling;
                                            if (toggleBtn) toggleBtn.classList.add('active');
                                        }
                                    }
                                    link.classList.add('active');
                                    
                                    // Toggle sections
                                    document.querySelectorAll('.summary-section').forEach(el => {
                                        el.style.display = (targetView === 'fleet-overview' || targetView === 'all') ? 'block' : 'none';
                                    });
                                    document.querySelectorAll('.airline-section').forEach(el => {
                                        el.style.display = targetView === 'all' ? 'block' : '';
                                    });
                                    
                                    if (targetView === 'fleet-overview') {
                                        hideAirlineDetails(); // Return to master deck when clicking sidebar 'Fleet Overview'
                                    } else {
                                        document.getElementById('airline-master-overview').style.display = 'none';
                                        document.getElementById('airline-fleet-details').style.display = 'none';
                                        if (targetView === 'all') {
                                            document.getElementById('airline-fleet-details').style.display = 'block';
                                        }
                                    }
                                    document.querySelectorAll('#life-vest-summary-section').forEach(el => {
                                        el.style.display = (targetView === 'life-vest-summary' || targetView === 'all') ? 'block' : 'none';
                                    });
                                    // Toggle Replacement Plan sections
                                    document.querySelectorAll('.replacement-interval-section').forEach(el => {
                                        const planInterval = 'replacement-' + el.dataset.interval;
                                        el.style.display = (targetView === planInterval || targetView === 'all') ? 'block' : 'none';
                                    });
                                    document.querySelectorAll('.stats-section').forEach(el => {
                                        el.style.display = (targetView.startsWith('replacement-') || targetView === 'all') ? 'block' : 'none';
                                    });
                                    
                                    // Scroll behavior for a fresh feel
                                    window.scrollTo({top: 0, behavior: 'instant'});
                                }
                            }
                        } catch(err) {
                            console.error('Routing error:', err);
                        }
                    }
                });
            });
            
            // Handle browser back/forward buttons
            window.addEventListener('popstate', (e) => {
                const url = new URL(window.location.href);
                if (url.pathname === '/' || url.pathname.includes('dashboard')) {
                    const targetView = url.searchParams.get('view') || 'fleet-overview';
                    
                    // Update active styling on sidebar
                    sidebarLinks.forEach(l => {
                        l.classList.remove('active');
                        if (l.href.includes(`view=${targetView}`)) {
                            l.classList.add('active');
                        }
                    });
                    
                    // Toggle sections
                    document.querySelectorAll('.summary-section, .airline-section').forEach(el => {
                        el.style.display = (targetView === 'fleet-overview' || targetView === 'all') ? 'block' : 'none';
                    });
                    document.querySelectorAll('#life-vest-summary-section').forEach(el => {
                        // Re-add id strictly to life-vest-summary if it was using replacement-section previously
                        el.style.display = (targetView === 'life-vest-summary' || targetView === 'all') ? 'block' : 'none';
                    });
                    document.querySelectorAll('.replacement-interval-section').forEach(el => {
                        const planInterval = 'replacement-' + el.dataset.interval;
                        el.style.display = (targetView === planInterval || targetView === 'all') ? 'block' : 'none';
                    });
                    document.querySelectorAll('.stats-section').forEach(el => {
                        el.style.display = (targetView.startsWith('replacement-') || targetView === 'all') ? 'block' : 'none';
                    });
                }
            });



            /*
            // Auto-expand overdue and critical (Disabled by user request)
            document.querySelectorAll('.monthly-card.overdue, .monthly-card.critical').forEach(card => {
                const monthKey = card.dataset.month;
                const body = document.getElementById('body-' + monthKey);
                const arrow = document.getElementById('arrow-' + monthKey);
                if (body) {
                    body.style.display = 'block';
                    card.classList.add('expanded');
                }
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            });
            */
        });

        // Monthly Plan - Toggle individual month (must be global function for onclick)
        function toggleMonth(monthKey) {
            const body = document.getElementById('body-' + monthKey);
            const arrow = document.getElementById('arrow-' + monthKey);
            const card = document.querySelector(`.monthly-card[data-month="${monthKey}"]`);

            if (body) {
                const isHidden = body.style.display === 'none';
                body.style.display = isHidden ? 'block' : 'none';
                if (card) card.classList.toggle('expanded', isHidden);
                if (arrow) arrow.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        }

        // Monthly Plan - Toggle P/N details within month
        function togglePnDetails(pnId) {
            const detailsEl = document.getElementById('details-' + pnId);
            const toggleEl = document.getElementById('toggle-' + pnId);

            if (detailsEl) {
                const isHidden = detailsEl.style.display === 'none';
                detailsEl.style.display = isHidden ? 'block' : 'none';
                if (toggleEl) toggleEl.style.transform = isHidden ? 'rotate(90deg)' : 'rotate(0deg)';
            }
        }


        function showAirlineDetails(airlineName) {
            document.getElementById('airline-master-overview').style.display = 'none';
            document.getElementById('airline-fleet-details').style.display = 'block';
            document.getElementById('airline-details-title').textContent = airlineName + ' Fleet Profile';
            
            // Set the dropdown to target airline to trigger standard filtering
            const filterAirline = document.getElementById('filterAirline');
            if(filterAirline) {
                filterAirline.value = airlineName;
                filterAirline.dispatchEvent(new Event('change'));
            }
            
            // Re-collapse all types locally so they don't auto expand from the airlineFilter
            document.querySelector('#airline-fleet-details').querySelectorAll('.fleet-cards').forEach(c => c.style.display = 'none'); 
            document.querySelector('#airline-fleet-details').querySelectorAll('.collapse-icon').forEach(i => i.style.transform = 'rotate(0deg)');
            
            // View toggles handles display updates
            
            // Scroll to top
            document.querySelector('.dashboard-content').scrollTo({top: 0, behavior: 'smooth'});
        }

        function hideAirlineDetails() {
            document.getElementById('airline-master-overview').style.display = 'grid';
            document.getElementById('airline-fleet-details').style.display = 'none';
            
            // Reset airline filter to ALL
            const filterAirline = document.getElementById('filterAirline');
            if(filterAirline) {
                filterAirline.value = '';
                filterAirline.dispatchEvent(new Event('change'));
            }
            
            // Auto collapse internally
            document.querySelector('#airline-fleet-details').querySelectorAll('.fleet-cards').forEach(c => c.style.display = 'none'); 
            document.querySelector('#airline-fleet-details').querySelectorAll('.collapse-icon').forEach(i => i.style.transform = 'rotate(0deg)');
            
            document.querySelector('.dashboard-content').scrollTo({top: 0, behavior: 'smooth'});
        }
    </script>
@endpush