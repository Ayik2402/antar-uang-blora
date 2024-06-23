@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">
	<div class="row layout-top-spacing">
		<div class="col-lg-12">
			<div class="card">

				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover" id="default-ordering" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Tanggal ajukan</th>
									<th>User</th>
									<th>Bank</th>
									<th>No rekening</th>
									<th>Atas nama</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach($apr as $key => $v)
								<tr>
									<td width="1%">{{$key + 1}}</td>
									<td>
										{{ \Carbon\Carbon::parse($v->created)->format('Y-m-d H:i:s') }}
									</td>
									<td>{{$v->name}}</td>
									<td>{{$v->bank}}</td>
									<td>{{$v->norek}}</td>
									<td>{{$v->atas_nama}}</td>
									<td>
										@if($v->status == 0)
										<span class="badge badge-info">Menunggu approve</span>
										@elseif($v->status == 2)
										<span class="badge badge-danger">Tolak</span>
										@else
										<span class="badge badge-success">Approve</span>
										@endif
									</td>
									<td>
										<a href="/terimarekening/{{$v->uuid}}/1" class="btn btn-success btn-sm">Terima</a>
										<a href="/terimarekening/{{$v->uuid}}/2" class="btn btn-danger btn-sm">Tolak</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection