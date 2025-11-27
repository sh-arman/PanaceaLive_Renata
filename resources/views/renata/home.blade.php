@extends('layout/public')

@section('contents')

<link rel="stylesheet" href="{{asset('css/public/home.css?v1.3')}}">

@include('public/response')

<div class="my-auto mx-auto w-100 p-3" align="middle" style="max-width:850px;">
     {{csrf_field()}}
    <div class="form-group" id="codeDiv">
        <div class="head-line">Enter the code on the strip</div>
        <div class="error-msg" id="codeError"></div>
        <input  type="text" name="code" id="code" class="text-light input-design" placeholder="e.g. ren abcdxyz" autocomplete="off">
    </div>

    <div class="form-group" id="phoneDiv" style="display:none;">
        <div class="head-line">Enter Your Phone Number</div>
        <div class="error-msg" id="phoneInfo"></div>
        <input  type="number" name="phoneNo" id="phoneNo" class="text-light input-design" placeholder="e.g. 01712345678">
    </div>

    <div class="form-group" id="verificationCodeDiv" style="display:none;">
        <div class="head-line">Enter Phone Authentication Code</div>
        <div class="error-msg" id="confirmationCodeInfo"></div>
        <input  type="text" name="verificationCode" id="verificationCode" class="text-light input-design" placeholder="e.g. ABCD" autocomplete="off">
    </div>

    <div class="form-group" id="b">
        <button type="button" id="liveCheckBtn" class="btn btn-block btn-light pl-5 pr-5 mt-4 mb-2" style="font-size:17px;font-weight:bold;display:none;border-radius:20px;">Live Check</button>
        <button type="button" id="backBtn" class="btn btn-outline-light pl-4 pr-4 m-2" style="font-size:15px;font-weight:bold;display:none;border-radius:20px;">Back</button>
        <button type="button" id="forwardBtn" class="btn btn-light pl-4 pr-4 m-2" style="font-size:15px;font-weight:bold;border-radius:20px;">Next</button>
        <button type="button" id="resendBtn" class="btn btn-outline-success pl-2 pr-2 m-2" style="font-size:15px;font-weight:bold;display:none;border-radius:20px;">Resend Code</button>
    </div>

    <div class="progress-bar row m-0 p-0" style="width:90%; visibility: hidden;">
    </div>
    
</div>
    <div id="corona" style="text-align:center;background-color: #1369AA; color: #fff;opacity: 0.7; font-size:13px;position: absolute;bottom: 0px;left:0;right:0;">
        <p style="color:white; font-size:16px; ">করোণায় করনীয় </p>

            <table align="center">
                <tr>
                    <td>
                        <img src="{{asset('images/mask3.png')}}" alt="Snow" style="max-height:45px;padding-right: 30px">
                        <p>মাস্ক পড়বেন</p>
                    </td>
                    <td>
                        <img src="{{asset('images/hand3.png')}}" alt="Snow" style="max-height:45px;padding-right: 30px">
                        <p>হাত ধুবেন</p>
                    </td>
                    <td>
                        <img src="{{asset('images/home3.png')}}" alt="Snow" style="max-height:45px;padding-right: 30px">
                        <p>বাসায় থাকুন</p>
                    </td>
                </tr>
            </table>
            <!-- <div onclick="showhowto()">
                <a href="" align=center; style="color:white; font-size:13px; ">আরো জানতে</p></a>
                 <div >আরো জানতে</div>
                <img src="{{asset('images/down-arrow.png')}}" alt="" style="max-width:12px;">
             </div>  -->
        <div  id="howtobtn" onclick="showhowto()" >
        
        <div id="howtobtnmsg">Where to find code?</div>
        <img src="{{asset('images/down-arrow.png')}}" alt="" style="max-width:12px;">
    </div>

    </div>
    
    {{-- <div  id="howtobtn" onclick="showhowto()" style="text-align:center;color:#9ca8af;font-size:13px;position: absolute;bottom: 20px;left:0;right:0;">
        
        <div id="howtobtnmsg">Where to find code?</div>
        <img src="{{asset('images/down-arrow.png')}}" alt="" style="max-width:12px;">
    </div> --}}
    

<script>

var phoneDiv = false;
var codeDiv = true;
var verificationCodeDiv = false;
var codeVerifyUrl = "{{url('codeverify')}}";
var phoneVerifyUrl = "{{url('phoneverify')}}";
var liveCheckUrl = "{{url('livecheck')}}";
var resendCodeUrl = "{{url('resendcode')}}";

//function coronaupdat() { }

function showhowto()
{
    $('#howtos').css('display','flex');
    document.getElementById("howtos").scrollIntoView();
    var howtomsg = $('#howtobtnmsg').html();
    if(howtomsg == "Where to find code?")
    {
        $('#findCodeDiv').fadeIn();
    }
    else if(howtomsg == "Why phone number?")
    {
        $('#whyPhoneDiv').fadeIn();
    }
    else if(howtomsg == "What is phone authentication code?")
    {
        $('#whatisauthenticaioncodediv').fadeIn();
    }
    else 
    {
        
        $('#coronaupdatediv').fadeIn();
        console.log("Hello");
    }
}

$(document).ready(function(){
    $("#forwardBtn").attr('onclick','ForwardButtonActions()');
    $("#resendBtn").attr('onclick','ResendVerificationCode()');
    $("#liveCheckBtn").attr('onclick','LiveCheck("noncache")');
    $("#backBtn").click(function(){
        if (phoneDiv == true)
        {
            $("#phoneDiv").delay(100).slideUp();
            $("#codeDiv").delay(100).slideDown();
            $("#backBtn").delay(100).fadeOut();

            $(".progress-bar").toggleClass('step2');
            
            $("#howtobtnmsg").html('Where to find code?');
            HideHowTos();

            phoneDiv = false;
            codeDiv = true;
        }
        else if (verificationCodeDiv == true)
        {
            $("#liveCheckBtn").fadeOut();
            $("#resendBtn").fadeOut();
            $("#forwardBtn").delay(100).fadeIn();

            $("#verificationCodeDiv").delay(100).slideUp();
            $("#phoneDiv").delay(100).slideDown();

            $(".progress-bar").toggleClass('step3');
                        
            $("#howtobtnmsg").html('Why phone number?');
            HideHowTos();

            phoneDiv = true;
            verificationCodeDiv = false;
        }
    });
    $('#exampleModal').on('hidden.bs.modal', function () 
    {
        window.location.reload();
    })
    $("#code").keyup(function(event) 
    {
        if (event.keyCode === 13) {
            $("#forwardBtn").click();
        }
    });
    $("#phoneNo").keyup(function(event) 
    {
        if (event.keyCode === 13) {
            $("#forwardBtn").click();
        }
    });
    $("#verificationCode").keyup(function(event) 
    {
        if (event.keyCode === 13) {
            $("#liveCheckBtn").click();
        }
    });

});

function ForwardButtonActions()
{
    if(codeDiv == true)
    {
        CodeVerify();
    }
    else if (phoneDiv == true)
    {
        PhoneVerify();
    }
}

function CodeVerify()
{
    var postData = {};
    var CSRF_TOKEN = $('input[name="_token"]').val();
    postData["_token"] = CSRF_TOKEN;
    postData["code"] = $('input[name="code"]').val();

    $.ajax({
        type: 'POST',
        async: true,
        url: codeVerifyUrl,
        data: postData,
        dataType: 'JSON'
    })
    .done(function( data ) {
        if(data.hasOwnProperty('errors'))
        {
            $('#codeError').html(data.errors.code);
            $('#codeError').fadeIn();
        }
        else if(data.hasOwnProperty('cache'))
        {
            console.log("I have Cache");
            LiveCheck("cache");
        }
        else
        {
            console.log("Maf chai Cache nai");
            $('#codeError').html('');
            $("#codeDiv").delay(100).slideUp();
            $("#phoneDiv").delay(100).slideDown();
            $("#backBtn").delay(100).fadeIn();
            
            $(".progress-bar").toggleClass('step2');

            $("#howtobtnmsg").html('Why phone number?');
            HideHowTos();

            phoneDiv = true;
            codeDiv = false;
        }
    })
    .fail(function(data) {
        console.log(data);
        $("#exampleModal").modal();
        $(".modal-header").addClass("bg-warning");
        $("#responseMsg").html('Sorry Something Went Wrong.<br/> Please report error 900 to support@panacea.live ');
    });
}

function PhoneVerify()
{
    var postData = {};
    var ret = false;
    var CSRF_TOKEN = $('input[name="_token"]').val();
    postData["_token"] = CSRF_TOKEN;
    postData["phoneNo"] = $('input[name="phoneNo"]').val();

    $.ajax({
        type: 'POST',
        async: true,
        url: phoneVerifyUrl,
        data: postData,
        dataType: 'JSON'
    })
    .done(function( data ) {
        if (data.hasOwnProperty('phoneError'))
        {
            $('#phoneInfo').html(data.phoneError);
            $('#phoneInfo').fadeIn();
        }
        else if (data.hasOwnProperty('codeNotSent'))
        {
            $("#exampleModal").modal();
            $(".modal-header").addClass("bg-warning");
            $("#responseMsg").html(data.codeNotSent);
        }
        else
        {
            $("#phoneDiv").delay(100).slideUp();
            $("#verificationCodeDiv").delay(100).slideDown();

            $("#liveCheckBtn").delay(100).fadeIn();
            $("#forwardBtn").fadeOut();
            $("#resendBtn").delay(100).fadeIn();
            phoneDiv = false;
            verificationCodeDiv = true;

            $(".progress-bar").toggleClass('step3');
            
            $("#howtobtnmsg").html('What is phone authentication code?');
            HideHowTos();

            $('#confirmationCodeInfo').css('color','#8fc93a');
            $('#confirmationCodeInfo').html(data.success);
            $('#confirmationCodeInfo').fadeIn();
        }
    })
    .fail(function(data) {
        console.log(data);
        $("#exampleModal").modal();
        $(".modal-header").addClass("bg-warning");
        $("#responseMsg").html('Sorry Something Went Wrong.<br/> Please report error to support@panacea.live');
    });
    return ret;
}

function ResendVerificationCode()
{
    var postData = {};
    var CSRF_TOKEN = $('input[name="_token"]').val();
    postData["_token"] = CSRF_TOKEN;
    postData["phoneNo"] = $('input[name="phoneNo"]').val();
    $.ajax({
        type: 'POST',
        async: true,
        url: resendCodeUrl,
        data: postData,
        dataType: 'JSON'
    })
    .done( function(data) {
        if(data.hasOwnProperty('error'))
        {
            $("#exampleModal").modal();
            $(".modal-header").addClass("bg-warning");
            $("#responseMsg").html(data.error);
        }
        else
        {
            $('#confirmationCodeInfo').fadeOut();
            $('#confirmationCodeInfo').css('color','#8fc93a');
            $('#confirmationCodeInfo').html(data.success);
            $('#confirmationCodeInfo').fadeIn();
        }
    })
    .fail( function() {
        $("#exampleModal").modal();
        $(".modal-header").addClass("bg-warning");
        $("#responseMsg").html('Sorry Something Went Wrong.<br/> Please report error to support@panacea.live ');
    });
}

function LiveCheck(value)
{
    console.log(value);
    var postData = {};
    var ret = false;
    var CSRF_TOKEN = $('input[name="_token"]').val();
    postData["_token"] = CSRF_TOKEN;
    postData["code"] = $('input[name="code"]').val();
    if(value=="noncache") {
    postData["phoneNo"] = $('input[name="phoneNo"]').val();
    postData["activationCode"] = $('input[name="verificationCode"]').val(); 
    } else {
        postData["phoneNo"] = "cache";
    }
    
    $.ajax({
        type: 'POST',
        async: true,
        url: liveCheckUrl,
        data: postData,
        dataType: 'JSON'
    })
    
    .done( function(data) {
        if(data.hasOwnProperty('error'))
        {
            $("#crossImg").show();
            $("#exampleModal").modal();
            $(".modal-header").addClass("bg-danger");
            $("#responseMsg").html(data.error);
        }
        else if (data.hasOwnProperty('success'))
        {
            $("#checkImg").show();
            $("#exampleModal").modal();
            $(".modal-header").addClass("bg-success");
            $("#responseMsg").html(data.success);
        }
        else if (data.hasOwnProperty('warning'))
        {
            $("#warningImg").show();
            $("#exampleModal").modal();
            $(".modal-header").addClass("bg-warning");
            $("#responseMsg").html(data.warning);
        }
        else
        {
            $('#confirmationCodeInfo').css('color','#8c271e');
            $('#confirmationCodeInfo').html(data.activationError);
        }
    })
    .fail( function() {
        $("#exampleModal").modal();
        $(".modal-header").addClass("bg-warning");
        $("#responseMsg").html('Sorry Something Went Wrong.<br/> Please report error 900 to support@panacea.live ');
    });
}

function HideHowTos()
{
    $('#howtos').css('display','none');
    $('#findCodeDiv').css('display','none');
    $('#whyPhoneDiv').css('display','none');
    $('#whatisauthenticaioncodediv').css('display','none');
}

 $("#code").mouseenter(function(){
     var width=window.innerWidth;
     var height=window.innerHeight;
     //console.log(width);
     //console.log(height);
     //window.alert(width+" "+height);
    

     $("#howtobtn").hide();
     $("#corona").hide();
 });
 $("#code").mouseleave(function(){
     $("#howtobtn").show();
     $("#corona").show();
 });
 $("#phoneNo").mouseenter(function(){
     var width=window.innerWidth;
     var height=window.innerHeight;
     //console.log(width);
     //console.log(height);
     //window.alert(width+" "+height);
     $("#howtobtn").hide();
     $("#corona").hide();
 });
 $("#phoneNo").mouseleave(function(){
     $("#howtobtn").show();
     $("#corona").show();
 });
 $("#verificationCode").mouseenter(function(){
     var width=window.innerWidth;
     var height=window.innerHeight;
     //console.log(width);
     //console.log(height);
     //window.alert(width+" "+height);
     $("#howtobtn").hide();
     $("#corona").hide();
 });
 $("#verificationCode").mouseleave(function(){
     $("#howtobtn").show();
     $("#corona").show();
 });


/*function checkkeyboard()
{
if($(document.activeElement).attr('type') == "text"){
    console.log("Keyboard is visible");
    window.alert("Keyboard showing");
    $("#howtobtn").hide();
}else{
    $("#howtobtn").show();
    
}
}*/




</script>

@endsection