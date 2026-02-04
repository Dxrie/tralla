@extends('layouts.app')

@section('title', 'Dashboard • Tralla')

@section('content')
<div class="row g-4">
    {{-- Welcome Section --}}
    <div class="col-12">
        <div class="bg-white rounded-3 shadow-sm p-4">
            <h1 class="h3 mb-0">Welcome back, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-muted mb-0">{{ date('l, F j, Y') }}</p>
        </div>
    </div>

    @if(Auth::user()->role === 'employer')
        {{-- Employer Dashboard --}}
        
        {{-- Entry Activities (absen masuk) Statistic --}}
        <div class="col-lg-6"> 
            <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Today's Check-ins</h5>
                    <span class="badge bg-primary rounded-pill">{{ $presentToday }}/{{ $totalEmployees }}</span>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="card border-0 bg-success bg-opacity-10">
                            <div class="card-body text-center">
                                <h2 class="text-success mb-1">{{ $onTimeToday ?? 0 }}</h2>
                                <p class="text-muted mb-0 small">On Time</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 bg-danger bg-opacity-10">
                            <div class="card-body text-center">
                                <h2 class="text-danger mb-1">{{ $lateToday ?? 0 }}</h2>
                                <p class="text-muted mb-0 small">Late</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="mb-3">Recent Check-ins</h6>
                    <div class="list-group list-group-flush">
                        @forelse($todaysEntries->take(5) as $entry)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $entry->user->name }}</h6>
                                        <small class="text-muted">{{ $entry->created_at->format('H:i') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $entry->status == 'ontime' ? 'success' : 'danger' }}">
                                        {{ ucfirst($entry->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center mb-0">No check-ins yet today</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Exit Activities (absen pulang) Statistic --}}
        <div class="col-lg-6">
            <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Today's Check-outs</h5>
                    <span class="badge bg-info rounded-pill">{{ $todaysExits->count() }}/{{ $totalEmployees }}</span>
                </div>
                
                <div class="d-flex justify-content-center align-items-center mb-4" style="height: 120px;">
                    <div class="position-relative">
                        <div class="circular-progress" 
                                data-percentage="{{ $totalEmployees > 0 ? round(($todaysExits->count() / $totalEmployees) * 100) : 0 }}">
                            <span class="progress-value">{{ $totalEmployees > 0 ? round(($todaysExits->count() / $totalEmployees) * 100) : 0 }}%</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="mb-3">Recent Check-outs</h6>
                    <div class="list-group list-group-flush">
                        @forelse($todaysExits->take(5) as $exit)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $exit->user->name }}</h6>
                                        <small class="text-muted">{{ $exit->created_at->format('H:i') }}</small>
                                    </div>
                                    <span class="badge bg-info">Checked out</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center mb-0">No check-outs yet today</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Pending Absences & Summary --}}
        <div class="col-12">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                        <h5 class="mb-4">Pending Absence Requests</h5>
                        @if($pendingAbsents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Detail</th>
                                            <th>Submitted</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingAbsents as $absent)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-3">
                                                            <div class="avatar-title bg-light rounded-circle">
                                                                {{ substr($absent->user->name, 0, 1) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $absent->user->name }}</h6>
                                                            <small class="text-muted">{{ $absent->user->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ Str::limit($absent->detail, 50) }}</td>
                                                <td>{{ $absent->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-success">Approve</button>
                                                        <button class="btn btn-outline-danger">Reject</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-check-circle display-4 text-success"></i>
                                <p class="text-muted mt-3">No pending absence requests</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                        <h5 class="mb-4">Today's Summary</h5>
                        <div class="d-grid gap-3">
                            <div class="d-flex justify-content-between align-items-center p-3 rounded bg-light">
                                <div>
                                    <h6 class="mb-0">Present</h6>
                                    <small class="text-muted">Employees at work</small>
                                </div>
                                <h4 class="mb-0 text-success">{{ $presentToday }}</h4>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 rounded bg-light">
                                <div>
                                    <h6 class="mb-0">Absent</h6>
                                    <small class="text-muted">Not checked in</small>
                                </div>
                                <h4 class="mb-0 text-danger">{{ $absentToday }}</h4>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 rounded bg-light">
                                <div>
                                    <h6 class="mb-0">Checked Out</h6>
                                    <small class="text-muted">Left for today</small>
                                </div>
                                <h4 class="mb-0 text-info">{{ $todaysExits->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    @else
        {{-- Employee Dashboard --}}
        
        {{-- Today's Status --}}
        <div class="col-lg-6">
            <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                <h5 class="mb-4">Today's Status</h5>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <div class="text-center p-3 rounded bg-light">
                            <i class="bi bi-box-arrow-in-right display-6 text-primary mb-2"></i>
                            <h4 class="mb-1">
                                @if($todaysEntries->count() > 0)
                                    {{ $todaysEntries->first()->created_at->format('H:i') }}
                                @else
                                    --
                                @endif
                            </h4>
                            <p class="text-muted mb-0">Absen Masuk</p>
                            @if($todaysEntries->count() > 0)
                                <span class="badge bg-{{ $todaysEntries->first()->status == 'ontime' ? 'success' : 'danger' }}">
                                    {{ ucfirst($todaysEntries->first()->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h-100 text-center p-3 rounded bg-light">
                            <i class="bi bi-box-arrow-right display-6 text-primary mb-2"></i>
                            <h4 class="mb-1">
                                @if($todaysExits->count() > 0)
                                    {{ $todaysExits->first()->created_at->format('H:i') }}
                                @else
                                    --
                                @endif
                            </h4>
                            <p class="text-muted mb-0">Absen Pulang</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('absensi.masuk') }}" class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Absen Masuk
                    </a>
                    <a href="{{ route('absensi.keluar') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-box-arrow-right me-2"></i>Absen Pulang
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Monthly Statistics --}}
        <div class="col-lg-6">
            <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                <h5 class="mb-4">This Month's Performance</h5>
                
                <div class="row text-center mb-4">
                    <div class="col-6">
                        <div class="p-3">
                            <div class="display-6 text-success mb-2">{{ $onTimeThisMonth ?? 0 }}</div>
                            <p class="text-muted mb-0">On Time Days</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3">
                            <div class="display-6 text-danger mb-2">{{ $lateThisMonth ?? 0 }}</div>
                            <p class="text-muted mb-0">Late Days</p>
                        </div>
                    </div>
                </div>
                
                <div class="progress mb-3" style="height: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" 
                            style="width: {{ ($onTimeThisMonth + $lateThisMonth) > 0 ? ($onTimeThisMonth / ($onTimeThisMonth + $lateThisMonth)) * 100 : 0 }}%">
                    </div>
                </div>
                <p class="text-center text-muted small">
                    On-time rate: {{ ($onTimeThisMonth + $lateThisMonth) > 0 ? round(($onTimeThisMonth / ($onTimeThisMonth + $lateThisMonth)) * 100) : 0 }}%
                </p>
            </div>
        </div>
        
        {{-- Pending Absences & Quick Actions --}}
        <div class="col-12">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                        <h5 class="mb-4">My Absence Requests</h5>
                        @if($pendingAbsents->count() > 0)
                            <div class="list-group">
                                @foreach($pendingAbsents as $absent)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Absence Request</h6>
                                                <p class="mb-1 text-muted">{{ $absent->detail }}</p>
                                                <small class="text-muted">Submitted {{ $absent->created_at->diffForHumans() }}</small>
                                            </div>
                                            <span class="badge bg-warning">Pending</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-calendar-check display-4 text-muted"></i>
                                <p class="text-muted mt-3">No pending absence requests</p>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- <div class="col-lg-4">
                    <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                        <h5 class="mb-4">Quick Actions</h5>
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-primary text-start">
                                <i class="bi bi-plus-circle me-2"></i>Request Absence
                            </a>
                            <a href="#" class="btn btn-outline-secondary text-start">
                                <i class="bi bi-clock-history me-2"></i>Attendance History
                            </a>
                            <a href="#" class="btn btn-outline-secondary text-start">
                                <i class="bi bi-calendar-week me-2"></i>Monthly Report
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    @endif
</div>

<style>
.circular-progress {
    position: relative;
    height: 120px;
    width: 120px;
    border-radius: 50%;
    background: conic-gradient(#0dcaf0 0deg, #e9ecef 0deg);
    display: flex;
    align-items: center;
    justify-content: center;
}

.circular-progress::before {
    content: "";
    position: absolute;
    height: 100px;
    width: 100px;
    border-radius: 50%;
    background-color: white;
}

.progress-value {
    position: relative;
    font-size: 24px;
    font-weight: 600;
    color: #0dcaf0;
}

.avatar-title {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}
</style>
@endsection
