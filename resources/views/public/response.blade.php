<div class="modal container fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-light" id="exampleModalLabel">Renata Live Check</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <img id="crossImg" src="{{asset('images/cross.png')}}" class="rounded mx-auto d-block" style="display:none !important;max-width:300px;max-height:300px;">
            <img id="checkImg" src="{{asset('images/check.png')}}" class="rounded mx-auto d-block" style="display:none !important;max-width:300px;max-height:300px;">
            <img id="warningImg" src="{{asset('images/warning.png')}}" class="rounded mx-auto d-block" style="display:none !important;max-width:300px;max-height:300px;">
            <p class="lead text-center pt-5" id="responseMsg">
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>