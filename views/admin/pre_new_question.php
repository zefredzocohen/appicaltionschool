<?php 
$this->load->view('admin/layout/header.php');
$this->load->view('admin/layout/menu_admin.php');
?>
 <div class="container" style="margin-top: 15px;">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('qbank/pre_new_question/');?>">
	
<div class="col-md-8">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		
		
		
				<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_question_type');?></label> 
					<select class="form-control" name="question_type" onChange="hidenop(this.value);">
						<option value="1"><?php echo $this->lang->line('multiple_choice_single_answer');?></option>
						
					
					</select>
			</div>

			<div class="form-group" id="nop" >	 
					<label for="inputEmail"  ><?php echo $this->lang->line('nop');?></label> 
					<input type="text"   name="nop"  class="form-control" value="4"   >
			</div>


 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('next');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
<?php $this->load->view('admin/layout/footer.php');?>