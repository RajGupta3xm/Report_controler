@extends('driver.layout.master')
@section('content')
    <div class="main_screens">
        <div class="header_part">
            <div class="row align-items-center w-100 justify-content-between">
                <div class="col-2 px-1">
                    <a class="back_btn" href="{{route('navigation',$order->id)}}">
                        <i class="fas fa-angle-left"></i>
                    </a>
                </div>
                <div class="col-8 px-1 header_logo text-center">
                    <img src="{{asset('driver-assets/img/logo.png')}}" alt="">
                </div>
                <div class="col-2 px-1">
                    <a class="profile_heder" href="{{route('profile')}}">
                        <img src="{{Auth::guard('staff_members')->user()->image}}" alt="">
                    </a>
                </div>
            </div>
        </div>
        <div class="inner_part">
            <div class="row">
                <div class="col-12 comman_heading mb-5">
                    <h2>Cancel</h2>
                </div>
                <div class="col-12">
                    <div class="cancel_delivery">
                        <form class="row" action="{{route('submitcancelorder')}}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            <div class="form-group col-12 custom_checkbox mb-3">
                                <input type="radio" id="check1" name="check1" value="door_locked">
                                <label for="check1">Door Locked</label>
                            </div>
                            <div class="form-group col-12 custom_checkbox mb-3">
                                <input type="radio" checked id="check2" name="check1" value="no_answer_from_customer">
                                <label for="check2">No Answer from customer end</label>
                            </div>
                            <div class="form-group col-12 custom_checkbox mb-3">
                                <input type="radio" id="check3" name="check1" value="other">
                                <label for="check3">Other :</label>
                                <textarea class="form-control" name="other_note" id=""></textarea>
                            </div>
                            <div class="form-group col-12 mt-1">
                                <a class="comman_btn" href="javascript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Submit</a>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade sure_to" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-body py-4">
                    <div class="row justify-content-center text-center py-3">
                        <div class="col-12 sure_to_content">
                            <i class="fas fa-check-circle"></i>
                            <h3>Are You Sure ?</h3>
                        </div>
                        <div class="col-6 pe-1">
                            <input type="hidden" name="type" value="2">
                            <button class="comman_btn" type="submit">Yes</button>

                        </div>
                        <div class="col-6 ps-1">
                            <a class="comman_btn bg-danger" data-bs-dismiss="modal" href="javascript:;">No</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

@endsection

