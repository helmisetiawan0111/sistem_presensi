@php
    // Map icon class to stat-icon color class
    $colorMap = [
        'bg-success-soft' => 'green',
        'bg-danger-soft' => 'red',
        'bg-permission-soft' => 'yellow',
        'bg-sickness-soft' => 'blue',
        'bg-info-soft' => 'blue',
        'bg-warning-soft' => 'yellow',
    ];
    $statIconColor = $colorMap[$iconClass] ?? 'blue';
@endphp
<div class="stat-card">
    <div class="stat-icon stat-icon-{{ $statIconColor }}">
        <i class="{{$icon}}"></i>
    </div>
    <div class="stat-content">
        <h3>{{ $number }}</h3>
        <p>{{ $label }}</p>
    </div>
</div>