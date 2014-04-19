<?php include('header.php'); ?>

<?php include('sidebar.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">View All Users</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-sitemap"></i> Current Users
                            <form class="form-inline pull-right" style="margin-top:-5px;" id="search-user" name="search-user" method="POST" role="form">
							  <div class="form-group">
							    <input type="text" class="form-control input-sm" id="search-username" name="search-username" placeholder="Username">
							  </div>
							  <button type="submit" name="submit" class="btn btn-primary btn-sm">Search</button>
							  <a href="./user_all.php" class="btn btn-info btn-sm">Clear</a>
							</form>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	 <small class="user_suspended suspended">Account Suspended</small>
                        	<div class="table-responsive">
                    <?php if(!isset($_POST['submit'])) { ?>
                    		<table class="table table-hover recent_teams">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>E-Mail</th>
                                            <th>Role</th>
                                            <th>Created</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                        <?php $users = $ez->getUsersAll(); ?>
                                    <tbody>
                          <?php foreach($users as $user) { ?>
                                        <tr <?php print ($user['status'] == 1 ? 'class=\'user_suspended\'' : ''); ?>>
                                            <td><?php echo $user['id']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td><?php echo ($user['role'] == 'admin' ? '<span class=\'text-success bolder\'>admin</span>' : '<span class=\'text-primary italic\'>user</span>'); ?></td>
                                            <td><?php echo date('F d, Y h:ia', strtotime($user['created'])); ?></td>
                                            <td>
                                            	<a href="#" onclick="getUser('<?php print $user['id']; ?>');" data-toggle="modal" data-target="#editUserModal" class="btn btn-success btn-xs">Edit</a>
							            	</td>
                                        </tr>
                           <?php } ?>
                           </tbody>
                           </table>
                    <?php } elseif(isset($_POST['submit'])) { ?>
                    	<?php $search = $_POST['search-username']; 
                    			$results = $ez->searchUsers($search);
                    			 if(!empty($results)) {
                    			 	print "<div class=\"search\">Search results for <span class=\"search\">" . $search . "</span></div>";
                    	?>
                    			<table class="table table-hover recent_teams">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>E-Mail</th>
                                            <th>Role</th>
                                            <th>Created</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
	                          <?php foreach($results as $user) { ?>
	                                        <tr <?php print ($user['status'] == 1 ? 'class=\'user_suspended\'' : ''); ?>>
	                                            <td><?php echo $user['id']; ?></td>
	                                            <td><?php echo $user['username']; ?></td>
	                                            <td><?php echo $user['email']; ?></td>
	                                            <td><?php echo ($user['role'] == 'admin' ? '<span class=\'text-success bolder\'>admin</span>' : '<span class=\'text-primary italic\'>user</span>'); ?></td>
	                                            <td><?php echo date('F d, Y h:ia', strtotime($user['created'])); ?></td>
	                                            <td>
	                                            	<a href="#" onclick="getUser('<?php print $user['id']; ?>');" data-toggle="modal" data-target="#editUserModal" class="btn btn-success btn-xs">Edit</a>
								            	</td>
	                                        </tr>
	                           <?php } ?>
                           	<?php } else { ?>
                           		Sorry, no search results found for <?php print $search; ?>
                           	<?php } ?>
                    <?php } ?>
                                    </tbody>
                                 </table>
                                    <!-- /.table-hover -->
                             </div>
                              <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                        <!-- /.panel -->
                </div>
                 	<!-- /.col-lg-8 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<div id="editUserModal" class="modal">
  
</div>

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
    <script src="js/ezleague.js"></script>

    <!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
    <script src="js/demo/dashboard-demo.js"></script>

</body>

</html>
