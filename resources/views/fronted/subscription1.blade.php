
@extends('layouts.front_layouts.layouts')
@section('content')
{{--
@foreach ($data as $data1)



    <div class="thumbnail">
        <div class="caption">
            <h4 style="text-align:center">
                    <a class="btn btn-primary" href="#">

                        {{$data1->subscription_plan}}
                        {{ $data1->amount }} USD
                    </a>
                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=ZDPQ8R4KARWGG" method="post">
                        <input type="hidden" name="return" value="{{ url('paypal/subscriptionsuccess?amount=100&&plan=simple')}}">
                        <input type="hidden" name="cancel_return" value="{{ url('paypal/fail')}}">
                        <input type="image" name="submit" id="cancelsub" src="https://www.sandbox.paypal.com/en_GB/i/btn/btn_unsubscribe_LG.gif" alt="Subscribe">

                        </form>


            </h4>
        </div>
    </div>

@endforeach --}}


<ul class="thumbnails">

        <li class="span3">
            <div class="thumbnail">
                <div class="caption">
                    <h4 style="text-align:center">
                            <a class="btn btn-primary" href="#">
                                1 USD
                            </a>

                            <p>Silver</p>

                            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post"> <!-- Identify your business so that you can collect the payments. -->

                                <input type="hidden" name="business" value="sb-tndxg16913671@business.example.com"> <!-- Specify a Subscribe button. -->
                                <input type="hidden" name="cmd" value="_xclick-subscriptions"> <!-- Identify the subscription. -->
                                <input type="hidden" name="item_name" value="ABC">
                                <input type="hidden" name="currency_code" value="USD">
                                <input type="hidden" name="a3" value="1">
                                <input type="hidden" name="p3" value="1">
                                <input type="hidden" name="t3" value="D">
                                <input type="hidden" name="src" value="1">


                                <input type="hidden" name="return" value="{{ url('paypal/subscriptionsuccess?amount=1&&plan=silver')}}">
                                <input type="hidden" name="cancel_return" value="{{ url('paypal/fail')}}">

                                @php
                                    $data = DB::table('subscription')->where('user_id',Auth::user()->id)->where('amount',1)->where('is_subscribe',1)->get();

                                    if(count($data) == 1){
                                        echo "Already Subscribed";
                                    }else{
                                        echo '<input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif" alt="Subscribe"><img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">';
                                    }
                                @endphp

                            </form>

                            {{-- <A HREF="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=ZDPQ8R4KARWGG">
                                <IMG SRC="https://www.sandbox.paypal.com/en_GB/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
                            </A> --}}


                    </h4>
                </div>
            </div>
        </li>

        <li class="span3">
            <div class="thumbnail">
                <div class="caption">
                    <h4 style="text-align:center">
                        <a class="btn btn-primary" href="#">
                            2 USD
                        </a>
                        <p>Gold</p>
                        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post"> <!-- Identify your business so that you can collect the payments. -->

                            <input type="hidden" name="business" value="sb-tndxg16913671@business.example.com"> <!-- Specify a Subscribe button. -->
                            <input type="hidden" name="cmd" value="_xclick-subscriptions"> <!-- Identify the subscription. -->
                            <input type="hidden" name="item_name" value="ABC">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="a3" value="2">
                            <input type="hidden" name="p3" value="1">
                            <input type="hidden" name="t3" value="D">
                            <input type="hidden" name="src" value="1">

                            <input type="hidden" name="return" value="{{ url('paypal/subscriptionsuccess?amount=2&&plan=gold')}}">
                            <input type="hidden" name="cancel_return" value="{{ url('paypal/fail')}}">

                            @php
                            $data = DB::table('subscription')->where('user_id',Auth::user()->id)->whereAmount(2)->where('is_subscribe',1)->get();

                            if(count($data) == 1){
                                echo "Already Subscribed";
                            }else{
                                echo '<input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif" alt="Subscribe"><img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >';
                            }
                        @endphp

                        </form>

                        {{-- <A HREF="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=ZDPQ8R4KARWGG">
                            <IMG SRC="https://www.sandbox.paypal.com/en_GB/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
                        </A> --}}

                    </h4>
                </div>
            </div>
        </li>

        <li class="span3">
            <div class="thumbnail">
                <div class="caption">
                    <h4 style="text-align:center">
                        <a class="btn btn-primary" href="#">
                            3 USD
                        </a>
                        <p>Diamond</p>
                        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post"> <!-- Identify your business so tha-->
                                {{ Session::put('plan','premium') }}
                            <input type="hidden" name="business" value="sb-tndxg16913671@business.example.com"> <!-- Specify a Subscribe button. -->
                            <input type="hidden" name="cmd" value="_xclick-subscriptions"> <!-- Identify the subscription. -->
                            <input type="hidden" name="item_name" value="ABC">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="a3" value="3">
                            <input type="hidden" name="p3" value="1">
                            <input type="hidden" name="t3" value="D">
                            <input type="hidden" name="src" value="1">

                            <input type="hidden" name="return" value="{{ url('paypal/subscriptionsuccess?amount=3&&plan=diamond')}}">
                            <input type="hidden" name="cancel_return" value="{{ url('paypal/fail')}}">
                            @php
                            $data = DB::table('subscription')->where('user_id',Auth::user()->id)->where('amount',3)->where('is_subscribe',1)->get();

                            if(count($data) == 1){
                                echo "Already Subscribed";
                            }else{
                                echo '<input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif" alt="Subscribe"><img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >';
                            }
                        @endphp

                        </form>

                        {{-- <A HREF="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=ZDPQ8R4KARWGG">
                            <IMG SRC="https://www.sandbox.paypal.com/en_GB/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
                        </A> --}}


                    </h4>
                </div>
            </div>
        </li>

</ul>
@endsection
