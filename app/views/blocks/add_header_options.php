<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">{{ __( 'Header slogan', 'photolab' ) }}</th>
			<td>
				<textarea name="phtotloab_header_slogan" id="phtotloab_header_slogan" rows="5" cols="100">
					{{ get_theme_mod( 'header_slogan', __( '<em>Profesional Photographer</em>Hi! I am Linda Grey Johns. I live in NY.', 'photolab' ) ) }}
				</textarea>
			</td>
		</tr>
		<tr>
			<th scope="row">{{ __( 'Show post title on header image?', 'photolab' ) }}</th>
			<td>
				<label>
					<input type="checkbox" name="show_post_title_on_header">
					{{ __( 'Show post title on header image?', 'photolab' ) }}
				</label>
			</td>
		</tr>
	</tbody>
</table>