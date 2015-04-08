<?php 

class ezAdmin_Tournament extends DB_Class {

	public function get_all_tournaments() {
		
		$data = $this->fetch("SELECT " . $this->prefix . "games.slug, " . $this->prefix . "games.game AS ggame, " . $this->prefix . "tournaments.game AS lgame, " . $this->prefix . "tournaments.id AS tid,
								" . $this->prefix . "tournaments.start_date, " . $this->prefix . "tournaments.tournament
								FROM `" . $this->prefix . "tournaments`, `" . $this->prefix . "games`
								WHERE " . $this->prefix . "games.slug = " . $this->prefix . "tournaments.game
								ORDER BY " . $this->prefix . "tournaments.game DESC, " . $this->prefix . "tournaments.id ASC
							");
		return $data;
		
	}

	public function get_open_tournaments() {
		
		$data = $this->fetch("SELECT " . $this->prefix . "games.slug, " . $this->prefix . "games.game AS ggame, " . $this->prefix . "tournaments.game AS lgame, " . $this->prefix . "tournaments.id AS tid,
								" . $this->prefix . "tournaments.start_date, " . $this->prefix . "tournaments.tournament, " . $this->prefix . "tournaments.max_teams
								FROM `" . $this->prefix . "tournaments`, `" . $this->prefix . "games`
								WHERE (" . $this->prefix . "games.slug = " . $this->prefix . "tournaments.game) 
									AND (" . $this->prefix . "tournaments.status = '1')
								ORDER BY " . $this->prefix . "tournaments.game DESC, " . $this->prefix . "tournaments.id ASC
							");
		return $data;
		
	}

	public function get_closed_tournaments() {
		
		$data = $this->fetch("SELECT " . $this->prefix . "games.slug, " . $this->prefix . "games.game AS ggame, " . $this->prefix . "tournaments.game AS lgame, " . $this->prefix . "tournaments.id AS tid,
								" . $this->prefix . "tournaments.start_date, " . $this->prefix . "tournaments.tournament
								FROM `" . $this->prefix . "tournaments`, `" . $this->prefix . "games`
								WHERE (" . $this->prefix . "games.slug = " . $this->prefix . "tournaments.game) 
									AND (" . $this->prefix . "tournaments.status = '0')
								ORDER BY " . $this->prefix . "tournaments.game DESC, " . $this->prefix . "tournaments.id ASC
							");
		return $data;
		
	}

	public function get_tournament($tournament_id) {
		
		$data = $this->fetch("SELECT * FROM `" . $this->prefix . "tournaments` WHERE id = '$tournament_id'");
		$tournament = array(
				'id'		 	=> $data['0']['id'],
				'tournament' 	=> $data['0']['tournament'],
				'teams'		 	=> $data['0']['max_teams'],
				'game'		 	=> $data['0']['game'],
				'status'	 	=> $data['0']['status'],
				'start_date' 	=> date( 'Y-m-d', strtotime( $data['0']['start_date'] ) ),
				'registration' 	=> date( 'Y-m-d', strtotime( $data['0']['registration_date'] ) ),
				'format'	 	=> $data['0']['format'],
				'type' 		 	=> $data['0']['type'],
				'rules'		 	=> $data['0']['rules']
		);
		return $tournament;
		
	}
	
	public function create_tournament($tournament, $game, $max_teams, $start_date, $registration, $format) {
		
		$tournament 		= $this->sanitize( $tournament );
		$game 				= $this->sanitize( $game );
		$max_teams			= $this->sanitize( $max_teams );
		$start_date 		= $this->sanitize( $start_date );
		$registration 		= $this->sanitize( $registration );
		$start_date 		= date( 'Y-m-d', $start_date );
		$registration_date 	= date( 'Y-m-d', $registration );
		$format 			= $this->sanitize( $format );
		$result = $this->link->query("SELECT tournament FROM `" . $this->prefix . "tournaments` WHERE (tournament = '$tournament') AND (game = '$game')");
		$count = $this->numRows($result);
		if( $count > 0 ) {
			$this->error('Tournament Name already exists');
		} else {
			$tournament = $this->sanitize( $tournament );
			$this->link->query("INSERT INTO `" . $this->prefix . "tournaments` 
								SET tournament = '$tournament', game = '$game', max_teams = '$max_teams', start_date = '$start_date', registration_date = '$registration_date', format = '$format'
							");
	
			$this->success('' . $tournament . ' Tournament added...reloading');
		}
		return;
		
	}
	
	public function edit_tournament($max_teams, $tournament_id, $tournament, $format, $start_date, $registration) {
		
		$max_teams			= $this->sanitize( $max_teams );
		$format				= $this->sanitize( $format );
		$tournament_id		= $this->sanitize( $tournament_id );
		$start_date 		= $this->sanitize( $start_date );
		$registration 		= $this->sanitize( $registration );
		$start_date 		= date( 'Y-m-d', $start_date );
		$registration_date 	= date( 'Y-m-d', $registration );
		$this->link->query("UPDATE `" . $this->prefix . "tournaments` 
							SET tournament = '$tournament', max_teams = '$max_teams', format = '$format', start_date = '$start_date', registration_date = '$registration_date' 
							WHERE id = '$tournament_id'
						");
		$this->success( 'tournament details updated' );
		return;
		
	}
	
	public function delete_tournament($tournament_id) {
		
		$tournament_id = $this->sanitize( $tournament_id );
		$this->link->query("DELETE FROM `" . $this->prefix . "tournaments` WHERE id = '$tournament_id'");
		$this->link->query("DELETE FROM `" . $this->prefix . "tournament_matches` WHERE tid = '$tournament_id'");
		$teams = $this->get_tournament_teams( $tournament_id );
		foreach( $teams as $team ) {
			$tournaments = $team['tournaments'];
			$explode = explode( ',', $tournaments );
			if( ( $key = array_search( $tournament_id, $explode ) ) !== false ) {
				unset( $explode[$key] );
			}
			$updated = implode( ',', $explode );
			$this->link->query("UPDATE `" . $this->prefix . "guilds` SET tournaments = '$updated' WHERE id = '$team[id]'");
		}
		$this->success( 'Tournament has been deleted and teams updated' );
		return;
		
	}
	
	public function get_rules($tournament_id) {
		
		$tournament_id	= $this->sanitize( $tournament_id );
		$data = $this->fetch("SELECT tournament, rules FROM `" . $this->prefix . "tournaments` WHERE id = '$tournament_id'");
		if( $data ) { 
			$tournament = array(
					'tournament' => $data['0']['tournament'],
					'rules'  => $data['0']['rules']
			);
			return $tournament;
		}
		
	}
	
	public function edit_rules($tournament_id, $rules) {
		
		$tournament_id = $this->sanitize( $tournament_id );
		$rules 	   = $this->sanitize( $rules );
		$this->link->query("UPDATE `" . $this->prefix . "tournaments` SET rules = '$rules' WHERE id = '$tournament_id'");
		$this->success('tournament Rules have been updated...reloading');
		
	}
	
	public function get_total_teams($tournament_id) {
		
		$result = $this->link->query("SELECT guild FROM `" . $this->prefix . "guilds` WHERE tournaments LIKE '%,$tournament_id' OR tournaments LIKE '$tournament_id,%' OR tournaments LIKE '$tournament_id'");
		$count = $this->numRows($result);
		return $count;
		
	}
	
	public function get_tournament_teams($tournament_id) {
		
		$data = $this->fetch("SELECT * FROM `" . $this->prefix . "guilds` WHERE tournaments LIKE '%,$tournament_id' OR tournaments LIKE '$tournament_id,%' OR tournaments LIKE '$tournament_id' OR tournaments LIKE '%,$tournament_id,%'");
		return $data;
		
	}

	public function kick_team($tournament_id, $team_id) {
		
		$tournament_id 	= $this->sanitize( $tournament_id );
		$team_id 		= $this->sanitize( $team_id );

		$this->quit_tournament( $tournament_id, $team_id );

		$this->success('Team has been kicked from Tournament.');
		return;
		$team_admin_data = $this->fetch("SELECT " . $this->prefix . "users.`email`, " . $this->prefix . "guilds.`admin`, " . $this->prefix . "guilds.`id`, " . $this->prefix . "users.`username`, " . $this->prefix . "guilds.`guild`
											FROM `" . $this->prefix . "users`, `" . $this->prefix . "guilds` 
											WHERE `" . $this->prefix . "guilds`.id = '$team_id' AND `" . $this->prefix . "guilds`.admin = `" . $this->prefix . "users`.username");
		$admin_email = $team_admin_data['0']['email'];
		$team_name   = $team_admin_data['0']['guild'];

		$tournament_details = $this->get_tournament( $tournament_id );
		$tournament_name = $tournament_details['tournament'];
		
		$email_data = $this->fetch("SELECT site_name, site_email, site_url, mandrill_username, mandrill_password FROM `" . $this->prefix . "settings` WHERE id = '1'");

		$to 	 = $admin_email;
		$from    = $email_data['0']['site_email'];
		$site_name = $email_data['0']['site_name'];
		$site_url  = $email_data['0']['site_url'];
		$subject = 'Tournament Team has been kicked';


		$message = '<html><body>';
		$message .= '<h3>' . $site_name . '</h3>';
		$message .= '<p>Sorry, but your team [<em>' . $team_name . '</em>] has been kicked from the <em>' . $tournament_name . ' Tournament</em> for the remainder of the tournament.</p><hr/>';
		$message .= '<p><strong>Reason:</strong><em> ' . $reason . '</em></p>';
		$message .= '<hr/><p>Please <a href="' . $site_url . '/contact-us.php">contact the site admins</a> to discuss the matter further.</p>';
		$message .= '<p>- ' . $site_name . ' Admins</p>';
		$message .= '<small>You are receiving this email because it is marked as the admin contact for a team participating in a ' . $site_name . ' Tournament. If this is incorrect, please respond to this email.</small>';
		$message .= "</body></html>";

			require_once "Mail.php";
			$mandrill_username = $email_data['0']['mandrill_username'];
			$mandrill_password = $email_data['0']['mandrill_password']; 
			if( class_exists( 'Mail' ) && ( $mandrill_username != '' && $mandrill_password != '' ) ) { 
				$host = "smtp.mandrillapp.com"; 
				$username = $mandrill_username; 
				$password = $mandrill_password;
				$headers = array ('From' => $from,   'To' => $to, 'MIME-Version' => '1.0', 'Content-Type' => 'text/html; charset=ISO-8859-1', 'Subject' => $subject); 
				$smtp = Mail::factory(
								'smtp',   
								array (
									'host' => $host,     
									'auth' => true,
									'port' => 587,     
									'username' => $username,     
									'password' => $password
									)
								);  
				$mail = $smtp->send($to, $headers, $message);  
				if (PEAR::isError($mail)) {   
					echo("<p>" . $mail->getMessage() . "</p>");  
				} else {   
					echo("<p>Message successfully sent!</p>");  
				}
			} else {
				if( mail($to, $subject, $message, $headers) ) {
					$this->success('Thank you, your message has been sent');
				} else {
					$this->error('There was a problem sending your message, please try again');
				}
			}

		return;

	}

	/*
	 * Remove a team from a tournament
	 *
	 * @return string
	 */
	public function quit_tournament($tournament_id, $team_id) {

		$tournaments = $this->get_team_tournaments( $team_id );
		if( $tournaments ) {
			$tournaments = explode( ',', $tournaments );
			if(($key = array_search($tournament_id, $tournaments)) !== false) {
			    unset($tournaments[$key]);
			    $updated_tournaments = implode( ',', $tournaments );
			    $this->link->query("UPDATE `" . $this->prefix . "guilds` SET tournaments = '$updated_tournaments' WHERE id = '$team_id'");
			} else {
				$this->error('There was a problem removing this team from the tournament');
			}
		} else {
			echo 'fail';
			return;
		}

	}

	/*
	 * Get the list of tournaments a guild is participating in
	 *
	 * @return array
	 */
	public function get_team_tournaments($team_id) {

		$data = $this->fetch("SELECT tournaments FROM `" . $this->prefix . "guilds` WHERE id = '$team_id'");
		if( $data ) {
			$tournaments = $data['0']['tournaments'];
			return $tournaments;
		} else {
			return;
		}

	}

	/*
	 * Check if tournament bracket round 1 has been set
	 *
	 * @return boolean
	 */
	public function check_bracket($tournament_id) {

		$data = $this->fetch("SELECT round, tid FROM `" . $this->prefix . "tournament_matches` WHERE (tid = '$tournament_id') AND (round = '2')");
		if( $data ) {
			return true;
		} else {
			return false;
		}

	}

	/*
	 * Check if a tournament bracket has started
	 *
	 * @return boolean
	 */
	public function check_if_started($tournament_id) {
		$data = $this->fetch("SELECT round, completed, tid FROM `" . $this->prefix . "tournament_matches` WHERE (tid = '$tournament_id') AND (round = '1') AND (completed = '1')");
		if( $data ) {
			return true;
		} else {
			return false;
		}

	}

}

?>