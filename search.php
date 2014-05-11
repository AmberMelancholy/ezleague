<?php include('header.php'); ?>

	<div class="row">
		  
          <?php include('sidebar.php'); ?>
          <div class="col-lg-10">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title"><span class="bolder"><?php echo $site_name; ?></span> - <span class="italic">Member Search</span></h3>
                </div>
                <div class="panel-body">    
 	 		   <div class="col-lg-12"> 
 	 		     <div class="form-group input-group col-lg-3">
 	 		      <form name="searchUsers" id="searchUsers" method="POST">
				    <input class="form-control" type="text" name="search" placeholder="Search Users"></input>
				    <span class="input-group-btn">
				     <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
				    </span>
				  </form>
				</div>
				<?php 
					$search = trim($_POST['search']);
					 if(!empty($search)) {
					  $results = $ez->searchUsers($search);
				?>
                  <table class="table table-striped table-hover ">
				   <thead>
				    <tr>
				      <th>Username</th>
				      <th>Guild</th>
				      <th>E-Mail</th>
				      <th></th>
				    </tr>
				   </thead>
				   <tbody>			   
	 <?php 
	 	
	 		foreach($results as $user) {
	 			$user_guild_id = $user['guild'];
	 			 $user_guild_data = $ez->getUserGuild($user_guild_id);
	 			  $user_guild = $user_guild_data['0']['guild'];
	 ?>				 
				    <tr>
				      <td class="italic"><?php print $user['username']; ?></td>
				      <td><?php print $user_guild; ?></td>
				      <td><a href="mailto:<?php print $user['email']; ?>"><?php print $user['email']; ?></a></td>
				      <td>
				      	<a href="<?php echo $site_url; ?>/users/id/<?php echo $user['id']; ?>" class="btn btn-info btn-xs">
				      		<i class="fa fa-search"></i> View Member
				      	</a>
				      	<?php if(empty($user_guild_id) && isset($_SESSION['ez_guild_admin'])) { ?>
				      	<button id="inv-<?php print $user['id']; ?>" onclick="teamInvite('<?php echo $user['id']; ?>', '<?php print $ez_guild_id; ?>')" class="btn btn-warning btn-xs">
				      		<i class="fa fa-users"></i> Guild Invite
				      	</button>
				      	<?php } ?>
				      </td>
				    </tr>
	<?php } ?>				    
				   </tbody>
				  </table>
			<?php } else { ?>
				<strong>Error</strong> Nothing was searched for
			<?php } ?>
				 </div>		  
                </div>
              </div>

          </div>
        
	</div>


<?php include('footer.php'); ?>