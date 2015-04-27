<?php session_start();
include('../class-db.php');
include('../objects/class-user.php');
$ez_user = new ezAdmin_User();
    
    if(isset($_POST['form'])) {
    	$form = strip_tags($_POST['form']);
    	 switch($form) {
    	 	case 'delete-user':
    	 		$user_id	= $_POST['id'];
    	 		 $ez_user->delete_user( $user_id );
    	 		break;
    	 		
    	 	case 'suspend-user':
    	 		$user_id	= $_POST['id'];
    	 		$status		= $_POST['status'];
    	 		 $ez_user->toggle_suspend_user( $user_id, $status );
    	 		break;
    	 		
    	 	case 'toggle-role-user':
    	 		$user_id	= $_POST['id'];
    	 		$role		= $_POST['role'];
    	 		 $ez_user->toggle_user_role( $user_id, $role );
    	 		break;
    	 		
    	 	case 'update-email':
    	 		$user_id	= $_POST['user_id'];
    	 		$email		= $_POST['email'];
    	 		 $ez_user->update_email( $user_id, $email );
    	 		break;
    	 		
    	 	case 'update-password':
    	 		$user_id 	= $_POST['user_id'];
    	 		$password	= $_POST['password'];
    	 		 $ez_user->update_password( $user_id, $password );
    	 		break;

            case 'create-user':
                $username   = $_POST['username'];
                $first_name = $_POST['first_name'];
                $last_name  = $_POST['last_name'];
                $email      = $_POST['email'];
                $role       = $_POST['role'];
                $team_id    = $_POST['team'];
                $send_email = $_POST['notification'];
                 $ez_user->create_user($username, $first_name, $last_name, $email, $role, $team_id, $send_email);
                break;
    	 	
    	 	default:
    	 		break;
    	 }
    	
    }
?>