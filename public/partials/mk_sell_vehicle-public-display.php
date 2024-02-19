<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form>
<div class="mk_sell_vehicle_form_box">
    <h2 class="mk_sell_vehicle_form_box_title">Sell My Car</h2>
    <div class="mk_sell_vehicle_form_box_row">
        <div class="mk_sell_vehicle_form_box_column">
            <p>
                <label>Your Email</label>
                <input type="email" id="mk_sell_vehicle_email" placeholder="Email Address" required>
            </p>
        </div>
        <div class="mk_sell_vehicle_form_box_column">
            <p>
                <label>Your Phone</label>
                <input type="text" id="mk_sell_vehicle_phone" placeholder="Phone Number" required>
            </p>
        </div>
    </div>

    <div class="mk_sell_vehicle_form_box_row">
        <div class="mk_sell_vehicle_form_box_column">
            <p>
                <label>Select A Year</label>
                <span id="mk_sell_form_year_error"></span>
                <select id="mk_sell_vehicle_form_year" required>
                    <option value="1990">1990</option>
                    <option value="1991">1991</option>
                    <option value="1992">1992</option>
                    <option value="1993">1993</option>
                    <option value="1994">1994</option>
                    <option value="1995">1995</option>
                    <option value="1996">1996</option>
                    <option value="1997">1997</option>
                    <option value="1998">1998</option>
                    <option value="1999">1999</option>
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                </select>
            </p>
        </div>
        <div class="mk_sell_vehicle_form_box_column">
            <p>
                <label>Select A Make</label>
                <select id="mk_sell_vehicle_form_make" required>
                    <?php
                    foreach ($mk_sell_vehicle_make as $key => $value) {
                        echo "<option value='".$value->make."'>".$value->make."</option>";
                    }
                    ?>
                </select>
            </p>
        </div>
    </div>
    
    <div class="mk_sell_vehicle_form_box_row">
        <div class="mk_sell_vehicle_form_box_column">
            <p>
                <label>Select A Model</label>
                <span id="mk_sell_form_model_error"></span>
                <select id="mk_sell_vehicle_form_model" required>
                    
                </select>
            </p>
        </div>
        <div class="mk_sell_vehicle_form_box_column">
            <p>
                <label>Select A Trim</label>
                <select id="mk_sell_vehicle_form_trim" required>
                    
                </select>
            </p>
        </div>
    </div>

    <p style="margin-bottom: 10px;">
        <label>Mileage</label required>
        <input type="text" id="mk_sell_vehicle_form_mileage" placeholder="Mileage" required>
    </p>

    <p style="margin-bottom: 10px">
        <label>Comments or Message</label>
        <textarea id="mk_sell_vehicle_form_message" placeholder="Comments or Message" required></textarea>
    </p>

	<button id="mk_sell_vehicle_form_trim_get_value">Get Value</button>
    <span id="mk_sell_vehicle_form_submition_error"></span>
	<h2 id="mk_sell_vehicle_form_value"></h2>
<div>
</form>

<script>
    jQuery(document).ready(function($){
        // form select make ajax
        $("#mk_sell_vehicle_form_make").on("change", function(){
            var mk_sell_vehicle_form_make = $("#mk_sell_vehicle_form_make").val();
            if(mk_sell_vehicle_form_make == ""){
                $("#mk_sell_form_make_error").show().html("<span style='color:red;font-size:18px;'>Make fields are required</span>");
                setTimeout(function(){
                    $("#mk_sell_form_make_error").hide();
                }, 4000);
            }else{
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: "POST",
                    data: {
                        action: "sell_vehicle_form_make",
                        mk_sell_vehicle_form_make : mk_sell_vehicle_form_make
                    },
                    success: function(data){
                    	var strdata = data.slice(0, -1);
                        var jsondata = JSON.parse(strdata)
                        var html = '<option value="">Select Model</option>';
	              		$.each(jsondata,function(key,v){
	               		 	html += '<option value="'+v.model+'">'+v.model+'</option>';
	              		});
	              		$('#mk_sell_vehicle_form_model').html(html);
                    }

                });
            }
        });

        // form select model ajax
        $("#mk_sell_vehicle_form_model").on("change", function(){
            var mk_sell_vehicle_form_model = $("#mk_sell_vehicle_form_model").val();
            if(mk_sell_vehicle_form_model == ""){
                $("#mk_sell_form_model_error").show().html("<span style='color:red;font-size:18px;'>Model fields are required</span>");
                setTimeout(function(){
                    $("#mk_sell_form_model_error").hide();
                }, 4000);
            }else{
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: "POST",
                    data: {
                        action: "sell_vehicle_form_model",
                        mk_sell_vehicle_form_model : mk_sell_vehicle_form_model
                    },
                    success: function(data){
                    	var strdata = data.slice(0, -1);
                        var jsondata = JSON.parse(strdata)
                        var html = '<option value="">Select Trim</option>';
	              		$.each(jsondata,function(key,v){
	               		 	html += '<option value="'+v.trim+'">'+v.trim+'</option>';
	              		});
	              		$('#mk_sell_vehicle_form_trim').html(html);
                    }

                });
            }
        });


        // form submition ajax
        $("#mk_sell_vehicle_form_trim_get_value").on("click", function(event){
            event.preventDefault();

            var mk_sell_vehicle_form_email = $("#mk_sell_vehicle_email").val();
            var mk_sell_vehicle_form_phone = $("#mk_sell_vehicle_phone").val();
            var mk_sell_vehicle_form_year = $("#mk_sell_vehicle_form_year").val();
            var mk_sell_vehicle_form_make = $("#mk_sell_vehicle_form_make").val();
            var mk_sell_vehicle_form_model = $("#mk_sell_vehicle_form_model").val();
            var mk_sell_vehicle_form_trim = $("#mk_sell_vehicle_form_trim").val();
            var mk_sell_vehicle_form_mileage = $("#mk_sell_vehicle_form_mileage").val();
            var mk_sell_vehicle_form_message = $("#mk_sell_vehicle_form_message").val();
            if(mk_sell_vehicle_form_email == "" || mk_sell_vehicle_form_phone == "" || mk_sell_vehicle_form_year == "" || mk_sell_vehicle_form_make == "" || mk_sell_vehicle_form_model == "" || mk_sell_vehicle_form_trim == "" || mk_sell_vehicle_form_mileage == "" || mk_sell_vehicle_form_message == ""){
                $("#mk_sell_vehicle_form_submition_error").show().html("<span style='color:red;font-size:18px;'>All fields are required</span>");
                setTimeout(function(){
                    $("#mk_sell_vehicle_form_submition_error").hide();
                }, 4000);
            }else{
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: "POST",
                    data: {
                        action: "sell_vehicle_form_submition",
                        mk_sell_vehicle_form_email : mk_sell_vehicle_form_email,
                        mk_sell_vehicle_form_phone : mk_sell_vehicle_form_phone,
                        mk_sell_vehicle_form_year : mk_sell_vehicle_form_year,
                        mk_sell_vehicle_form_make : mk_sell_vehicle_form_make,
                        mk_sell_vehicle_form_model : mk_sell_vehicle_form_model,
                        mk_sell_vehicle_form_trim : mk_sell_vehicle_form_trim,
                        mk_sell_vehicle_form_mileage : mk_sell_vehicle_form_mileage,
                        mk_sell_vehicle_form_message : mk_sell_vehicle_form_message
                    },
                    success: function(data){
                        var strdata = data.slice(0, -1);
                        // var jsondata = JSON.parse(strdata);
                        // $.each(jsondata,function(key,v){
                        //     html = "Kamo Offer: <span>"+v.value+"</span> ("+v.year+" "+v.make+" "+ v.model+")";
                        // });
	              		$('#mk_sell_vehicle_form_value').html(strdata);
                    }

                });
            }
        });

    });
</script>


<style>
.mk_sell_vehicle_form_box{
    width: 100% !important;
    border: 2px solid #217FFF !important;
    border-radius: 18px !important;
    padding: 30px 20px !important;
    background: #fff !important;
}
.mk_sell_vehicle_form_box_title{
    color: #217FFF;
    font-size: 36px;
    text-align: center;
    margin-top: 15px;
    margin-bottom: 15px;
}

.mk_sell_vehicle_form_box_row{
    display: flex;
    width: 100%;
    margin-bottom: 10px;
}
.mk_sell_vehicle_form_box_column{
    width: 50%;
    padding:10px;
}


.mk_sell_vehicle_form_box p{
    margin-bottom: 0px;
}
.mk_sell_vehicle_form_box p label{
    font-size: 16px;
    color: #161616;
}
.mk_sell_vehicle_form_box p select, .mk_sell_vehicle_form_box p input, .mk_sell_vehicle_form_box textarea{
    width: 100% !important;
    border: 1px solid #217FFF;
    background: #217fff0d;
    border-radius: 5px;
    min-height: 44px;
    font-size: 16px;
    color: #161616;
    padding: 5px;
}
#mk_sell_vehicle_form_trim_get_value{
    background: #10A6E9 !important;
    color: #fff !important;
    border: none;
    padding: 7px 18px;
    border-radius: 3px;
}
#mk_sell_vehicle_form_value{
    color: #161616 !important;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 10px;
    font-weight: 400;
}
#mk_sell_vehicle_form_value span{
    color: #10A6E9;
}
</style>