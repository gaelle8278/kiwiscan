<?php 
/**
 * Edit meta icon field for custom taxonomy "kscv_cv_hobby_taxo"
 */
?>
	<tr class="form-field">
		<th><label for="meta_icon_hobby_taxo">Niveau</label></th>
		 
		<td>	 
			<input type="text" class="large-text" name="meta_icon_hobby_taxo" id="meta_icon_hobby_taxo" value="<?php echo esc_attr( $term_icon ); ?>"><br>
			<button type="button" class="button" id="hobby_icon_upload_btn" data-media-uploader-target="#meta_icon_hobby_taxo"><?php echo "Choisir une icone"; ?></button>
		</td>
	</tr>