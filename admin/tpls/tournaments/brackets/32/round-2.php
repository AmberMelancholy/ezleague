<?php $round2 = $ez_tournament->get_tournament_matchups( $tournament_id, '2' ); ?>
<?php if( $round2 ) { ?>
		<li class="spacer">&nbsp;</li>
		<!-- wrap score inside span element -->
		<li class="game game-top <?php echo ( $round2[0]['winner'] == $round2[0]['home_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[0]['home_team'] . ' - ' . $round2[0]['home_score']; ?></li>
		<li class="game game-spacer"><a href="tournament-match.php?id=<?php echo $round2[0]['id']; ?>">Edit Match</a></li>
		<li class="game game-bottom <?php echo ( $round2[0]['winner'] == $round2[0]['away_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[0]['away_team'] . ' - ' . $round2[0]['away_score']; ?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top <?php echo ( $round2[1]['winner'] == $round2[1]['home_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[1]['home_team'] . ' - ' . $round2[1]['home_score']; ?></li>
		<li class="game game-spacer"><a href="tournament-match.php?id=<?php echo $round2[1]['id']; ?>">Edit Match</a></li>
		<li class="game game-bottom <?php echo ( $round2[1]['winner'] == $round2[1]['away_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[1]['away_team'] . ' - ' . $round2[1]['away_score']; ?></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top <?php echo ( $round2[2]['winner'] == $round2[2]['home_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[2]['home_team'] . ' - ' . $round2[2]['home_score']; ?></li>
		<li class="game game-spacer"><a href="tournament-match.php?id=<?php echo $round2[2]['id']; ?>">Edit Match</a></li>
		<li class="game game-bottom <?php echo ( $round2[2]['winner'] == $round2[2]['away_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[2]['away_team'] . ' - ' . $round2[2]['away_score']; ?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top <?php echo ( $round2[3]['winner'] == $round2[3]['home_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[3]['home_team'] . ' - ' . $round2[3]['home_score']; ?></li>
		<li class="game game-spacer"><a href="tournament-match.php?id=<?php echo $round2[3]['id']; ?>">Edit Match</a></li>
		<li class="game game-bottom <?php echo ( $round2[3]['winner'] == $round2[3]['away_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[3]['away_team'] . ' - ' . $round2[3]['away_score']; ?></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top <?php echo ( $round2[4]['winner'] == $round2[4]['home_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[4]['home_team'] . ' - ' . $round2[4]['home_score']; ?></li>
		<li class="game game-spacer"><a href="tournament-match.php?id=<?php echo $round2[4]['id']; ?>">Edit Match</a></li>
		<li class="game game-bottom <?php echo ( $round2[4]['winner'] == $round2[4]['away_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[4]['away_team'] . ' - ' . $round2[4]['away_score']; ?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top <?php echo ( $round2[5]['winner'] == $round2[5]['home_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[5]['home_team'] . ' - ' . $round2[5]['home_score']; ?></li>
		<li class="game game-spacer"><a href="tournament-match.php?id=<?php echo $round2[5]['id']; ?>">Edit Match</a></li>
		<li class="game game-bottom <?php echo ( $round2[5]['winner'] == $round2[5]['away_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[5]['away_team'] . ' - ' . $round2[5]['away_score']; ?></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top <?php echo ( $round2[6]['winner'] == $round2[6]['home_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[6]['home_team'] . ' - ' . $round2[6]['home_score']; ?></li>
		<li class="game game-spacer"><a href="tournament-match.php?id=<?php echo $round2[6]['id']; ?>">Edit Match</a></li>
		<li class="game game-bottom <?php echo ( $round2[6]['winner'] == $round2[6]['away_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[6]['away_team'] . ' - ' . $round2[6]['away_score']; ?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top <?php echo ( $round2[7]['winner'] == $round2[7]['home_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[7]['home_team'] . ' - ' . $round2[7]['home_score']; ?></li>
		<li class="game game-spacer"><a href="tournament-match.php?id=<?php echo $round2[7]['id']; ?>">Edit Match</a></li>
		<li class="game game-bottom <?php echo ( $round2[7]['winner'] == $round2[7]['away_team_id'] ? 'winner' : '' ); ?>"><?php echo $round2[7]['away_team'] . ' - ' . $round2[7]['away_score']; ?></li>

		<li class="spacer">&nbsp;</li>
<?php } else { ?>
		<li class="spacer">&nbsp;</li>
				
		<li class="game game-top"></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top"></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top"></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top"></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top"></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top"></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top"></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "></li>

		<li class="spacer">&nbsp;</li>

		<li class="game game-top"></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "></li>

		<li class="spacer">&nbsp;</li>
<?php } ?>