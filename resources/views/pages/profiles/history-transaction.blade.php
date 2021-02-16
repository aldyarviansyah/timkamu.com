@extends('layouts.mana-ui')

@section('page_title', "My LP & BP Transactions")
@section('body_class', 'mana-ui my-transactions')


@section('content')
@include('includes.mana-ui.effects')
@include('includes.mana-ui.nav')


<!-- page content -->
<section id="page-content">

	<!-- page header -->
	<div id="page-title">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6">
					<h1 class="rajdhani-bold">My LP & BP Transactions</h1>
				</div>
			</div> 
		</div>
	</div>

	<!-- event index filters -->
	<div class="transactions-filters mb-50">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6">
					<div class="d-flex flex-wrap">
						<div class="transactions-filter game mb-0">
							<select class="custom-select transactions-type-select">
								<option @if(app('request')->input('name') === 'lp') selected @endif value="lp">Loyalty Points</option>
								<option @if(app('request')->input('name') === 'bp') selected @endif value="bp">Battle Points</option>
							</select>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>

	<!-- pagination head -->
	<div id="pagination-head">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6">
					<div class="section-title position-relative">
						<h4 class="font-size-16 mb-20">Page {{ $transactions->currentPage() }} of {{ $transactions->lastPage() }}</h4>
						<div href="#" class="o5 section-title-meta-link font-size-14">
							<a href="@if($transactions->currentPage() === 1)#@else{{ url('profile/transaction?name='.app('request')->input('name').'&page='.($transactions->currentPage() - 1)) }}@endif">Previous</a>
							&nbsp;&nbsp;-&nbsp;&nbsp;
							<a href="@if($transactions->currentPage() === $transactions->lastPage())#@else{{ url('profile/transaction?name='.app('request')->input('name').'&page='.($transactions->currentPage() + 1)) }}@endif">Next</a>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>

	<!-- event index filters -->
	<div class="transactions-wrapper mb-50">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6">

					<div class="transactions-panel @if(app('request')->input('name') === 'lp') active @endif panel1">

						@if($transactions->total() > 0)
                        @foreach ($transactions->items() as $transaction)
                        <div class="dashboard-info-group mb-10">
							<div class="info-horizontal bg020 bd20 d-flex align-items-center justify-content-center">
								<div class="info-horizontal-left">
									<span class="o5 font-size-14">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y') }}</span> <br>
									{{ $transaction->desc }}
								</div>
								<div class="info-horizontal-right text-right"><span class="money money-14 right"><span>{{ ($transaction->type === 'CR' ? '+' : '-') . $transaction->value }}</span><img src="{{ asset('img/currencies/lp.svg') }}"></span></div>
							</div>
						</div>
						@endforeach
						@else
						<div class="lpbp-no-transaction bd20 bg25510 d-flex align-items-center justify-content-center mb-20">
							Belum ada transaksi
						</div>
						@endif

					</div>

					<div class="transactions-panel @if(app('request')->input('name') === 'bp') active @endif panel2">

						@if($transactions->total() > 0)
                        @foreach ($transactions->items() as $transaction)
                        <div class="dashboard-info-group mb-10">
							<div class="info-horizontal bg020 bd20 d-flex align-items-center justify-content-center">
								<div class="info-horizontal-left">
									<span class="o5 font-size-14">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y') }}</span> <br>
									{{ $transaction->desc }}
								</div>
								<div class="info-horizontal-right text-right"><span class="money money-14 right"><span>{{ ($transaction->type === 'CR' ? '+' : '-') . $transaction->value }}</span><img src="{{ asset('img/currencies/bp.svg') }}"></span></div>
							</div>
						</div>
						@endforeach
						@else
						<div class="lpbp-no-transaction bd20 bg25510 d-flex align-items-center justify-content-center mb-20">
							Belum ada transaksi
						</div>
						@endif
					</div>

				</div>
			</div> 
		</div>
	</div>

</section>

<section id="page-modals">
	<div class="modal mana-ui slim-card" tabindex="-1" role="dialog" id="past-event-notice">
		<div class="modal-dialog modal-dialog-centered" role="document">
			
			<div class="modal-content">
				@include('includes.mana-ui.modal-top')
				<div class="modal-about rajdhani-bold font-size-32">
					Pertandingan sudah selesai
				</div>
				<div class="modal-mid font-size-16 o5">
					Pertandingan ini sudah selesai. 
				</div>
				<div class="modal-actions d-flex flex-column">
					<a href="/mana/transactions" class="mana-btn-54 mana-btn-red scale-onclick">Lihat games upcoming</a>
					<a href="#" class="mana-btn-54 mana-btn-opaque scale-onclick" data-dismiss="modal">Okay</a>
				</div>
			</div>
		</div>
	</div>
</section>

@include('includes.mana-ui.footer')
@include('includes.mana-ui.modals')


<style type="text/css">
	/*page specific*/
	.lpbp-no-transaction {
		padding: 50px 70px;
	}
	.transactions-panel {
		display: none;
	}
	.transactions-panel.active {
		display: block;
	}
	.transactions-wrapper .info-horizontal {
		line-height: unset;
		height: unset;
		padding: 15px 25px;
	}
	h4 .icon {
		width: 16px;
	    position: relative;
	    top: -2px;
	    margin-right: 10px;
	    opacity: 0.3;
	}
	
	.transactions-filter {
		margin-bottom: 20px;
	}
	.transactions-filter.status {
		margin-left: 20px;
	}
	.transactions-filter.month,
	.transactions-filter.status {
		flex: 1;
	}
	.transactions-filter.game {
		flex: 0 0 100%;
	}
	.transactions-filter .custom-select {
		border-radius: 10px;
		border: 0px;
		background: url("{{ asset('icons/chevron-down-white.svg') }}") no-repeat right 14px center/14px 14px;
		background-color: rgb(255 255 255 / 10%);
		color: rgb(255 255 255 / 90%);
		padding: 12px 40px 12px 12px;
		height: unset;
		position: relative;
	}
	.transactions-filter .custom-select option {
		background-color: #42336E;
	}
	::selection {
		background-color: #523A76;
	}
</style>
<style type="text/css">
	/*media*/
	
</style>
@endsection

@section('js')
<script>
	$(document).ready(function() {
		
		// page specific scripts 

		$('body').on('change', '.transactions-type-select', function(e) {
			e.preventDefault();

			target = $(this).val();

			var urlString = ("{{ url('profile/transaction?name=') }}"+target).replace(/&amp;/g, '&');
			location.href = urlString
		});

	})
</script>
@endsection