@extends('layouts.app')
@section('title','แดชบอร์ดผู้ดูแล — STC Connect')
@section('content')
<div class="page-head"><div><small>ADMIN CONTROL CENTER</small><h1>แดชบอร์ดผู้ดูแล</h1></div><span class="admin-shield">◆</span></div>
<div class="stats">
@foreach([['สมาชิก',$stats['users'],'♙'],['โพสต์',$stats['posts'],'▤'],['กลุ่ม',$stats['groups'],'♜'],['รอตรวจสอบ',$stats['pending'],'!']] as $s)
<article><i>{{ $s[2] }}</i><div><b>{{ number_format($s[1]) }}</b><small>{{ $s[0] }}</small></div></article>
@endforeach
</div>
<section class="panel"><div class="section-title"><b>รายการรายงานเนื้อหา</b><span>{{ $reports->where('status','pending')->count() }} รายการใหม่</span></div><div class="admin-table"><table><thead><tr><th>ผู้รายงาน</th><th>เหตุผล</th><th>เนื้อหา</th><th>สถานะ</th><th>จัดการ</th></tr></thead><tbody>
@forelse($reports as $report)
<tr><td><b>{{ $report->reporter->name }}</b><small>{{ $report->created_at->diffForHumans() }}</small></td><td>{{ $report->reason }}<small>{{ $report->details }}</small></td><td>{{ str($report->reportable?->content ?? 'เนื้อหาถูกลบ')->limit(60) }}</td><td><span class="status {{ $report->status }}">{{ $report->status }}</span></td><td>@if($report->status==='pending')<div class="row-actions"><form action="{{ route('admin.moderate',$report) }}" method="post">@csrf @method('PATCH')<input type="hidden" name="action" value="dismiss"><button class="btn light">ยกเลิก</button></form><form action="{{ route('admin.moderate',$report) }}" method="post">@csrf @method('PATCH')<input type="hidden" name="action" value="resolve_delete"><button class="btn danger">ลบเนื้อหา</button></form></div>@else—@endif</td></tr>
@empty<tr><td colspan="5" class="empty-cell">ยังไม่มีการรายงาน</td></tr>@endforelse
</tbody></table></div></section>
<section class="panel"><div class="section-title"><b>จัดการสมาชิก</b><span>{{ $users->count() }} บัญชี</span></div><div class="admin-table"><table><thead><tr><th>สมาชิก</th><th>รหัส</th><th>ประเภท</th><th>แผนก</th><th>สถานะ</th></tr></thead><tbody>
@foreach($users as $user)<tr><td><b>{{ $user->name }}</b><small>{{ $user->email }}</small></td><td>{{ $user->student_id }}</td><td>{{ $user->role }}</td><td>{{ $user->department }}</td><td>@if($user->id===auth()->id())<span class="status active">บัญชีปัจจุบัน</span>@else<form action="{{ route('admin.users.toggle',$user) }}" method="post">@csrf @method('PATCH')<button class="status {{ $user->is_active?'active':'blocked' }}">{{ $user->is_active?'ใช้งาน':'ถูกระงับ' }}</button></form>@endif</td></tr>@endforeach
</tbody></table></div></section>
@endsection
