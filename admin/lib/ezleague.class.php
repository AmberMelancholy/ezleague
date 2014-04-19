<?php session_start();

	class ezLeague extends DB_Class {
		
/*
 * START LOGIN & REGISTRATION FUNCTIONALITY
 */
		
		function login($username, $password) {
			$saltData = $this->fetch("SELECT salt, hash FROM `" . $this->prefix . "users` 
									  WHERE (username = '$username') AND (role = 'admin')
								    ");
			 $salt = $saltData['0']['salt'];
			 $hash = $saltData['0']['hash'];
			  $hashCheck = crypt($password, $hash);
			  
			  if($hashCheck === $hash) {
				  	$_SESSION['ez_admin'] = $username;
				  	print "Logging in...";
  				} else {
  					print "Incorrect username or password";
  				}
		}
		
		function register($username, $password, $email) {
			$strength = '5';
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
			//blowfish algorithm
			$salt = sprintf("$2a$%02d$", $strength) . $salt;
			$hash = crypt($password, $salt);
			//check to make sure this username or email does not already exist
			$result = $this->link->query("SELECT * FROM `" . $this->prefix . "users` WHERE (username = '$username') OR (email = '$email')");
			$count = $this->numRows($result);
			if($count > 0) {
				print "<strong>Error</strong> Username or E-Mail already exists";
			} else {
				$this->link->query("INSERT INTO `" . $this->prefix . "users` SET username = '$username', email = '$email', salt = '$salt',
						hash = '$hash', role = 'user'
						");
				print "<strong>Success!</strong> Account has been created. You may now login.";
			}
		
		}
		
		function getUserSettings($username) {
			$data = $this->fetch("SELECT id, email FROM `" . $this->prefix . "users` WHERE username = '$username'");
			 $settings = array(
			 					'id' 	=> $data['0']['id'],
			 					'email' => $data['0']['email']
			 				  );
			  return $settings;
		}
		
		function checkForAdmins() {
			$result = $this->link->query("SELECT id FROM `" . $this->prefix . "users` WHERE role = 'admin'");
			 $count = 0;
			 $count = $this->numRows($result);
			  return $count;
		}
		
		function createAdmin($username, $password, $email) {
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
			$salt = sprintf("$2a$%02d$", 5) . $salt;
			$hash = crypt($password, $salt);
				
			$result = $this->link->query("SELECT * FROM `" . $this->prefix . "users` WHERE (username = '$username') AND (role = 'admin')");
			  $count = $this->numRows($result);
				if($count > 0) {
					print "<strong>Error</strong> Username already exists";
				} else {
					$this->link->query("INSERT INTO `" . $this->prefix . "users` SET username = '$username', email = '$email', salt = '$salt', 
								  hash = '$hash', role = 'admin'
								");
					 print "<strong>Success!</strong> Account has been created. You may now login.";
				}
				
		}
		
		function changePassword($id, $password) {
			$strength = '5';
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
			//blowfish algorithm
			$salt = sprintf("$2a$%02d$", $strength) . $salt;
			$hash = crypt($password, $salt);
		
			  $this->link->query("UPDATE `" . $this->prefix . "users` SET salt = '$salt', hash = '$hash'
								  WHERE id = '$id'
								 ");
				print "<strong>Success!</strong> Account has been created. You may now login.";
		
		}
		
		function updateEmail($id, $email) {
			$this->link->query("UPDATE `" . $this->prefix . "users` SET email = '$email'
							    WHERE id = '$id'
							   ");
				print "<strong>Success!</strong> Account has been created. You may now login.";
		}
		
		function getAdmins() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "users` WHERE role = 'admin'");
			 return $data;
		}
		
		
/*
 * END LOGIN & REGISTRATION FUNCTIONALITY
 */		
		
/*
 * START ADMIN DASHBOARD
 */		
		
		function getRecentUsers($total) {
			$data = $this->fetch("SELECT id, username, email, created FROM `" . $this->prefix . "users` ORDER BY id DESC LIMIT $total");
			 return $data;
		}
		
		function getRecentTeams($total) {
			$data = $this->fetch("SELECT guild, abbreviation, gm, id FROM `" . $this->prefix . "guilds` ORDER BY id DESC LIMIT $total");
			 return $data;
		}
		
		function getTotal($table) {
			switch($table) {
				case 'users':
					$table = 'users';
				 break;
				case 'teams':
					$table = 'guilds';
				 break;
				case 'leagues':
					$table = 'leagues';
				 break;
			}
			
			$result = $this->link->query("SELECT id FROM `" . $this->prefix . "$table`");
			 $count = $this->numRows($result);
			  return $count;
		}
		
/*
 * END ADMIN DASHBOARD
 */		
		
/*  
 * START NEWS FUNCTIONALITY
 */
		
		function addNews($title, $body, $author, $category, $game, $published) {
			$body = $this->link->real_escape_string($body);
			$title = $this->link->real_escape_string($title);
			 $this->link->query("INSERT INTO `" . $this->prefix . "news` SET title = '$title', body = '$body', author = '$author', 
			 					 category = '$category', game = '$game', published = '$published'
			 			 	   ");
			 	if($published == 0) {
			 		print "<strong>Success!</strong> Draft has been saved...redirecting";
			 	} else {
			 		print "<strong>Success!</strong> Post has been published";
			 	}
			 	return;
		}
		
		function editNews($id, $title, $body, $author, $category, $game, $published) {
			$body = $this->link->real_escape_string($body);
			$title = $this->link->real_escape_string($title);
			 $this->link->query("UPDATE `" . $this->prefix . "news` SET title = '$title', body = '$body', author = '$author',
								 category = '$category', game = '$game', published = '$published'
			 					 WHERE id = '$id'
							   ");
				if($published == 0) {
					print "<strong>Success!</strong> Draft has been saved...redirecting";
				} else {
					print "<strong>Success!</strong> Post has been published";
				}
				return;
		}
		
		function unpublishPost($id) {
			$this->link->query("UPDATE `" . $this->prefix . "news` SET published = '0' WHERE id = '$id'");
			  print "<strong>Success!</strong> Post has been unpublished";
				return;
		}
		
		function addNewsCategory($category) {
			$result = $this->link->query("SELECT category FROM `" . $this->prefix . "news_category` WHERE category = '$category'");
			 $count = $this->numRows($result);
			  if($count > 0) {
			  	echo "<strong>Error</strong> Category already exists";
			  } else {
				$category = $this->link->real_escape_string($category);
				 $this->link->query("INSERT INTO `" . $this->prefix . "news_category` SET category = '$category'");
				  print "<strong>Success!</strong> $category Category added...reloading";
			  }
			  	return;
		}
		
		function deleteNewsCategory($id) {
			$this->link->query("DELETE FROM `" . $this->prefix . "news_category` WHERE id = '$id'");
			 print "<strong>Success!</strong> Category has been deleted...reloading";
			  	return;
		}
		
		function getNewsCategories() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "news_category`");
			 return $data;
		}
		
		function getNewsAuthors() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "users` WHERE role = 'admin'");
			 return $data;
		}
		
		function getAllNews() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "news`");
			 return $data;
		}
		
		function getNewsPost($id) {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "news` WHERE id = '$id'");
			 return $data;
		}
		

/*
 * END NEWS FUNCTIONALITY
 */
		
/*
 * START MATCHES FUNCTIONALITY
 */
		
		function getMatches($league_id) {
			$data = $this->fetch("SELECT t.id, t.challenger, t.league_id, t.match_date, t.created, t.completed, t.challengee_accepted, t.challenger_accepted, t.challenger_score, t.challengee_score, t.g_challenger, t.challengee, g2.guild AS g_challengee
								  FROM (
								    SELECT c1.id, c1.challenger, c1.created, c1.match_date, c1.league_id, c1.completed, c1.challengee_accepted, c1.challenger_accepted, c1.challenger_score, c1.challengee_score, g1.guild AS g_challenger, c1.challengee
								    FROM " . $this->prefix . "guilds g1
								    JOIN " . $this->prefix . "challenges c1
								    ON g1.id = c1.challenger
								  ) t 
								  JOIN guilds g2
								  ON g2.id = t.challengee
								  WHERE (t.league_id = '$league_id') AND (t.challengee_accepted != 2 AND t.challenger_accepted != 2)
								  ORDER BY t.created DESC	
								");
					
			return $data;
		}
		
		function getMatch($id) {
			$data = $this->fetch("SELECT t.id, t.challenger, t.league_id, t.match_date, t.match_hour, t.match_min, t.match_pod, t.match_zone, t.chat_log, t.created, t.completed, t.challengee_accepted, t.challenger_accepted, t.challenger_score, t.challengee_score, t.g_challenger, t.challengee, g2.guild AS g_challengee
								  FROM (
								    SELECT c1.id, c1.challenger, c1.created, c1.match_date, c1.match_hour, c1.match_min, c1.match_pod, c1.match_zone, c1.chat_log, c1.league_id, c1.completed, c1.challengee_accepted, c1.challenger_accepted, c1.challenger_score, c1.challengee_score, g1.guild AS g_challenger, c1.challengee
								    FROM " . $this->prefix . "guilds g1
								    JOIN " . $this->prefix . "challenges c1
								    ON g1.id = c1.challenger
								  ) t 
								  JOIN guilds g2
								  ON g2.id = t.challengee
								  WHERE t.id = '$id'
								");
			$match_details = array (
									'cid' 			   	  => $data['0']['id'],
									'league_id'		  	  => $data['0']['league_id'],
									'challenger_id'       => $data['0']['challenger'],
									'challenger'	      => $data['0']['g_challenger'],
									'challenger_score'    => $data['0']['challenger_score'],
									'challenger_accepted' => $data['0']['challenger_accepted'],
									'challengee_id'	      => $data['0']['challengee'],
									'challengee'	      => $data['0']['g_challengee'],
									'challengee_score'    => $data['0']['challengee_score'],
									'challengee_accepted' => $data['0']['challengee_accepted'],
									'match_date'	      => $data['0']['match_date'],
									'match_hour'	      => $data['0']['match_hour'],
									'match_min'		      => $data['0']['match_min'],
									'match_pod'		      => $data['0']['match_pod'],
									'match_zone'	      => $data['0']['match_zone'],
									'chat_log'		      => $data['0']['chat_log'],
									'created'		      => $data['0']['created'],
									'completed'		      => $data['0']['completed']
								  );
				return $match_details;
		}
		
		function editMatch($match_id, $challenger_score, $challenger_status, $challengee_score, $challengee_status) {
			$this->link->query("UPDATE `" . $this->prefix . "challenges` SET challenger_score = '$challenger_score', 
										challenger_accepted = '$challenger_status', challengee_score = '$challengee_score',
										challengee_accepted = '$challengee_status'
								WHERE id = '$match_id'
							  "); 
			  print "<strong>Success!</strong> Match Details have been updated...reloading";
				return;
		}
		
		function getDisputes() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "disputes`");
			 	return $data;
		}
		
		function getDispute($id) {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "disputes` WHERE challenge_id = '$id'");
			 return $data;
		}
		
		function updateDispute($id, $status) {
			$this->link->query("UPDATE `" . $this->prefix . "disputes` SET status = '$status' WHERE id = '$id'");
			 print "<strong>Success!</strong> Dispute status has been updated";
			 return;
		}

/*
 * END MATCHES FUNCTIONALITY
 */		
		
/*
 * START LEAGUE FUNCTIONALITY
 */	
		
		function getLeaguesAll() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "leagues` ORDER BY game DESC");
			 return $data;
		}
		
		function addLeague($league, $game, $teams, $start, $end, $games) {
			$result = $this->link->query("SELECT league FROM `" . $this->prefix . "leagues` WHERE (league = '$league') AND (game = '$game')");
			 $count = $this->numRows($result);
			  if($count > 0) {
				  echo "<strong>Error</strong> League Name already exists";
			  } else {
				  $league = $this->link->real_escape_string($league);
				  $this->link->query("INSERT INTO `" . $this->prefix . "leagues` SET league = '$league', game = '$game', teams = '$teams',
				  					  start_date = '$start', end_date = '$end', total_games = '$games'");
				  print "<strong>Success!</strong> $league League added...reloading";
			  }
				return;
		}
		
		function deleteLeague($id) {
			$this->link->query("DELETE FROM `" . $this->prefix . "leagues` WHERE id = '$id'");
			 print "<strong>Success!</strong> League has been deleted...reloading";
			 	return;
		}
		
		function getLeagueRules($id) {
			$data = $this->fetch("SELECT league, rules FROM `" . $this->prefix . "leagues` WHERE id = '$id'");
			 $league = array(
			 					'league' => $data['0']['league'],
			 					'rules'  => $data['0']['rules']
			 				);
			 	return $league;
		}
		
		function getLeagueName($league_id) {
			$data = $this->fetch("SELECT league FROM `" . $this->prefix . "leagues` WHERE id = '$league_id'");
			 $league = $data['0']['league'];
				return $league;
		}
		
		function getLeagueDisputes($league_id) {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "disputes` WHERE status = '0'");
				return $data;
		}
		

/*
 * END LEAGUE FUNCTIONALITY
 */		
		
/*
 * START USERS FUNCTIONALITY
 */		
		
		function getUsersAll() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "users` ORDER BY created DESC");
				return $data;
		}
		
		function getUser($id) {
			$data = $this->fetch("SELECT t.id, t.username, t.email, t.guild, t.role, t.created, t.status, t.guild_name, t.guild_admin
								  FROM (
								  	SELECT c1.id, c1.username, c1.email, c1.guild, c1.role, c1.created, c1.status, g1.id AS guild_id, g1.guild AS guild_name, g1.admin AS guild_admin
								  	FROM " . $this->prefix . "guilds g1
								  	JOIN " . $this->prefix . "users c1
								  	ON g1.id = c1.guild
								  ) t 
								  WHERE t.id = '$id'
								  ORDER BY t.created DESC	
								");
			 if(empty($data)) {
			 	$data = $this->fetch("SELECT * FROM `" . $this->prefix . "users` WHERE id = '$id'");
			 	
			 	$user = array(
					 			'id' 	   	 => $data['0']['id'],
					 			'username'	 => $data['0']['username'],
					 			'email'	   	 => $data['0']['email'],
					 			'guild_id'   => '',
					 			'role'	     => $data['0']['role'],
					 			'created'    => $data['0']['created'],
					 			'guild_name' => 'None',
					 			'status'     => $data['0']['status']
			 				);
			 } else {
			 
				 $user = array(
				 				'id' 	   	  => $data['0']['id'],
				 				'username'	  => $data['0']['username'],
				 				'email'	   	  => $data['0']['email'],
				 				'guild_id'    => $data['0']['guild'],
				 				'role'	      => $data['0']['role'],
				 				'created'     => $data['0']['created'],
				 				'guild_name'  => $data['0']['guild_name'],
				 				'guild_admin' => $data['0']['guild_admin'],
				 				'status'      => $data['0']['status']
				 			  );
			 }
			 
			 return $user;
		}
		
		function toggleSuspendUser($id, $status) {
			$this->link->query("UPDATE `" . $this->prefix . "users` SET status = '$status' WHERE id = '$id'");
			 print "<strong>Success!</strong> User Status has been updated...reloading";
			 return;
		}
		
		function toggleRoleUser($id, $role) {
			$this->link->query("UPDATE `" . $this->prefix . "users` SET role = '$role' WHERE id = '$id'");
			 print "<strong>Success!</strong> User Role has been updated...reloading";
			 return;
		}
		
		function deleteUser($id) {
			$this->link->query("DELETE FROM `" . $this->prefix . "users` WHERE id = '$id'");
			 print "<strong>Success!</strong> User Account has been deleted...reloading";
			 return;
		}
		
		function searchUsers($string) {
			$data = $this->fetch("SELECT * FROM `users` WHERE (username LIKE '%$string%') OR (email LIKE '%$string%')");
			 return $data;
		}

/*
 * END USER FUNCTIONALITY
 */
		
/*
 * START TEAM FUNCTIONALITY
 */		
		
		function getTeams() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "guilds` ORDER BY game");
			 return $data;
		}
		
		function getTeam($id) {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "guilds` WHERE id = '$id'");
			 $team = array(
							'id'	  => $data['0']['id'],
							'name'    => $data['0']['guild'],
							'abbr'    => $data['0']['abbreviation'],
							'gm'      => $data['0']['gm'],
							'agm'     => $data['0']['agm'],
							'site'    => $data['0']['website'],
							'admin'   => $data['0']['admin'],
							'elo'     => $data['0']['elo'],
							'game'    => $data['0']['game'],
							'leagues' => $data['0']['leagues']
						  );
			  return $team;
		}
		
		function getTeamMatches($id) {
			
		}
		
		function getTeamRoster($id) {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "users` WHERE guild = '$id'");
			 return $data;
		}
/*
 * END TEAM FUNCTIONALITY
 */		
		
/*
 * START SETTINGS FUNCTIONALITY
 */		
		
		function addSettingsGame($game, $slug) {
			$result = $this->link->query("SELECT game FROM `" . $this->prefix . "games` WHERE (game = '$game') OR (slug = '$slug')");
			  $count = $this->numRows($result);
			  if($count > 0) {
				  echo "<strong>Error</strong> Game already exists";
			  } else {
				  $game = $this->link->real_escape_string($game);
				  $this->link->query("INSERT INTO `" . $this->prefix . "games` SET game = '$game', slug = '$slug'");
				  print "<strong>Success!</strong> $game ($slug) added...reloading";
			  }
				return;
		}
		
		function deleteSettingsGame($id) {
			$this->link->query("DELETE FROM `" . $this->prefix . "games` WHERE id = '$id'");
			 print "<strong>Success!</strong> Game has been deleted...reloading";
			 	return;
		}
		
		function getSettingsGames() {
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "games`");
			 	return $data;
		}
		
		function siteSettingsName($name) {
		   $name = $this->link->real_escape_string($name);
			$current_settings = ezLeague::getSiteSettings();
			 if($current_settings['name'] == '' && $current_settings['url'] == '') {
			 	$this->link->query("INSERT INTO `" . $this->prefix . "settings` SET site_name = '$name'");
			 } else {
			 	$this->link->query("UPDATE `" . $this->prefix . "settings` SET site_name = '$name' WHERE id = '1'");
			 }
			 print "<strong>Success!</strong> Site Name updated...reloading";
				return;
		}
		
		function siteSettingsURL($url) {
		   $url = $this->link->real_escape_string($url);
			$current_settings = ezLeague::getSiteSettings();
			if($current_settings['name'] == '' && $current_settings['url'] == '') {
			 	$this->link->query("INSERT INTO `" . $this->prefix . "settings` SET site_url = '$url'");
			 } else {
			 	$this->link->query("UPDATE `" . $this->prefix . "settings` SET site_url = '$url' WHERE id = '1'");
			 }
			 print "<strong>Success!</strong> Site URL updated...reloading";
			 	return;
		}
		
		function getSiteSettings() {
			$settings = array();
			$data = $this->fetch("SELECT * FROM `" . $this->prefix . "settings` WHERE id = '1'");
			 $settings = array('name' => $data['0']['site_name'], 'url' => $data['0']['site_url']);
			 	return $settings;
		}
		
/*
 * END SETTINGS FUNCTIONALITY
 */		
		
		
/*
 * START SPECIAL FUNCTIONS
 */
		/*
		 * ABOUT: Check if a specific key and value exist in an array
		 * USED IN: 
		 * Matches View -> Check if match has an open dispute [status = 0]
		 */	
		function multidimensional_search($parents, $searched) {
			if (empty($searched) || empty($parents)) {
				return false;
			}
		
			foreach ($parents as $key => $value) {
				$exists = true;
				foreach ($searched as $skey => $svalue) {
					$exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
				}
				if($exists){
					return true;
				}
			}
		
			return false;
		}
		
		function upgrade() {
			$this->link->query("ALTER TABLE `users` ADD COLUMN forget VARCHAR(250)");
			 print "Upgrade completed. Please delete <em>upgrade.php</em> from your server.";
		}
		
/*
 * END SPECIAL FUNCTIONS
 */		
	}
?>