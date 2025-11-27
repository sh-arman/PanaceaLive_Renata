@extends('mups/master')
@section('contents')
<link rel="stylesheet" href="{{asset('css/public/home.css')}}">
@if ($modal == 1)
    @include('mups/response')    
@endif


<div class="my-auto mx-auto w-100 p-3" align="middle" style="max-width:850px;">
 <form method="POST" action="{{ route('mupslivecheck') }}">
    {{csrf_field()}}

    {{-- CodeDiv --}}
    <div class="form-group" id="CodeDiv">
        <div class="head-line">Enter the code on the strip</div>
        <div class="error-msg" id="codeError"></div>
        <input  type="text" name="code" id="code" class="text-light input-design" placeholder="ren abcdxyz">
    </div>

    {{-- PhoneDiv --}}
    <div class="form-group" id="PhoneDiv" style="display:none;">
        <div class="head-line">Enter Your Phone Number</div>
        <div class="error-msg" id="phoneInfo"></div>
        <input  type="text" autocomplete="true" name="phoneNo" id="phoneNo" class="text-light input-design" placeholder="e.g. 01712345678">
    </div>


    {{-- Buttons --}}
    <div class="form-group" id="b">
        <button type="submit" id="liveCheckBtn" class="btn btn-block btn-light pl-5 pr-5 mt-4 mb-2" style="font-size:17px;font-weight:bold;display:none;border-radius:20px;">Live Check</button>
        <button type="button" id="backBtn" class="btn btn-outline-light pl-4 pr-4 m-2" style="font-size:15px;font-weight:bold;display:none;border-radius:20px;">Back</button>
        <button type="button" id="forwardBtn" class="btn btn-light pl-4 pr-4 m-2" style="font-size:15px;font-weight:bold;border-radius:20px;">Next</button>
    </div>

 </form>

  <input type="hidden" id="nola" value="{{ $modal }}">


</div>
{{-- <div id="corona" style="text-align:center;background-color: #aa2200; color: #fff;opacity: 0.7; font-size:13px;position: absolute;bottom: 0px;left:0;right:0;">
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
                        <p>বাসায় থাকুন </p>
                    </td>
                </tr>
            </table>
        <div  id="howtobtn" onclick="showhowto()" >
        <div id="howtobtnmsg">Where to find code?</div>
        <img src="{{asset('images/down-arrow.png')}}" alt="" style="max-width:12px;">
</div> --}}
</div>
<script>
$(document).ready(function() {

    var nola = $('#nola').val();

    if(nola == 1) {
        console.log('yo');
        $('#exampleModal').modal('show'); 
    } else {
        console.log('nai'),nola;
    }

    $("#forwardBtn").click(function() {
        $("#CodeDiv").slideUp();
        $("#PhoneDiv").slideUp();
        $("#PhoneDiv").removeAttr("style");
        $("#backBtn").removeAttr("style");
        $("#forwardBtn").css("display","none");
        $("#liveCheckBtn").removeAttr("style");
    });

    $("#backBtn").click(function() {
        $("#PhoneDiv").slideUp();
        $("#CodeDiv").slideDown();
        $("#PhoneDiv").css("display","none");
        $("#backBtn").css("display","none");
        $("#liveCheckBtn").css("display","none");
        $("#forwardBtn").fadeIn();
    });
});
</script>

@endsection