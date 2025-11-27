
<style>
.collapsible {
  /*cursor: pointer;*/
  /*padding: 18px;*/
  /*width: 50%;*/
  border: none!important;
  text-align: center;
  /*outline: none;*/
  color: white;
  font-size: 12px;
  background: none!important;
}

.active, .collapsible:hover {
  background-color: #555;
}

.collapsible:after {
  /*content: '\002B';*/
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

/*.active:after {
  content: "\2212";
}*/

.content {
  padding: 0 18px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  
}
</style>
<div class="my-auto mx-auto w-100 text-light" align="middle" style="max-width:850px;display:none;" id="findCodeDiv">
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">              
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <img src="" class="imagepreview" style="width: 100%;" >
            </div>
            </div>
        </div>
    </div>
    <h4 class="mt-3">
        Where to find code?
    </h4>
    <div class="w-100 bg-dark mt-4 mb-4">
        <img src="{{asset('images/howtos/findcode.png')}}" alt="Find Code" class="img-fluid pop" style="max-height:300px;">
    </div>
    <p class="pl-3 pr-3" align="justify">
        Every authentic medicines listed below have a authenticity code written behind of the strip.
        Check the image above as an example of where you may find your code.
    </p>
    <p class="pl-3 pr-3" align="left">
        Medicine List:
        <ul align="left">
            <li>Maxpro 20mg and 40mg Capsule</li>
            <li>Maxpro 20mg and 40mg Tablet</li>
            <li>Rolac 10mg Tablet</li>
        </ul>
    </p>

    <div onclick="backtoverify()" style="text-align:center;color:#9ca8af;font-size:13px;">
        <img src="{{asset('images/up-arrow.png')}}" alt="" style="max-width:12px;"> <br/>
        Back to verification
    </div>
</div>
<div class="my-auto mx-auto w-100 text-light" align="middle" style="max-width:850px;display:none;" id="coronaupdatediv">
    <img src="{{asset('images/mythbuster.png')}}" alt="Snow" align="left" style="max-height:40px;padding-right: 20px;padding-left: 10px">
    <H4 style="text-align: left">প্রকৃত তথ্য</H4>
    <p style="text-align: left;font-size: 13px;color:#e8e8e8;;padding-left: 10px;padding-top: 10px;">
        <ul style="text-align: left;font-size: 13px;color: #fff;opacity: 0.7;">
            <li>করোনা গরম এবং আর্দ্র আবহাওয়াতে ছড়াতে পারে</li>
            <li>এটি ঠান্ডা আবহাওয়াতেও ছড়ায়</li>
            <li>উষ্ম স্নান করোনা ভাইরাস প্রতিরোধ করে না</li>
        </ul> 
 </p>
    <button class="collapsible" style=""  >বিস্তারিত .....</button>
<div class="content">
  <p style="text-align: left;font-size: 13px;color:#e8e8e8">
        <ul style="text-align: left;font-size: 13px;color: #fff;opacity: 0.7;">
            <li>ঠাণ্ডা খাবার / পানীয় সম্পূর্ণ ভাবে বর্জন করুন</li>
            <li>ঘরের ভিতরে ঝাড়ু দিবেন না, কোনোভাবেই ধুলো উড়তে দেয়া যাবেনা </li>
            <li>সরাসরি লাইজল জাতীয় মেঝে পরিষ্কারক দিয়ে মুছে ফেলুন</li>
        </ul> 
  </p>
</div>
<img src="{{asset('images/going_outside.png')}}" align="left" alt="Snow" style="max-height:40px;padding-right: 20px;padding-left: 10px">
 <H4 style="text-align: left">বাইরে যাওয়ার সময়</H4>
  <p style="text-align: left;font-size: 13px;color:#e8e8e8;padding-left: 10px;padding-top: 10px;">

        <ul style="text-align: left;font-size: 13px;color: #fff;opacity: 0.7;">
            <li>মাস্ক পরুন</li>
            <li>গ্লাভস পরুন </li>
            <li>বাসায় আসার পর সাবান দিয়ে ২০ সেকেন্ড ধরে হাত ধুয়ে ফেলুন</li>
        </ul> 
  </p>
<button class="collapsible">বিস্তারিত .....</button>
<div class="content">
  <p style="text-align: left;font-size: 13px;color:#e8e8e8">

          <ul style="text-align: left;font-size: 13px;color: #fff;opacity: 0.7;">
            <li>হাত ধোয়া শেষ হলে বাইরে ব্যবহৃত জামা-কাপড়  ডিটারজেন্ট গোলা পানিতে কম করে ১/২ ঘণ্টা ভিজিয়ে তারপর ধুয়ে নিন</li>
        </ul> 
  </p>
</div>
<img src="{{asset('images/healthy_parenting.png')}}" align="left" alt="Snow" style="max-height:40px;padding-right: 20px;padding-left: 10px">
<H4 style="text-align: left">সুস্থ অভিভাবকত্ব</H4>
<p style="text-align: left;font-size: 13px;color:#e8e8e8;padding-left: 10px;padding-top: 10px;">
        <ul style="text-align: left; font-size: 13px;color: #fff;opacity: 0.7;">
            <li>সন্তানের সাথে সময় কাটান</li>
            <li>চলমান পরিস্থিতি নিয়ে আলাপ করুন</li>
            <li>ব্যাখ্যা করুন তারা অনিচ্ছাকৃত ভাবে কিভাবে অন্যের ক্ষতির কারণ হতে পারে</li>
        </ul> 
</p>

<button class="collapsible">বিস্তারিত .....</button>
<div class="content">
  <p style="text-align: left;font-size: 13px;color:#e8e8e8">
        <ul style="text-align: left;font-size: 13px;color: #fff;opacity: 0.7;">
            <li>সন্তানকে নিয়ে একসাথে বসে নাশতা করুন</li>
            <li>গল্প করুন</li>
            <li>চলমান ঘটনা নিয়ে আপনার অভিজ্ঞতা শেয়ার করুন</li>
        </ul>
</p>
</div>


    {{-- <div onclick="backtoverify()" style="text-align:center;color: #fff;opacity: 0.7;font-size:13px;">
        <img src="{{asset('images/up-arrow.png')}}" alt="" style="max-width:12px;"> <br/>
        Back to verification
    </div> --}}
    <a {{-- onclick="Chatbot()" --}} href="https://livebot.panacea.live/"  style="text-align:center;color: #fff;opacity: 0.7;font-size:13px;">
        <img src="{{asset('images/up-arrow.png')}}" alt="" style="max-width:12px;"> <br/>
        Corona Assessment Bot
    </a>
</div>

<div class="my-auto mx-auto w-100 text-light p-4" align="middle" style="max-width:850px;display:none;" id="whyPhoneDiv">
    <h4>
        Why do we need your phone number?
    </h4>

    <div class="w-100 mt-4 mb-4">
        <img src="{{asset('images/howtos/mobile.png')}}" alt="Find Code" class="img-fluid pop" style="max-height:300px;">
    </div>
    
    <p class="pl-3 pr-3 mt-4" align="justify">
        We keep track of the medicines that have been verified by someone to prevent further counterfeiting of medicines.
        Your phone number is not shared with any other party and is perfectly secured. You may check our 
        <a target="_blank" href="https://www.panacea.live/legal">Terms of Services</a> for details.
    </p>

    
    <div onclick="backtoverify()" style="text-align:center;color:#9ca8af;font-size:13px;">
        <img src="{{asset('images/up-arrow.png')}}" alt="" style="max-width:12px;"> <br/>
        Back to verification
    </div>
</div>

<div class="my-auto mx-auto w-100 text-light p-4" align="middle" style="max-width:850px;display:none;" id="whatisauthenticaioncodediv">
    <h4>
        What is phone authentication code?
    </h4>

    <p class="pl-3 pr-3 mt-4" align="justify">
        To verify that you have provided a valid phone number we have sent you a 4 character long phone authenctication
        in your provided phone number. Enter the code in the last step to verify the authenticity of your medicine.
    </p>

    
    <div onclick="backtoverify()" style="text-align:center;color:#9ca8af;font-size:13px;">
        <img src="{{asset('images/up-arrow.png')}}" alt="" style="max-width:12px;"> <br/>
        Back to verification
    </div>
</div>



<script>
    $(function() {
        $('.pop').on('click', function() {
            $('.imagepreview').attr('src', $(this).attr('src'));
            $('#imagemodal').modal('show');   
        });		
    });

    function backtoverify()
    {
        document.getElementById("liveCheckDiv").scrollIntoView();
    }
    function Chatbot()
    {

    }
</script>

{{-- //Corona Update --}}
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}
</script>