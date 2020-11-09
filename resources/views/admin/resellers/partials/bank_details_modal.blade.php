<div class="modal fade bd-example-modal-lg" id="bank_details-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Bank Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @php
            $bank = App\Models\BankDetail::where('user_id', $user->id)->first();
        @endphp
        <div class="modal-body">
            <div class="row">
                @if($bank)
                <div class="col-md-3">
                    <h5>Account Title:</h5>
                    <p class="text-info">{{ $bank->account_title }}</p>
                </div>
                <div class="col-md-3">
                    <h5>Account Number:</h5>
                    <p class="text-info">{{ $bank->account_number }}</p>
                </div>
                <div class="col-md-3">
                    <h5>Bank Name:</h5>
                    <p class="text-info">{{ $bank->bank_name }}</p>
                </div>
                <div class="col-md-3">
                    <h5>Phone Number:</h5>
                    <p class="text-info">{{ $bank->phone_number }}</p>
                </div>
                <div class="col-md-3">
                    <h5>Email:</h5>
                    <p class="text-info">{{ $bank->email }}</p>
                </div>
                @else
                <div class="col-md-12">
                    <p class="text-muted">No Details Found!</p>
                </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>