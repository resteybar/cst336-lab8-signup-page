<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AJAX: Sign Up Page</title>

        <style>
            @import url(css/styles.css);
        </style>

        <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
        <script>
            function validateForm() {
                return false;
            }
            
        </script>
        
        <script>
            
            $(document).ready( function(){
                
                var correctRecord = true;
                var userNameFilled = false;
                var pwFilled = false;
                
                $("#isCorrect").hide();
                $("#isPWDiff").hide();
                
                $("#username").change(function()
                {
                    //alert(  $("#username").val() );
                    $.ajax({

                        type: "GET",
                        url: "checkUsername.php",
                        dataType: "json",
                        data: { "username": $("#username").val() },
                        success: function(data,status) {

                            if (!data) {  //data == false
                                $("#isUNTaken").html("<div id='isUNTaken'>Username not taken</div>");
                                $("#isUNTaken").css("color","green");
                                userNameFilled = true;
                            } else {
                                $("#isUNTaken").html("<div id='isUNTaken'>Username taken</div>");
                                $("#isUNTaken").css("color","red");
                                userNameFilled = false;
                            }
                            
                        },
                        complete: function(data,status) { //optional, used for debugging purposes
                        //alert(status);
                        }
                        
                    });//ajax
                    
                    
                });
                
                $("#state").change(function() {
                    // alert($("#state").val());
                    
                    $.ajax({

                        type: "GET",
                        url: "http://itcdland.csumb.edu/~milara/ajax/countyList.php",
                        dataType: "json",
                        data: { "state": $("#state").val()},
                        success: function(data,status) {
                            $("#county").html("<option> - Select One - </option>");
                            for(var i = 0; i < data.length; i++){
                                 $("#county").append("<option>" + data[i].county + "</option>");
                            }
                        },
                        complete: function(data,status) { //optional, used for debugging purposes
                        //alert(status);
                        }
                    });//ajax
                });
                
                $("#zipCode").change( function(){  
                    
                    //alert( $("#zipCode").val() );  
                    
                    $.ajax({

                        type: "GET",
                        url: "http://itcdland.csumb.edu/~milara/ajax/cityInfoByZip.php",
                        dataType: "json",
                        data: { "zip": $("#zipCode").val() },
                        success: function(data,status) {
                            if(data) {
                                $("#city").html(data.city);
                                $("#latitude").html(data.latitude);
                                $("#longitude").html(data.longitude);
                            } else {
                                $("#city").html("<br/>City not found.<br/>");
                            }
                        },
                        complete: function(data,status) { //optional, used for debugging purposes
                            //alert(status);
                        }
                        
                    });//ajax
                });
                
                $("#retypePass").change(function() {
                    if($("#password").val() != $("#retypePass").val()) {
                        $("#isPWDiff").show();
                        $("#isPWDiff").css("color","red");
                        $("#isCorrect").hide();
                    } else {
                        $("#isPWDiff").hide();
                    }
                });
                
                $("#submitBtn").click(function() {
                   if ($("#username").val() != "" && $("#password").val() != "" && $("#password").val() == $("#retypePass").val()) {
                        $("#isCorrect").show();
                        $("#isCorrect").css("color","green");
                        $("#isCorrect").css("font-size","30px");
                        
                        var data = $("#form-search").serialize();
                        
                        $.ajax({
                             data: data,
                             type: "POST",
                             url: "insertToDB.php",
                             success: function(data){
                                //   alert("Data Save: " + data);
                             }
                        });
                   }
                   else {
                       $("#isCorrect").hide();
                   }
                });
                
                $(document).on('click','#save',function(e) {
                    var data = $("#signUpForm").serialize();
                    $.ajax({
                        data: data,
                        type: "post",
                        url: "insertToDB.php",
                        success: function(data){
                            alert("Data Saved: " + data);
                        }
                    });
                 });
            }); //documentReady
        </script>

    </head>

    <body>
    
       <h1> Sign Up Form <img id='write' src='./img/write.png'> </h1>
    
        <form onsubmit="return validateForm()" id="signUpForm">
            <fieldset>
               <legend>Sign Up</legend><br />
                First Name:  <input type="text"><br> <br />
                Last Name:   <input type="text"><br> <br />
                Email:       <input type="text"><br> <br />
                Phone Number:<input type="text"><br><br>
                Zip Code:    <input type="text" id="zipCode"><br><br />
                City:        <span id="city"></span>
                <br>
                Latitude:    <span id="latitude"></span>
                <br>
                Longitude:   <span id="longitude"></span>
                <br><br>
                State: 
                <select id="state">
                    <option value="">Select One</option>
                    <option value="ca"> California</option>
                    <option value="ny"> New York</option>
                    <option value="tx"> Texas</option>
                    <option value="va"> Virginia</option>
                </select><br />
                
                <br />
                Select a County: <select id="county"></select><br>
                
                <br />
                Desired Username: <input type="text" id = "username"><br>
                
                <div id="isUNTaken"></div>
                
                <br />
                Password: <input type="password" id="password"><br>
                
                <br />
                Type Password Again: <input type="password" id="retypePass"><br>
                
                <div id="isPWDiff">Error. Retype Password.</div>
                
                <br />
                <input type="submit" value="Sign up!" id = "submitBtn">
                <br />
                <div id="isCorrect">Record Added!</div>
            </fieldset>
        </form>
      
    </body>
</html>