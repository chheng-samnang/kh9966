<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</nav>
	<div id="page-wrapper">
		<div class="container_fluid" style="margin-top:40px;">
		<div class="row">
			<div class="col-lg-12">				
				<h1 class="page-header">Form Contact us Detail</h1>				
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Contact us Information</h3>
					</div>
					<div class="panel-body">							 
							<div class="col-lg-12">
                                <p><b>Phone1: </b><?php echo $detail->phone1;?></p>
                               	<p><b>Phone2: </b><?php echo $detail->phone2;?></p>
                               	<p><b>Phone3: </b><?php echo $detail->phone3;?></p>
                                <p><b>Email: </b><?php echo $detail->email;?></p>
                                <p><b>Facebook Messager: </b><?php echo $detail->fb_messager;?></p>                                     
                                <p><b>WhatApp: </b><?php echo $detail->whatApp;?></p>
                                <p><b>Line: </b><?php echo $detail->line;?></p>                                        
                                <p><b>Viber: </b><?php echo $detail->viber;?></p>                                                                                                                                                
                                <p><b>Address: </b><div class="thumbnail"><?php echo $detail->addr;?></div></p>                                                                                                                
                                <a href="<?php echo site_url($cancel);?>" class="btn btn-default fa fa-close"> Close</a>
                            </div>											
					</div>
				</div>
				<?php echo form_close()?>
			</div>
		</div>
	</div>
</div>

<script>
	$("#btnCancel").click(function(){
    	window.location.assign("<?php if(isset($cancel)){echo base_url($cancel);}?>");
	});
</script> 
