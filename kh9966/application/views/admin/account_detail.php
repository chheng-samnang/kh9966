<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
</nav>
	<div id="page-wrapper">
		<div class="container_fluid" style="margin-top:40px;">
		<div class="row">
			<div class="col-lg-12">				
				<h1 class="page-header">Form Account Detail</h1>				
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Account detail Information</h3>
					</div>
					<div class="panel-body">
							 <div class="col-lg-2">
                                <img class="img-responsive img-thumbnail" src="<?php echo base_url('assets/uploads/'.$detail->acc_photo);?>"/>
                            </div>
							<div class="col-lg-10">
                                <p><b>Account code: </b><?php echo $detail->acc_code;?></p>
                               	<p><b>Account name: </b><?php echo $detail->acc_name;?></p>
                                <p><b>Company: </b><?php echo $detail->acc_company;?></p>                                
                                <p><b>Email: </b><?php echo $detail->acc_email;?></p>
                                <p><b>Phone: </b><?php echo $detail->acc_phone;?></p>                                        
                                <p><b>Website: </b><?php echo $detail->acc_website;?></p>                                                                        
                                <p><b>Status: </b><?php echo $detail->acc_status=='1'?'Enable':'Disable';?></p>                                                                        
                                <p><b>Address: </b><div class="thumbnail"><?php echo $detail->acc_addr;?></div></p>                                                                                
                                <p><b>Description: </b><div class="thumbnail"><?php echo $detail->acc_desc;?></div></p>                                
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
