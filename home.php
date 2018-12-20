<?php include('connection.php');?>
<html>
	<head> 
		<title>Finding New Application No.</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>
	<body style="font-family: 'Times New Roman', Times, serif;">
        <div id="about" class="about-area area-padding">
            <div class="container">
                        <div class="row">
                            <div class="col-md-2 col-sm-1"></div>
                            <div class="col-md-8 col-sm-6">
                                <div class="section-headline text-center">
                                   <h3><strong>Find new application no. for old applications:</strong></h3>
                                   <br>
                                 </div>
                             </div>
                        </div>
                        
                        <div class="row">
                             <div class="col-md-3 col-sm-2"></div>
                                <div class="col-md-6 col-sm-4">
                                    <div class="jumbotron">
                                        <h3 style="text-align: center; padding-bottom: 5%;">Please Enter your data</h3>								
                                            <div class="form-group">
                                                 <div class="row">
                                                    <div class="col-md-6 col-sm-4">
                                                        <label class="control-level">Application Type</label>
                                                     </div>
                                                    <div class="col-md-6 col-sm-4">
														<select class="form-control" id="app_type">
															<?php
																$query="SELECT ia_type_name from ia_case_type_t order by ia_type_name";
																$bind_param_arr=array();
																$sqlchk=$conn->prepare($query);		 
																$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
																$sqlchk->execute($bind_param_arr);	
																$rowchk=$sqlchk->fetchAll();	
																foreach($rowchk as $row)
																{
																	echo '<option value="'.$row['ia_type_name'].'">'.$row['ia_type_name'].'</option>';
																}
															?>
															<!-- SELECT ia_case_type,ia_regno,ia_regyear,regcasetype,reg_no,reg_year from ia_filing where calhc_appl_type='CAN' and calhc_appl_no='100' and calhc_appl_year='2018'; -->
														</select>
                                                      </div>
                                                    </div>
                                            </div>	  
                                            <div class="form-group">
                                                <div class="row">
                                                   <div class="col-md-6 col-sm-4">
                                                         <label class="control-level">Application Number</label>
                                                     </div>
                                                    <div class="col-md-6 col-sm-4">
                                                         <input type="text" class="form-control" id="app_no" name="app_no" >
                                                    </div>	
                                                  </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                   <div class="col-md-6 col-sm-4">
                                                        <label class="control-level">Application Year</label>
                                                    </div>
                                                    <div class="col-md-6 col-sm-4">
                                                            <input type="text" class="form-control" id="app_year">
                                                     </div>	
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                 <div class="row">   
                                                    <div class="col-md-3 col-sm-2"></div>                     
                                                        <div class="col-md-6">
                                                            <button type="button" class="form-control btn btn-success" value="search" id="search">Search</button>
                                                        </div>	
                                                    </div>
                                             </div>

                                    </div> <!--jumbotron closed-->
                                </div>
                        </div><!--row closed--> 
                   </div>
        </div>
        <div class="container">
            <div class="row">
               <div class="col-md-2 col-sm-1"></div>
                   <div class="col-md-8 col-sm-6">
                      <div class="section-headline text-center">
                           
                      </div>
                   </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-2"></div>
                     <div class="col-md-6 col-sm-4">
                         <div class="panel">
                             <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 col-sm-1"></div>
                                        <div class="col-md-9 col-sm-7">
                                            <!--<div class="row" id="result-div">
                                                    <div id="loading-div" class="col-sm-12 text-center hide">
                                                    <img src="images/loading.gif" alt="Loading..."/>
                                                </div>-->
                                                
                                                    <div class="row" id="result_success" style="display:none;">
                                                        											
                                                    </div>
                                                                                 
                                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
                <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script>
            $(document).ready(function(){
            $(document).on("click","#search", function(){
                $(".error").html("");
                
                var appno = $("#app_no").val();
                var appyear = $("#app_year").val();
                var apptype = $("#app_type").val();
                var flag=1;
//validation code
               if (appno.length<1) {
                    $('#app_no').after('<span class="error" style="color:red;">This field is required</span>');
                    flag=0;
                    
                }
                 if (appyear.length<1) {
                    $('#app_year').after('<span class="error" style="color:red;">This field is required</span>');
                    flag=0;
                   
                   
                }
                 if (isNaN(appyear)) {
                    $('#app_year').after('<span class="error" style="color:red;">Please type year properly</span>');
                    flag=0;
                    
                }
                
                if(flag==0)
                {
                    return false;
                }
               
                   
                 $.ajax({
                        type: "POST",
                        url:"entry.php",
                        data:{ 
                                app_no:appno,
                                app_year:appyear,
                                app_type:apptype
                        },
                        success:function(response){
                            if(response[0]){
                                $("#result_success").html("<div class='col-sm-6'><h5>Old Application Number</h5><span id='old_application_details'></span></div><div class='col-sm-6'><h5> New Application Number</h5><span id='new_application_details'></span></div></div>");
                                $("#old_application_details").html(response[0]["calhc_appl_type"]+" "+response[0]["calhc_appl_no"]+" of "+response[0]["calhc_appl_year"]);
                                $("#new_application_details").html(response[0]["ia_type_name"]+" "+response[0]["ia_regno"]+" "+response[0]["ia_regyear"]+" in maincase "+
                                response[0]["type_name"]+" "+response[0]["reg_no"]+" of "+response[0]["reg_year"]);                            
                                $("#result_success").show();
                            }
                            else{
                                $("#result_success").html("<h4 style='margin:auto;'>No Data Found</h4>");
                                $("#result_success").show();
                                
                            }
                            
                        },
                        error:function(jqXHR, textStatus, errorThrown) {                   
                        }
                    })
                
             })
        });
            
            
            </script>
            </body>
        </html>