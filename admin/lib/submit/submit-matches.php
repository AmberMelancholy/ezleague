<?php session_start();
include('../class-db.php');
include('../class-ezadmin.php');
include('../objects/class-match.php');
$ez 	   = new ezAdmin();
$ez_match  = new ezAdmin_Match();
    
    if(isset($_POST['form'])) {
    	$form = strip_tags($_POST['form']);
    	 switch($form) {
    	 	case 'edit-score':
    	 		$match_id		= $_POST['match_id'];
    	 		$home			= $_POST['home'];
    	 		$home_score		= $_POST['home_score'];
    	 		$away			= $_POST['away'];
    	 		$away_score		= $_POST['away_score'];
    	 		 $ez_match->edit_score( $match_id, $home, $home_score, $away, $away_score );
    	 	 	break;

            case 'update-featured-match':
                $match_id       = $_POST['match_id'];
                $week           = $_POST['week'];
                $league_id      = $_POST['league_id'];
                $method         = $_POST['method'];
                 $ez_match->update_featured_match( $match_id, $week, $league_id, $method );
                break;

    	 	default:
    	 		break;
    	 }
    	
    }
?>