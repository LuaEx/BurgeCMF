<div class="main">
	<div class="container">
		<h1>{post_details_text} {post_id}
			<?php 
			if($post_info && $post_info['post_title']) 
				echo $comma_text." ".$post_info['post_title'];
			?>
		</h1>		
		<?php 
			if(!$post_info) {
		?>
			<h4>{not_found_text}</h4>
		<?php 
			}else{ 
		?>
			<script src="{scripts_url}/tinymce/tinymce.min.js"></script>
			<div class="container">
				<div class="row general-buttons">
					<div class="two columns button sub-primary button-type2" onclick="deletePost()">
						{delete_post_text}
					</div>
				</div>
				<br>
				<?php echo form_open(get_admin_post_details_link($post_id),array("onsubmit"=>"return formSubmit();")); ?>
					<input type="hidden" name="post_type" value="edit_post" />
					<div class="row even-odd-bg" >
						<div class="three columns">
							<span>{creator_user_text}</span>
						</div>
						<div class="six columns">
							<span>
								<?php echo $code_text." ".$post_info['user_id']." - ".$post_info['user_name'];?>
							</span>							
						</div>
					</div>
					<div class="row even-odd-bg" >
						<div class="three columns">
							<span>{active_text}</span>
						</div>
						<div class="six columns">
							<input type="checkbox" class="graphical" name="post_active"
								<?php if($post_info['post_active']) echo "checked"; ?>
							/>
						</div>
					</div>
					<div class="row even-odd-bg" >
						<div class="three columns">
							<span>{allow_comment_text}</span>
						</div>
						<div class="six columns">
							<input type="checkbox" class="graphical" name="post_allow_comment"
								<?php if($post_info['post_allow_comment']) echo "checked"; ?>
							/>
						</div>
					</div>
					<div class="row even-odd-bg" >
						<div class="three columns">
							<span>{categories_text}</span>
						</div>
						<input type="hidden" name="categories"/>
						<div id="category" class="nine columns category-div" style="max-height:500px;overflow:auto;">
							<?php echo $categories;?>
						</div>
						<script type="text/javascript">
							$(function()
							{
								var categories=[<?php echo $post_info['categories']?>];
								for(i=0;i<categories.length;i++)
									$("#category input[data-id="+categories[i]+"]").prop("checked","checked");
								
								$("input[name=categories]").val(categories);

								$("#category span").click(
									function()
									{
										var id=$(this).data("id");
										var el=$("#category input[data-id="+id+"]");
										el.trigger("click");
									}
								);

								$("#category input").change(function()
								{
									var ids=[];
									$("#category input:checked").each(function(index,el)
									{
										ids[ids.length]=$(el).data("id");
									});

									$("input[name=categories]").val(ids.join(","));
								});
							});						
							
						</script>
					</div>
					<div class="tab-container">
						<ul class="tabs">
							<?php foreach($post_contents as $pc) { ?>
								<li>
									<a href="#pc_<?php echo $pc['pc_lang_id'];?>">
										<?php echo $langs[$pc['pc_lang_id']];?>
									</a>
								</li>
							<?php } ?>
						</ul>
						<script type="text/javascript">
							$(function(){
							   $('ul.tabs').each(function(){
									var $active, $content, $links = $(this).find('a');
									$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
									$active.addClass('active');

									$content = $($active[0].hash);

									$links.not($active).each(function () {
									   $(this.hash).hide();
									});

									$(this).on('click', 'a', function(e){
									   $active.removeClass('active');
									   $content.hide();

									   $active = $(this);
									   $content = $(this.hash);

									   $active.addClass('active');

									   $content.show();						   	

									   e.preventDefault();
									   
									   <?php if(0) { ?>
										   //since each tab has different height, 
										   //we should reequalize  height of sidebar and main div.
										   //may be a bad hack,
										   //which should be corrected in future versions.
										   //
										   //what should we  do ?
										   //we should allow developers to register a list of functions 
										   //to be called on document\.ready event,
										   //but each function has a priority, 
										   //so we can sort their execution by that priority.
										   //and this will solve the problem
										   //for example in this situation, in each load, we should first equalize height of
										   //all tabs, and then call setupMovingHeader 
										   //in this way we don't need to call setupMovingHeader in each tab change event
										<?php } ?>
									   setupMovingHeader();
									});
								});
							});
						</script>
						<?php foreach($post_contents as $lang=>$pc) {?>
							<div class="tab" id="pc_<?php echo $pc['pc_lang_id'];?>">
								<div class="container">
									<div class="row even-odd-bg" >
										<div class="three columns">
											<span>{active_text}</span>
										</div>
										<div class="six columns">
											<input type="checkbox" class="graphical" 
												name="<?php echo $lang;?>[pc_active]" 
												<?php if($pc['pc_active']) echo "checked"; ?>
											/>
										</div>
									</div>
									<div class="row even-odd-bg" >
										<div class="three columns">
											<span>{title_text}</span>
										</div>
										<div class="nine columns">
											<input type="text" class="full-width" 
												name="<?php echo $lang;?>[pc_title]" 
												value="<?php echo $pc['pc_title']; ?>"
											/>
										</div>
									</div>
									<div class="row even-odd-bg dont-magnify" >
										<div class="three columns">
											<span>{content_text}</span>
										</div>
										<div class="twelve columns ">
											<textarea class="full-width" rows="15"
												name="<?php echo $lang;?>[pc_content]"
											><?php echo $pc['pc_content']; ?></textarea>
										</div>
									</div>
									<div class="row even-odd-bg" >
										<div class="three columns">
											<span>{meta_keywords_text}</span>
										</div>
										<div class="nine columns">
											<input type="text" class="full-width" 
												name="<?php echo $lang;?>[pc_keywords]" 
												value="<?php echo $pc['pc_keywords']; ?>"
											/>
										</div>
									</div>
									<div class="row even-odd-bg" >
										<div class="three columns">
											<span>{meta_description_text}</span>
										</div>
										<div class="nine columns">
											<input type="text" class="full-width" 
												name="<?php echo $lang;?>[pc_description]" 
												value="<?php echo $pc['pc_description']; ?>"
											/>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<br><br>
					<div class="row">
							<div class="four columns">&nbsp;</div>
							<input type="submit" class=" button-primary four columns" value="{submit_text}"/>
					</div>				
				</form>

				<div style="display:none">
					<?php echo form_open(get_admin_post_details_link($post_id),array("id"=>"delete")); ?>
						<input type="hidden" name="post_type" value="delete_post"/>
						<input type="hidden" name="post_id" value="{post_id}"/>
					</form>

					 <script type="text/javascript">

					$(initializeTextAreas);
					var tmTextAreas=[];
					<?php
						foreach($langs as $lang => $value)
							echo "\n".'tmTextAreas.push("textarea[name=\''.$lang.'[pc_content]\']");';
					?>
					var tineMCEFontFamilies=
						"Mitra= b mitra, mitra;Yagut= b yagut, yagut; Titr= b titr, titr; Zar= b zar, zar; Koodak= b koodak, koodak;"+
						+"Andale Mono=andale mono,times;"
						+"Arial=arial,helvetica,sans-serif;"
						+"Arial Black=arial black,avant garde;"
						+"Book Antiqua=book antiqua,palatino;"
						+"Comic Sans MS=comic sans ms,sans-serif;"
						+"Courier New=courier new,courier;"
						+"Georgia=georgia,palatino;"
						+"Helvetica=helvetica;"
						+"Impact=impact,chicago;"
						+"Symbol=symbol;"
						+"Tahoma=tahoma,arial,helvetica,sans-serif;"
						+"Terminal=terminal,monaco;"
						+"Times New Roman=times new roman,times;"
						+"Trebuchet MS=trebuchet ms,geneva;"
						+"Verdana=verdana,geneva;"
						+"Webdings=webdings;"
						+"Wingdings=wingdings,zapf dingbats";
					var tinyMCEPlugins="directionality textcolor link image hr emoticons2 lineheight colorpicker media";
					var tinyMCEToolbar=[
					   "link image media hr bold italic underline strikethrough alignleft aligncenter alignright alignjustify styleselect formatselect fontselect fontsizeselect  emoticons2",
					   "cut copy paste bullist numlist outdent indent forecolor backcolor removeformat  ltr rtl lineheightselect "
					];

					function formSubmit()
					{
						return true;
					}

					function RoxyFileBrowser(field_name, url, type, win)
					{
						var roxyFileman ="<?php echo get_link('admin_file_inline');?>";

						if (roxyFileman.indexOf("?") < 0) {     
						 roxyFileman += "?type=" + type;   
						}
						else {
						 roxyFileman += "&type=" + type;
						}
						roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
						if(tinyMCE.activeEditor.settings.language){
						 roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
						}
						tinyMCE.activeEditor.windowManager.open({
						  file: roxyFileman,
						  title: 'Roxy Fileman',
						  width: 850, 
						  height: 650,
						  resizable: "yes",
						  plugins: "media",
						  inline: "yes",
						  close_previous: "no"  
						}, {     window: win,     input: field_name    });
					
						return false; 
					}

					function initializeTextAreas()
					{
						for(i in tmTextAreas)
		               tinymce.init({
								selector: tmTextAreas[i]
								,plugins: tinyMCEPlugins
								,file_browser_callback: RoxyFileBrowser
								//,width:"600"
								,height:"600"
								,convert_urls:false
								,toolbar: tinyMCEToolbar
								,font_formats:tineMCEFontFamilies
								,media_live_embeds: true
	               	});
						
						setTimeout(setupMovingHeader,1000);
              	}
              	function deletePost()
						{
							if(!confirm("{are_you_sure_to_delete_this_post_text}"))
								return;

							$("form#delete").submit();
						}
					</script>
				</div>
			</div>
		<?php 
			}
		?>
		
		



	</div>
</div>