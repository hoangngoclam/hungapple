@extends('client.master')
@section('content')
<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
            		<div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Tạo tài khoản</h3>
                        </div>
                        @if ($errors->signup->first('orther'))
                            <span class="text-danger d-block mt-2">
                                * {{ $errors->signup->first('orther') }}
                            </span>
                        @endif

                        <form method="post" action="{{asset('/post-register')}}">
                            @csrf
                            <div class="form-group">
                                @if (session('email'))
                                    <input type="email" value="{{session('email')}}" class="form-control" name="email" placeholder="Nhập email">
                                @else
                                    <input type="email" class="form-control" name="email" placeholder="Nhập email">
                                @endif

                                @if ($errors->signup->first('email'))
                                    <span class="text-danger d-block mt-2">
                                        * {{ $errors->signup->first('email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">

                                @if (session('password'))
                                    <input class="form-control" value="{{session('password')}}" type="password" name="password" placeholder="Mật khẩu">
                                @else
                                    <input class="form-control" type="password" name="password" placeholder="Mật khẩu">
                                @endif
                                @if ($errors->signup->first('password'))
                                <span class="text-danger d-block mt-2">
                                    * {{ $errors->signup->first('password') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                @if (session('confirmPassword'))
                                    <input class="form-control" value="{{session('confirmPassword')}}" type="password" name="confirmPassword" placeholder="Xác nhận mật khẩu">
                                @else
                                    <input class="form-control" type="password" name="confirmPassword" placeholder="Xác nhận mật khẩu">
                                @endif
                                @if ($errors->signup->first('confirmPassword'))
                                <span class="text-danger d-block mt-2">
                                    * {{ $errors->signup->first('confirmPassword') }}
                                </span>
                                @endif
                            </div>
                            {{-- <div class="login_footer form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                        <label class="form-check-label" for="exampleCheckbox2"><span>I agree to terms &amp; Policy.</span></label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block" name="register">Đăng ký</button>
                            </div>
                        </form>
                        <div class="different_login">
                            <span> Hoặc</span>
                        </div>
                        {{-- <ul class="btn-login list_none text-center">
                            <li><a href="#" class="btn btn-facebook"><i class="ion-social-facebook"></i>Facebook</a></li>
                            <li><a href="#" class="btn btn-google"><i class="ion-social-googleplus"></i>Google</a></li>
                        </ul> --}}
                        <div class="form-note text-center">Bạn đã có tài khoản trước đó? <a href="{{asset('/login')}}">Đăng nhập</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
