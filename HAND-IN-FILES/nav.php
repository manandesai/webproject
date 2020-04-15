<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="nav.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <div id="abet">
                <a class="utk-abet" href="abet.php"><h2>UTK ABET</h2></a>
            </div>
            <div id="profile">
                <h2>
                <img class="person" src="person.png" alt="person.png">
                <img class="caret" src="caret-bottom-2x.png" alt="caret.png">
                <div id="userMenu">
                    <a href="#" id="changePassword">change password</a>
                    <a href="#" id="logout">log out</a>
                </div>
                </ul>
                </h2>
            </div>
            </header>
            <div id="container">
            <nav class="nav-container">
                <h1 class="container-section-title">Section:</h1>
                <div class="section-dropdown">
                <form method="GET">
                <select id="class-dropdown" class="course-dropdown" size="1">
                    <?php
                        for($x=0; $x < count($_SESSION['menuItems']); $x++){
                    ?>
                    <option value="<?php echo $_SESSION['major'][$x] . " " .$_SESSION['sectionId'][$x]; ?>"><?php echo $_SESSION['menuItems'][$x]?></option>
                    <?php
                        }
                    ?>
                </select>
                </form>
            </div>
            <div class="outcome-links">
                <hr class="new-hr">
            </div>
        </nav>

    </body>
    <script>
	/* This function is on initial load and takes care of first nav dropdown */
	$(function(){
        var selectedCourse = $("#class-dropdown").val().split(" ");
        console.log(selectedCourse[0] + " " + selectedCourse[1]);
		var ids = new Array();
		var descriptions = new Array();
		$.ajax({
			url: 'outcomes.php',
			method: 'get',
			dataType: 'JSON',
			data: {sectionId: selectedCourse[1], major: selectedCourse[0]},
			success:function(response){
                console.log("success response");
				var links = $(".outcome-links");
				for (var i = 0; i < response.length; i++){
					var outcomeId = response[i]["outcomeId"];
					ids[i] = outcomeId;
					var outcomeDescription = response[i]["outcomeDescription"];
					descriptions[i] = outcomeDescription;
					var referenceString = "abet.php?outcome=" + outcomeId;
					var anchorId = "outcomeRef-" + outcomeId + "sectionRef-" + selectedCourse[1] + "majorRef-" + selectedCourse[0];
					//need to give these dynamic, unique ID's and query strings -- see referenceString and anchorId
					var a = "<a class='section-outcome' id='"+anchorId+"'><div>" + "Outcome " + outcomeId + "</div></a><hr class='new-hr'>";
					links.append(a);
					$("#" + anchorId).attr('href', referenceString);
				}
				//var firstLink = $(".outcome-links a:eq(0)");
				//$(location).attr('href', firstLink);
				var description = $("#embedded-description");
				var getOutcome = window.location.href.slice(-1);
				for (var x = 0; x < ids.length; x++){
					if (ids[x] == getOutcome){
						var str = "<strong>Outcome " + getOutcome + " - " + selectedCourse[0] +  ": </strong>" + descriptions[x];
						description.html(str);
					}
				}
			},
			error:function(xhr, ajaxOptions, thrownError){
				console.log("failure");
				console.log(xhr.responseText);
				console.log(thrownError);
			}

		});
	});
	/* On dropdown change, empty old links and put new ones in */
	$(function(){
		$("#class-dropdown").change(function(e){
			e.preventDefault();
			var selectedCourse = $(this).val().split(" ");
			var ids = new Array();
			var descriptions = new Array();
			$.ajax({
				url: 'outcomes.php',
				method: 'get',
				dataType: 'JSON',
				data: {sectionId: selectedCourse[1], major: selectedCourse[0]},
				success:function(response){
					var links = $(".outcome-links");
					links.empty();
					links.append("<hr class='new-hr'>")
					for (var i = 0; i < response.length; i++){
						var outcomeId = response[i]["outcomeId"];
						ids[i] = outcomeId;
						var outcomeDescription = response[i]["outcomeDescription"];
						descriptions[i] = outcomeDescription;
						var referenceString = "abet.php?outcome=" + outcomeId;
						var anchorId = "outcomeRef-" + outcomeId + "sectionRef-" + selectedCourse[1] + "majorRef-" + selectedCourse[0];
						var a = "<a class='section-outcome' id='"+anchorId+"'><div>" + "Outcome " + outcomeId + "</div></a><hr class='new-hr'>";
						links.append(a);
						$("#" + anchorId).attr('href', referenceString);
					}	
					var description = $("#embedded-description");
					var getOutcome = window.location.href.slice(-1);
					for (var x = 0; x < ids.length; x++){
						if (ids[x] == getOutcome){
							var str = "<strong>Outcome " + getOutcome + " - " + selectedCourse[0] +  ": </strong>" + descriptions[x];
							description.html(str);
						}
					}
				},
				error:function(xhr, ajaxOptions, thrownError){
					console.log("failure");
					console.log(xhr.responseText);
					console.log(thrownError);
				}

			});

		});
    });
    /*password and stuff */
    $(document).ready(function(){
            $("#profile").click(function(){
                if($("#userMenu").css("display")=="none"){
                    $("#userMenu").css("display", "block");
                } else {
                    $("#userMenu").css("display", "none");
                }
            });

            $("#logout").click(function(){
                $(location).attr('href',"login.html");
            });

            $("#changePassword").click(function(){
                $(location).attr('href',"password.php");
                /*if($(".main-content").css("display")!="none"){
                    $(".main-content").css("display", "none");
                    $(".password-content").css("display", "block");
                }*/
            });
        });
	</script>
</html>