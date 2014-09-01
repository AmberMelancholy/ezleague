/**
 * Kick member from team
 * @param member
 */
function kickMember(member) {
	
	 $(function() {
		 $( "#kick-member-confirm" ).dialog({
			 resizable: false,
			 height:200,
			 modal: true,
			 buttons: {
				 "Kick Member": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-team.php",
					     data: { form: 'team-kick-member', member: '' + member + ''}
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
 * Remove the current user avatar
 * @param user_id
 */
function removeAvatar(user_id) {
	
	$.ajax({
	     type: "POST",
	     url: "lib/submit/submit-user.php",
	     data: { form: 'remove-avatar', id: '' + user_id + ''}
	   }).success(function( msg ) {
				    $(".success").css("display", "");
			   		$(".success").fadeIn(1000, "linear");
			   		$(".success_text").fadeIn("slow");
			   		$(".success").html(msg);
			   		setTimeout(function(){location.reload()},3000);
	  });
	
}

/**
 * Send user a team invite
 * @param team_id
 * @param user_id
 */
function sendTeamInvite(team_id, user_id) {
	
	 $(function() {
		 $( "#team-invite-confirm" ).dialog({
			 resizable: false,
			 height:155,
			 modal: true,
			 buttons: {
				 "Invite Member": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-user.php",
					     data: { form: 'send-team-invite', tid: '' + team_id + '', uid: '' + user_id + ''}
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
 * Accept a team invite
 * @param team_id
 * @param user_id
 */
function acceptTeamInvite(team_id, user_id) {
	
	 $(function() {
		 $( "#accept-invite-confirm" ).dialog({
			 resizable: false,
			 height:200,
			 modal: true,
			 buttons: {
				 "Join Team": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-user.php",
					     data: { form: 'accept-team-invite', tid: '' + team_id + '', uid: '' + user_id + ''}
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
 * Leave a team
 * @param user_id
 */
function leaveTeam(user_id) {
	
	 $(function() {
		 $( "#leave-team-confirm" ).dialog({
			 resizable: false,
			 height:155,
			 modal: true,
			 buttons: {
				 "Leave Team": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-user.php",
					     data: { form: 'leave-team', uid: '' + user_id + ''}
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
 * Add user as friend
 * @param friend_id
 * @param user_id
 */
function addFriend(friend_id, user_id) {
	
	$(function() {
		 $( "#add-friend-confirm" ).dialog({
			 resizable: false,
			 height:155,
			 modal: true,
			 buttons: {
				 "Add Friend": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-user.php",
					     data: { form: 'add-friend', id: '' + user_id + '', friend_id: '' + friend_id + ''}
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
 * Remove user as friend
 * @param friend_id
 * @param user_id
 */
function removeFriend(friend_id, user_id) {
	
	$(function() {
		 $( "#remove-friend-confirm" ).dialog({
			 resizable: false,
			 height:155,
			 modal: true,
			 buttons: {
				 "Remove Friend": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-user.php",
					     data: { form: 'remove-friend', id: '' + user_id + '', friend_id: '' + friend_id + ''}
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
 * Delete match screenshot
 * @param match_id
 */
function deleteScreenshot(screenshot_id) {
	
	$(function() {
		 $( "#delete-screenshot-confirm" ).dialog({
			 resizable: false,
			 height:175,
			 modal: true,
			 buttons: {
				 "Delete Screenshot": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-league.php",
					     data: { form: 'delete-screenshot', id: '' + screenshot_id + '' }
					   }).success(function( msg ) {
								    $(".screens").css("display", "");
							   		$(".screens").fadeIn(1000, "linear");
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
 * Remove team logo
 * @param team_id
 */
function removeLogo(team_id) {

	$(function() {
		 $( "#remove-logo-confirm" ).dialog({
			 resizable: false,
			 height:175,
			 modal: true,
			 buttons: {
				 "Remove Logo": function() {
					 $.ajax({
					     type: "POST",
					     url: "lib/submit/submit-team.php",
					     data: { form: 'remove-logo', id: '' + team_id + ''}
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