<?php session_start();
include('../class-db.php');
include('../class-ezadmin.php');
include('../objects/class-tournament.php');
$ez 	       = new ezAdmin();
$ez_tournament = new ezAdmin_Tournament();
    
    if(isset($_POST['form'])) {
    	$form = strip_tags($_POST['form']);
    	 switch($form) {
    	 	case 'add-map':
    	 		$map			= $_POST['map'];
    	 		$tournament_id	= $_POST['league_id'];
    	 		 $ez_tournament->add_map( $map, $tournament_id );
    	 		break;
    	 		
    	 	case 'set-map':
    	 		$map			= $_POST['map'];
    	 		$week			= $_POST['week'];
    	 		$tournament_id 	= $_POST['league'];
    	 		 $ez_tournament->set_map( $tournament_id, $week, $map );
    	 		break;
    	 		
    	 	case 'edit-rules':
    	 		$tournament_id  = $_POST['league_id'];
    	 		$rules          = $_POST['body'];
    	 		 $ez_tournament->edit_rules( $tournament_id, $rules );
    	 		break;
    	 		
    	 	case 'edit-tournament':
    	 		$tournament_id  = $_POST['tournament_id'];
                $tournament     = $_POST['tournament'];
    	 		$max_teams		= $_POST['max_teams'];
                $format         = $_POST['format'];
                $start          = strtotime( $_POST['start'] );
                $registration   = strtotime( $_POST['registration'] );
    	 		 $ez_tournament->edit_tournament($max_teams, $tournament_id, $tournament, $format, $start, $registration);
    	 		break;
    	 		
    	 	case 'delete-tournament':
    	 		$tournament_id	= $_POST['tournament_id'];
    	 		 $ez_tournament->delete_tournament( $tournament_id );
    	 		break;
    	 		
    	 	case 'create-tournament':
    	 		$tournament		= $_POST['tournament'];
    	 		$teams			= $_POST['max_teams'];
    	 		$game			= $_POST['game'];
                $start          = strtotime( $_POST['start'] );
                $registration   = strtotime( $_POST['registration'] );
                $format         = $_POST['format'];
    	 		 $ez_tournament->create_tournament( $tournament, $game, $teams, $start, $registration, $format );
    	 		break;
    	 	
            case 'kick-team':
                $tournament_id  = $_POST['league_id'];
                $team_id        = $_POST['team_id'];
                $reason         = $_POST['reason'];
                 $ez_tournament->kick_team( $tournament_id, $team_id, $reason );
                break;

            case 'unkick-team':
                $tournament_id  = $_POST['league_id'];
                $team_id        = $_POST['team_id'];
                 $ez_tournament->unsuspend_team( $tournament_id, $team_id );
                break;

    	 	default:
    	 		break;
    	 }
    	
    }
?>