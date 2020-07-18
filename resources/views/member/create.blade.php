@extends('layouts.app')

@section('css')
{{--    <link href="{{ asset('vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-edit"></i> Create Member</div>
            <div class="card-body">
                <form action="{{ route('createMember') }}" id="memberForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="memberId">Member ID</label>
                        <input type="number" class="form-control" id="memberId" name="member_id" value="">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="">
                    </div>
                    <div class="form-group">
                        <label for="sex">Gender</label>
                        <select class="form-control" id="sex" name="sex">
                            <option value="male" >Male</option>
                            <option value="female" >Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="marital">Marital Status</label>
                        <select class="form-control" id="sex" name="marital">
                            <option value="married" >Married</option>
                            <option value="single" >Single</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone #</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="">
                    </div>
                    <div class="form-group">
                        <label for="phone2">Phone 2 #</label>
                        <input type="text" class="form-control" id="phone2" name="phone2" value="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="">
                    </div>
                    <div class="form-group">
                        <label for="profession">Profession</label>
                        <input type="text" class="form-control" id="profession" name="profession" value="">
                    </div>
                    <div class="form-group">
                        <label for="purpose">Purpose</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" value="">
                    </div>
                    <div class="form-group">
                        <label for="referrer">Referrer</label>
                        <select class="form-control" id="referrer" name="referrer">
                            <option value="">Select referrer</option>
                            @foreach($members as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nok">Next of Kin</label>
                        <input type="text" class="form-control" id="nok" name="nok" value="">
                    </div>
                    <div class="form-group">
                        <label for="nok_address">Next of Kin Address</label>
                        <input type="text" class="form-control" id="nok_address" name="nok_address" value="">
                    </div>
                    <div class="form-group">
                        <label for="nok_phone">Next of Kin Phone</label>
                        <input type="text" class="form-control" id="nok_phone" name="nok_phone" value="">
                    </div>
                    <div class="form-group">
                        <label for="nok_phone2">Next of Kin Phone 2</label>
                        <input type="text" class="form-control" id="nok_phone2" name="nok_phone2" value="">
                    </div>
                    <div class="form-group">
                        <label for="picture">Picture</label>
                        <input type="file" class="form-control" id="picture" name="picture" value="">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" id="submitBTN">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function () {
            $('#submitBTN').click(function () {
                swal({
                        title: "Are you sure?",
                        // text: "Your are approving loan ",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, create member!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            const form = document.querySelector('#memberForm');
                            form.submit();
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
        });
    </script>
    @if(Session::has('errors'))
        <script>
            toastr.error("{{ Session::get('error') }}", 'Error');
        </script>
    @endif
@endsection
