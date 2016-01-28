@if( 'true' === $subscribe_is )
	<!-- Subscribe section -->
	<div class="subscribe">
		<h3>
			{{ $subscribe_title }}
		</h3>
		<div class="description">
			{{ $subscribe_description }}
		</div>
		<div class="form">
			<form>
				<input type="hidden" name="action" value="tm-mailchimp-subscribe">
				<input type="hidden" name="api-key" value="{{ $api_key }}">
				<input type="hidden" name="list-id" value="{{ $list_id }}">
				<input type="email" name="email" placeholder="email@example.com">
				<input type="image" src="{{ $subscribe_submit_src }}" alt="{{ __( 'Submit', PHOTOLAB_BASE_TM_ALIAS ) }}">
			</form>
			<div class="message">
				<span class="success">{{ $success_message }}</span>
				<span class="failed">{{ $failed_message }}</span>
			</div>
		</div>
	</div>
	<!-- End subscribe section -->
@endif
