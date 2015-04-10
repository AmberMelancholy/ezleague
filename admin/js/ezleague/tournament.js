/**
 * Create tournament date pickers
 */
$(function() {
	$( "#start" ).datepicker( "option", "dateFormat", "yy-mm-dd" );	
	$( "#start" ).datepicker();
});

$(function() {
	$( "#end" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	$( "#end" ).datepicker();
});

$(function() {
	$( "#registration" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	$( "#registration" ).datepicker();
});

/**
 * Create tournament
 */
$('#createTournament').submit(function(e) {
	var game			= $("#game").val();
		max_teams  		= $("#max-teams").val();
		tournament		= $("#tournament").val();
		start_date 		= $("#start").val();
		registration 	= $("#registration").val();
		format 			= $("#format").val();
		
	 e.preventDefault();

 $.ajax({
     type: "POST",
     url: "lib/submit/submit-tournament.php",
     async:true,
     crossbrowser:true,
     data: { form: 'create-tournament', start: '' + start_date + '', registration: '' + registration + '', max_teams: '' + max_teams + '', tournament: '' + tournament + '', game: '' + game + '', format: '' + format + '' }
   }).success(function( msg ) {
	   		$('.success').css("display", "");
	   		$(".success").fadeIn(1000, "linear");
	   		$('.success_text').fadeIn("slow");
	   		$('.success_text').html(msg);
	   		setTimeout(function(){location.reload()},3000);
  });
});

/**
 * Edit tournament
 */
$('#editTournament').submit(function(e) {
	var tournament_id	= $("#tournament-id").val();
		tournament 		= $("#tournament").val();
		max_teams  		= $("#max-teams").val();
		format 			= $("#format").val();
		start_date 		= $("#start").val();
		registration 	= $("#registration").val();
		
	 e.preventDefault();

 $.ajax({
     type: "POST",
     url: "lib/submit/submit-tournament.php",
     async:true,
     crossbrowser:true,
     data: { form: 'edit-tournament', start: '' + start_date + '', registration: '' + registration + '', max_teams: '' + max_teams + '', format: '' + format + '', tournament_id: '' + tournament_id + '', tournament: '' + tournament + '' }
   }).success(function( msg ) {
	   		$('.success').css("display", "");
	   		$(".success").fadeIn(1000, "linear");
	   		$('.success_text').fadeIn("slow");
	   		$('.success_text').html(msg);
	   		setTimeout(function(){location.reload()},3000);
  });
});

/**
 * Delete tournament
 * @param tournament_id
 */
function deleteTournament(tournament_id) {
	
	 $(function() {
		 $( "#delete-tournament-confirm" ).dialog({
			 resizable: false,
			 height:200,
			 modal: true,
			 buttons: {
				 "Delete Tournament": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-tournament.php",
					     data: { form: 'delete-tournament', tournament_id: '' + tournament_id + ''}
					   }).success(function( msg ) {
								    $(".success").css("display", "");
							   		$(".success").fadeIn(1000, "linear");
							   		$(".success_text").fadeIn("slow");
							   		$(".success").html(msg);
							   		setTimeout(function(){location.reload()},3000);
					  });
					 
					 $( this ).dialog( "close" );
				 },
				 Cancel: function() {
					 $( this ).dialog( "close" );
				 }
			 }
		 });
	});
	 
}

/**
 * Set map for a league week
 * @param league_id
 * @param week
 * @param map
 */
function setMap(league_id, week, map) {

	$.ajax({
	     type: "POST",
	     url: "lib/submit/submit-tournament.php",
	     async:true,
	     crossbrowser:true,
	     data: { form: 'set-map', league: '' + league_id + '', week: '' + week + '', map: '' + map + '' }
	   }).success(function( msg ) {
		   		$('.success').css("display", "");
		   		$(".success").fadeIn(1000, "linear");
		   		$('.success_text').fadeIn("slow");
		   		$('.success_text').html(msg);
		   		setTimeout(function(){location.reload()},3000);
	  });
	
}

/**
 * Add map to league
 */
$('#addMap').submit(function(e) {
	var map				= $("#map").val();
		league_id  		= $("#league_id").val();
		
	 e.preventDefault();

 $.ajax({
     type: "POST",
     url: "lib/submit/submit-tournament.php",
     async:true,
     crossbrowser:true,
     data: { form: 'add-map', map: '' + map + '', league_id: '' + league_id + '' }
   }).success(function( msg ) {
	   		$('.success').css("display", "");
	   		$(".success").fadeIn(1000, "linear");
	   		$('.success_text').fadeIn("slow");
	   		$('.success_text').html(msg);
	   		setTimeout(function(){location.reload()},3000);
  });
});

/**
 * Edit league rules
 */
$('#editRules').submit(function(e) {
	var body			= CKEDITOR.instances['body'].getData();
		league_id  		= $("#league_id").val();
		
		e.preventDefault();
		body = str_replace("&#39;", "\'", body);

 $.ajax({
     type: "POST",
     url: "lib/submit/submit-tournament.php",
     async:true,
     crossbrowser:true,
     data: { form: 'edit-rules', body: '' + body + '', league_id: '' + league_id + '' }
   }).success(function( msg ) {
	   		$('.success').css("display", "");
	   		$(".success").fadeIn(1000, "linear");
	   		$('.success_text').fadeIn("slow");
	   		$('.success_text').html(msg);
	   		setTimeout(function(){location.reload()},3000);
  });
});

/**
 * Lock league rosters
 */
 function rostersLock(league_id) {

 	$.ajax({
	     type: "POST",
	     url: "lib/submit/submit-tournament.php",
	     async:true,
	     crossbrowser:true,
	     data: { form: 'lock-rosters', league_id: '' + league_id + '' }
	   }).success(function( msg ) {
		   		$('.success').css("display", "");
		   		$(".success").fadeIn(1000, "linear");
		   		$('.success_text').fadeIn("slow");
		   		$('.success_text').html(msg);
		   		setTimeout(function(){location.reload()},3000);
	  });

 }

/**
 * Lock league rosters
 */
 function rostersUnLock(league_id) {

 	$.ajax({
	     type: "POST",
	     url: "lib/submit/submit-tournament.php",
	     async:true,
	     crossbrowser:true,
	     data: { form: 'unlock-rosters', league_id: '' + league_id + '' }
	   }).success(function( msg ) {
		   		$('.success').css("display", "");
		   		$(".success").fadeIn(1000, "linear");
		   		$('.success_text').fadeIn("slow");
		   		$('.success_text').html(msg);
		   		setTimeout(function(){location.reload()},3000);
	  });

 }

/**
 * Kick team from tournament modal popup
 * @param league_id
 * @param team_id
 */
function kickTeam(team_id, tournament_id) {

	$(function() {
		 $( "#kick-team-confirm" ).dialog({
			 resizable: false,
			 height:220,
			 width:375,
			 modal: true,
			 buttons: {
				 "Kick Team": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-tournament.php",
					     data: { form: 'kick-team', team_id: '' + team_id + '', tournament_id: '' + tournament_id + '' }
					   }).success(function( msg ) {
								    $(".team").css("display", "");
							   		$(".team").fadeIn(1000, "linear");
							   		$(".team_text").fadeIn("slow");
							   		$(".team").html(msg);
							   		setTimeout(function(){location.reload()},3000);
					  });
					 
					 $( this ).dialog( "close" );
				 },
				 Cancel: function() {
				 	$('.modal').css('z-index', '1050');
	 				$('.modal-backdrop').css('position', 'relative');
					 $( this ).dialog( "close" );
				 }
			 }
		 });
	});
	
}

 /**
 * Generate tournament round 1 matches
 * @param tournament_id
 */
$('#generateMatches').click(function() {

	var tournament_id = $('#generateMatches').data('tournament-id');
		tournament_teams = $('#generateMatches').data('tournament-teams');

	$.ajax({
		type: "POST",
		url: "generate_bracket.php",
		data: { form: 'generate-matches', tournament_id: '' + tournament_id + '', max_teams: '' + tournament_teams + '' }
	}).success(function( msg ) {
		$("#clearMatches").removeAttr('style');
		$(".round-1").fadeIn(1000, "linear");
		$(".round-1").html(msg);
		//setTimeout(function(){location.reload()},3000);
	});

});

 /**
 * Clear previously generated matches
 * @param tournament_id
 */
$('#clearMatches').click(function() {

	var tournament_id = $('#generateMatches').data('tournament-id');

	$.ajax({
		type: "POST",
		url: "generate_bracket.php",
		data: { form: 'clear-matches', tournament_id: '' + tournament_id + '' }
	}).success(function( msg ) {
		$(".round-1").fadeIn(1000, "linear");
		$("#clearMatches").css('display', 'none');
		$(".game-top").text('');
		$(".game-bottom").text('');
		//setTimeout(function(){location.reload()},3000);
	});

});

/**
 * Unkick a team from a league
 * @param league_id
 * @param team_id
 */
 function unkickTeam(league_id, team_id) {
	
	$.ajax({
	     type: "POST",
	     url: "lib/submit/submit-tournament.php",
	     async:true,
	     crossbrowser:true,
	     data: { form: 'unkick-team', league_id: '' + league_id + '', team_id: '' + team_id + '' }
	   }).success(function( msg ) {
		   		$('.success').css("display", "");
		   		$(".success").fadeIn(1000, "linear");
		   		$('.success_text').fadeIn("slow");
		   		$('.success_text').html(msg);
		   		setTimeout(function(){location.reload()},3000);
	  });
	
}

/**
 * Search and replace specifically used for CKEDITOR values to handle single quotes
 * 
 * @param search
 * @param replace
 * @param subject
 * @param count
 * @returns
 */		
function str_replace(search, replace, subject, count) {
	  var i = 0,
	    j = 0,
	    temp = '',
    repl = '',
    sl = 0,
    fl = 0,
    f = [].concat(search),
    r = [].concat(replace),
    s = subject,
    ra = Object.prototype.toString.call(r) === '[object Array]',
    sa = Object.prototype.toString.call(s) === '[object Array]';
  s = [].concat(s);
  if (count) {
    this.window[count] = 0;
  }
  for (i = 0, sl = s.length; i < sl; i++) {
    if (s[i] === '') {
      continue;
    }
    for (j = 0, fl = f.length; j < fl; j++) {
      temp = s[i] + '';
      repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
      s[i] = (temp)
        .split(f[j])
        .join(repl);
      if (count && s[i] !== temp) {
        this.window[count] += (temp.length - s[i].length) / f[j].length;
      }
    }
  }
  return sa ? s : s[0];
}