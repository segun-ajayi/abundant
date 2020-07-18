@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="row mb-2">
        <div class="col-md-6">
            <button class="btn btn-sm btn-secondary px-5 mr-5" id="prev">Previous</button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-sm btn-primary px-5 ml-5" id="next">Next</button>
        </div>
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-edit"></i> {{ Str::title($member->name) }}
                <div class="card-header-actions">
                    <button class="card-header-action btn btn-warning btn-sm px-5" type="button" data-toggle="modal" data-target="#fineModal">Fine</button>
                    <button class="card-header-action btn btn-primary btn-sm px-5 mr-5" type="button" data-toggle="modal" data-target="#utilModal">Utility</button>
                    <button class="card-header-action btn btn-success btn-sm px-5" type="button" data-toggle="modal" data-target="#successModal">Post</button>
                    <button class="card-header-action btn btn-danger btn-sm px-5" type="button" data-toggle="modal" data-target="#dangerModal">Loan</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-4 mb-5">
                        @if($member->pix)
                            @if(file_exists(public_path('img/members/' . $member->pix)))
                                <img class="img-thumbnail rounded" src="{{ asset('img/members/' . $member->pix) }}" height="350">
                            @else
                                <img class="img-thumbnail rounded" src="{{ asset('img/members/nopix.png') }}" height="350">
                            @endif
                        @else
                            <img class="img-thumbnail rounded" src="{{ asset('img/members/nopix.png') }}" height="350">
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-4">
                        Name: <h5>{{ Str::title($member->name) }}</h5>
                        Email: <h5>{{ Str::lower($member->email) }}</h5>
                        Phone: <h5>{{ $member->phone . ' | ' . $member->phone2}}</h5>
                        Profession: <h5>{{ $member->profession}}</h5>
                        Address: <h5>{{ $member->address}}</h5>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <h1 class="text-muted">
                            {{ $member->member_id }}
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        @if($member->sharePercent() < 50)
                            <div class="card text-white bg-danger">
                        @elseif($member->sharePercent() < 100)
                            <div class="card text-white bg-warning">
                        @else
                            <div class="card text-white bg-success">
                        @endif
                            <div class="card-body">
                                <div class="text-value">₦ {{ number_format($member->getShare(), 2, '.', ',') }}</div>
                                <div>Shares</div>
                                <div class="progress progress-xs my-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $member->sharePercent() }}%" aria-valuenow="{{ $member->sharePercent() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
{{--                                <small class="text-muted">Shares.</small>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-behance">
                            <div class="card-body">
                                <div class="text-value">₦ {{ number_format($member->getBuilding(), 2, '.', ',') }}</div>
                                <div>Building</div>
{{--                                <small class="text-muted">Building.</small>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-cyan">
                            <div class="card-body">
                                <div class="text-value">₦ {{ number_format($member->getSaving(), 2, '.', ',') }}</div>
                                <small class="text-muted">Savings</small>
                                @if($member->getsSaving() > 0)
                                    <div>Special Savings.</div>
                                    <div class="text-value">₦ {{ number_format($member->getsSaving(), 2, '.', ',') }}</div>
                                    @if(Auth::user()->role == 'admin')
                                        <td>
                                            <button class="btn btn-behance btn-block btn-sm" id="withdraw">Withdraw</button>
                                        </td>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        @if($member->getLoan())
                            @if($member->loanPercent() < 50)
                                <div class="card text-white bg-danger">
                            @elseif($member->loanPercent() < 100)
                                <div class="card text-white bg-warning">
                            @else
                                <div class="card text-white bg-success">
                            @endif
                        @else
                            <div class="card">
                        @endif
                            <div class="card-body">
                                @if($member->getLoanH()->isEmpty() && isset($loan->id))
                                    <div class="btn-group float-right">
                                        <button class="btn btn-sm btn-primary" id="reverseB" type="button">
                                            Reverse
                                        </button>
                                    </div>
                                @endif
                                <div class="text-value">₦ {{ number_format($member->getLoan(), 2, '.', ',') }}</div>
                                <div>Current Loan</div>
                                @if($member->getLoan())
                                    <div class="progress progress-xs my-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $member->loanPercent() }}%" aria-valuenow="{{ $member->loanPercent() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">₦ {{ number_format($loan->amount, 2, '.', ',') }} on {{ \Carbon\Carbon::parse($loan->lpDate)->format('M d, Y') }}.</small>
                                @endif
{{--                                <button class="btn btn-ghost-primary btn-block btn-sm" style="float: end">Settle</button>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if($member->savings)
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Savings History</div>
                                <div class="card-body">
                                    <table class="table table-responsive-sm table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Mode</th>
                                            <th>Type</th>
                                            @if(Auth::user()->role == 'admin')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($member->getSavingH()->sortByDesc('date') as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</td>
                                                <td>
                                                    @if($item->credit != 0)
                                                        ₦ {{ number_format($item->credit, 2, '.', ',') }}
                                                    @else
                                                        ₦ {{ number_format($item->debit, 2, '.', ',') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->credit != 0)
                                                        <span class="badge badge-success">{{ $item->mode }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $item->mode }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->credit != 0)
                                                        <span class="badge badge-success">Credit</span>
                                                    @else
                                                        <span class="badge badge-danger">Debit</span>
                                                    @endif
                                                </td>
                                                @if(Auth::user()->role == 'admin')
                                                    <td>
                                                        <button class="btn btn-primary btn-sm reSavings" value="{{ $item->id }}">Reverse</button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($member->hasActiveLoan())
                        <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Loan Repayment History</div>
                                    <div class="card-body">
                                        <table class="table table-responsive-sm table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Interest</th>
{{--                                                <th>Mode</th>--}}
                                                @if(Auth::user()->role == 'admin')
                                                    <th>
                                                        Action
                                                    </th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($member->getLoanH()->sortByDesc('date') as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</td>
                                                    <td>₦ {{ number_format($item->credit, 2, '.', ',') }}</td>
                                                    <td>₦ {{ number_format($item->interest, 2, '.', ',') }}</td>
{{--                                                    <td>--}}
{{--                                                        <span class="badge badge-success">{{ $item->mode }}</span>--}}
{{--                                                    </td>--}}
                                                    @if(Auth::user()->role == 'admin')
                                                        <td>
                                                            <button class="btn btn-primary btn-sm reLoan" value="{{ $item->id }}">Reverse</button>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    @endif
{{--                </div>--}}
{{--                <div class="row">--}}
                    @if($member->share)
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Share History</div>
                                <div class="card-body">
                                    <table class="table table-responsive-sm table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Mode</th>
                                            <th>Type</th>
                                            @if(Auth::user()->role == 'admin')
                                                <th>
                                                    Action
                                                </th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($member->getShareH()->sortByDesc('date') as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</td>
                                                <td>
                                                    @if($item->credit != 0)
                                                        ₦ {{ number_format($item->credit, 2, '.', ',') }}
                                                    @else
                                                        ₦ {{ number_format($item->debit, 2, '.', ',') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->credit != 0)
                                                        <span class="badge badge-success">{{ $item->mode }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ $item->mode }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->credit != 0)
                                                        <span class="badge badge-success">Credit</span>
                                                    @else
                                                        <span class="badge badge-danger">Debit</span>
                                                    @endif
                                                </td>
                                                @if(Auth::user()->role == 'admin')
                                                    <td>
                                                        <button class="btn btn-primary btn-sm reShare" value="{{ $item->id }}">Reverse</button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($member->building)
                        <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-align-justify"></i> Building History</div>
                                    <div class="card-body">
                                        <table class="table table-responsive-sm table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Interest</th>
                                                <th>Mode</th>
                                                @if(Auth::user()->role == 'admin')
                                                    <th>
                                                        Action
                                                    </th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($member->getBuildingH()->sortByDesc('date') as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</td>
                                                    <td>
                                                        @if($item->credit != 0)
                                                            ₦ {{ number_format($item->credit, 2, '.', ',') }}
                                                        @else
                                                            ₦ {{ number_format($item->debit, 2, '.', ',') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->credit != 0)
                                                            <span class="badge badge-success">{{ $item->mode }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ $item->mode }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->credit != 0)
                                                            <span class="badge badge-success">Credit</span>
                                                        @else
                                                            <span class="badge badge-danger">Debit</span>
                                                        @endif
                                                    </td>
                                                    @if(Auth::user()->role == 'admin')
                                                        <td>
                                                            <button class="btn btn-primary btn-sm reBuilding" value="{{ $item->id }}">Reverse</button>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(Auth::user()->role == 'admin')
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    Admin Area
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($member->user_id)
                            <div class="col">
                                <button class="btn btn-danger btn-block" onclick="del({{ $member->id }})">Remove from Excos</button>
                            </div>
                        @else
                            <div class="col">
                                <button class="btn btn-primary btn-block" id="mExco">Make Exco</button>
                            </div>
                        @endif
                        @if($member->isAdmin())
                            <div class="col">
                                <button class="btn btn-warning btn-block" value="{{ $member->user_id }}" id="xAdmin">Revoke Admin</button>
                            </div>
                        @else
                            <div class="col">
                                <button class="btn btn-secondary btn-block" value="{{ $member->user_id }}" id="mAdmin">Make Admin</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="makeExco" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-warning" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Make Exco</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  id="excoForm" action="{{ route('mkExco') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="hf-email">Username</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="username" placeholder="Enter Username" autocomplete="username">
{{--                                <span class="help-block">Please enter your email</span>--}}
                            </div>
                        </div>
                        <input type="hidden" name="member" value="{{ $member->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button id="mkExco" class="btn btn-success" type="button">Make Exco</button>
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
    <div class="modal fade" id="fineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-warning" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fine</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  id="fineForm" action="{{ route('fine') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="hf-email">Savings</label>
                            <div class="col-md-9">
                                <input class="form-control formattedNumberField" id="fineAmount" type="text" name="amount" placeholder="Enter Amount" autocomplete="amount">
{{--                                <span class="help-block">Please enter your email</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="postType">Reason</label>
                            <div class="col-md-9">
                                <select class="form-control" id="reason" name="reason">
                                    <option value="noise">Noise Making</option>
                                    <option value="assault">Abuse & Assault</option>
                                    <option value="late">Lateness</option>
                                    <option value="absent">Absent</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="postType">Payment Method</label>
                            <div class="col-md-9">
                                <select class="form-control" id="payMethod" name="pay">
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Bank Transfer</option>
                                    <option value="savings">Savings</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="member" value="{{ $member->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button id="postFine" class="btn btn-success" type="button">Fine</button>
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
    <div class="modal fade" id="utilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Utilities</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="utilForm" action="{{ route('buyUtil') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="util">Utilities</label>
                            <div class="col-md-9">
                                <select class="form-control" id="util" name="type">
                                    <option value="loan_form">Loan Form</option>
                                    <option value="booklet">Booklet</option>
                                    <option value="entry_form">Entry Form</option>
                                    <option value="chair">Chair/Tent Rental</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="price">Price</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control formattedNumberField" id="price" name="price" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="postType">Payment Method</label>
                            <div class="col-md-9">
                                <select class="form-control" id="payUMethod" name="pay">
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Bank Transfer</option>
                                    <option value="savings">Savings</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="member" value="{{ $member->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="utilBuy" type="button">Buy Utility</button>
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-success" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Post</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  id="postForm" action="{{ route('postInc') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="hf-email">Savings</label>
                            <div class="col-md-9">
                                <input class="form-control formattedNumberField" id="savings" type="text" name="savings" placeholder="Enter Savings" autocomplete="savings">
{{--                                <span class="help-block">Please enter your email</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="hf-email">Loan repay</label>
                            <div class="col-md-9">
                                <input class="form-control formattedNumberField" id="loan" type="text" name="loan" placeholder="Enter Loan Repayment" autocomplete="loan">
                                <span id="spa" class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="hf-email">Loan Interest</label>
                            <div class="col-md-9">
                                <input class="form-control formattedNumberField" id="interest" type="text" name="interest" placeholder="Enter Loan Repayment" autocomplete="interest">
{{--                                <span class="help-block">Please enter complete loan repayment, interest will be calculated automatically.</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="hf-email">Shares</label>
                            <div class="col-md-9">
                                <input class="form-control formattedNumberField" id="shares" type="text" name="shares" placeholder="Enter Shares" autocomplete="shares">
{{--                                <span class="help-block">Please enter complete loan repayment, interest will be calculated automatically.</span>--}}
                            </div>
                        </div>
                        <input type="hidden" name="member" value="{{ $member->id }}">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="hf-email">Building</label>
                            <div class="col-md-9">
                                <input class="form-control formattedNumberField" id="building" type="text" name="building" placeholder="Enter Building" autocomplete="building">
{{--                                <span class="help-block">Please enter complete loan repayment, interest will be calculated automatically.</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="Spesavings">Special Savings</label>
                            <div class="col-md-9">
                                <input class="form-control formattedNumberField" id="Spesavings" type="text" name="spesavings" placeholder="Enter Special Savings" autocomplete="spesavings">
                                {{--                                <span class="help-block">Please enter your email</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="postType">Mode of Payment</label>
                            <div class="col-md-9">
                                <select class="form-control" id="postMode" name="mode">
                                    <option value="bank">Bank Transfer</option>
                                    <option value="cash">Cash</option>
                                    <option value="savings">Savings</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button id="postBTN" class="btn btn-success" type="button">Post</button>
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
    <div class="modal fade" id="dangerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Give Loan</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($member->getLoan())
                        <div>
                            <h3>{{ Str::title($member->name) }} is currently servicing a loan.</h3>
                        </div>
                    @else
                        <form id="loanForm" action="{{ route('giveLoan') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="loanType">Type</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="loanType" name="type">
                                        <option value="normal">Normal Loan</option>
                                        <option value="emergency">Emergency</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="duration">Duration</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="duration" name="duration">
                                        <option value="1">1 Month</option>
                                        <option value="6">6 Months</option>
                                        <option value="12">12 Months</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="hf-email">Amount</label>
                                <div class="col-md-9">
                                    <input class="form-control formattedNumberField" id="amount" type="text" name="amount" placeholder="Enter Amount" autocomplete="savings">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Surety</label>
                                <div class="col-md-9">
                                    <select class="form-control select2-multiple" id="select2-2" name="surety[]" multiple="">
                                        @foreach($members as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="loanType">Mode of Payment</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="loanMode" name="mode">
                                        <option value="bank">Bank Transfer</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="member" value="{{ $member->id }}">
                        </form>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    @if(!$member->getLoan())
                        <button class="btn btn-primary" id="giveLoan" type="button">Approve Loan</button>
                    @endif
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
    <div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Withdraw</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="withForm" action="{{ route('withdraw') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="withType">Withdraw from</label>
                            <div class="col-md-9">
                                <select class="form-control" id="withType" name="from">
                                    <option value="saving">Savings</option>
                                    <option value="shares">Shares</option>
                                    @if($member->getsSaving() > 0)
                                        <option value="special">Special</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="ammm">Amount</label>
                            <div class="col-md-9">
                                <input class="form-control formattedNumberField" id="ammm" type="text" name="amount" placeholder="Enter Amount" autocomplete="savings">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="withMode">Mode of Payment</label>
                            <div class="col-md-9">
                                <select class="form-control" id="withMode" name="mode">
                                    <option value="bank">Bank Transfer</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="member" value="{{ $member->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="withdrawS" type="button">Withdraw</button>
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
@endsection

@section('script')
    <script>
        $('.reLoan').click(function(){
           const id = $(this).val();
            swal({
                    title: "Are you sure?",
                    // text: "Your are approving loan ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Reverse Post!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post("{{ route('reloan') }}", {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        }).then(data => {
                            swal(data.message, "", 'success');
                            location.reload();
                        })
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        });
        $('.reSavings').click(function(){
            const id = $(this).val();
            swal({
                    title: "Are you sure?",
                    // text: "Your are approving loan ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Reverse Post!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post("{{ route('reSavings') }}", {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        }).then(data => {
                            swal(data.message, "", 'success');
                            location.reload();
                        })
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        });
        $('.reShare').click(function(){
            const id = $(this).val();
            swal({
                    title: "Are you sure?",
                    // text: "Your are approving loan ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Reverse Post!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post("{{ route('reShare') }}", {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        }).then(data => {
                            swal(data.message, "", 'success');
                            location.reload();
                        })
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        });
        $('.reBuilding').click(function(){
            const id = $(this).val();
            swal({
                    title: "Are you sure?",
                    // text: "Your are approving loan ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Reverse Post!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post("{{ route('reBuilding') }}", {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        }).then(data => {
                            swal(data.message, "", 'success');
                            location.reload();
                        })
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        });
        const del = (id) => {
            swal({
                    title: "Are you sure?",
                    // text: "Your are approving loan ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete member!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post('/remove_exco/', {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        }).then(data => {
                            swal(data, '', 'success');
                            location.reload();
                        })
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        }

        $('#next').click(function(){
            window.location.href = "{{ route('member', $next[0]->id) }}";
        });

        $('#prev').click(function(){
            window.location.href = "{{ route('member', $prev[0]->id) }}";
        });

        $('#mExco').click(function(){
            $('#makeExco').modal('show');
        });

        $('#withdraw').click(function(){
            $('#withdrawModal').modal('show');
        });

        $('#mkExco').click(function(){
            swal({
                    title: "Are you sure?",
                    // text: "Your are approving loan ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Make Exco!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        const form = document.querySelector('#excoForm');
                        form.submit();
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        });

        @if(isset($loan->id))
            $('#reverseB').click(function(){
                swal({
                        title: "Are you sure?",
                        // text: "Your are approving loan ",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Reverse Loan!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.get("{{ route('rr', $loan->id) }}").then(data => {
                                swal(data.message, '', 'success');
                                location.reload();
                            });
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
        @endif
        $('#withdrawS').click(function(){
            swal({
                    title: "Are you sure?",
                    // text: "Your are approving loan ",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Make Withdrawal!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        const form = document.querySelector('#withForm');
                        form.submit();
                    } else {
                        swal("Cancelled", "", "error");
                    }
                });
        });
        $(document).ready(function () {
            $('#select2-2').select2({
                theme: 'bootstrap'
            });
            const rel = () => {
              location.reload();
            };
            $('#giveLoan').click(function () {
                swal({
                        title: "Are you sure?",
                        // text: "Your are approving loan ",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, approve loan!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            const form = document.querySelector('#loanForm');
                            form.submit();
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
            $('#postBTN').click(function () {
                swal({
                        title: "Are you sure?",
                        // text: "Your are approving loan ",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, post!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            const form = document.querySelector('#postForm');
                            form.submit();
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
            $('#postFine').click(function () {
                swal({
                        title: "Are you sure?",
                        // text: "Your are approving loan ",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, fine!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            const form = document.querySelector('#fineForm');
                            form.submit();
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
            $('#utilBuy').click(function () {
                swal({
                        title: "Are you sure?",
                        // text: "Your are approving loan ",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, buy utility!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            const form = document.querySelector('#utilForm');
                            form.submit();
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
            $('#xAdmin').click(function () {
                const id = $(this).val();
                const url = `/revokeAdmin/${id}`;
                swal({
                        title: "Are you sure?",
                        // text: "Your are approving loan ",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, revoke Admin!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.get(url).then((data) => {
                                swal("Successful", data, "success");
                                setTimeout(rel, 2000);
                            }, err => {
                                swal("Error", "Something went wrong, please refresh and try again", "error");
                            })
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
            $('#mAdmin').click(function () {
                const id = $(this).val();
                const url = `/makeAdmin/${id}`;
                swal({
                        title: "Are you sure?",
                        // text: "Your are approving loan ",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, make Admin!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.get(url).then((data) => {
                                swal("Successful", data, "success");
                                setTimeout(rel, 2000);
                            }, err => {
                                swal("Error", "Something went wrong, please refresh and try again", "error");
                            })
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });

        });
    </script>
    @if(Session::has('error'))
        <script>
            toastr.error("{{ Session::get('error') }}", 'Error');
        </script>
    @endif
    <script>
        const divs = document.querySelectorAll('.formattedNumberField');

        divs.forEach(el => el.addEventListener('keyup', event => {
            // console.log(event.target.value);
            const selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }
            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            const input = event.target.value;
            let output = input.replace(/[\D\s\._\-]+/g, "");
            output = output ? parseInt( input, 10 ) : 0;
            output = ( output === 0 ) ? "" : output.toLocaleString( "en-US" );
            event.target.value = output;
            console.log(output);
        }));
        const loan = document.querySelector('#loan');
        const interest = document.querySelector('#interest');
        const spa = document.querySelector('#spa');
        const balance = "{{ $member->getLoan() }}";
        let last = "{{ $member->getLastPay() }}";
        // if (+last === 0) {
        //     last = 1;
        // }
        console.log('last', last);
        loan.addEventListener('blur', () => {
            const pay = loan.value;
            const int = (0.01 * balance) * last;
            const loa = pay - int;
            interest.value = int.toFixed(2);
            loan.value = loa.toFixed(2);
        })
    </script>
@endsection
