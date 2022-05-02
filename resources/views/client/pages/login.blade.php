@extends('client.master')
@section('content')
<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
            		<div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Đăng nhập</h3>
                        </div>
                        <form method="post" action="{{asset('/post-login')}}">
                            @csrf
                            @if ($errors->signin->first('orther'))
                                <span class="text-danger d-block mb-2">
                                    * {{ $errors->signin->first('orther') }}
                                </span>
                            @endif
                            <div class="form-group">
                                @if (session('email'))
                                    <input type="email" value="{{session('email')}}" class="form-control" name="email" placeholder="Nhập Email">
                                @else
                                    <input type="email" class="form-control" name="email" placeholder="Nhập Email">
                                @endif

                                @if ($errors->signin->first('email'))
                                    <span class="text-danger d-block mt-2">
                                        * {{ $errors->signin->first('email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                    <input class="form-control" type="password" name="password" placeholder="Mật khẩu">

                                @if ($errors->signin->first('password'))
                                    <span class="text-danger d-block mt-2">
                                        * {{ $errors->signin->first('password') }}
                                    </span>
                                @endif
                            </div>
                            <div class="login_footer form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                        <label class="form-check-label" for="exampleCheckbox1"><span>Nhớ tài khoản</span></label>
                                    </div>
                                </div>
                                <a href="#">Quên mật khẩu?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block" name="login">Đăng nhập</button>
                            </div>
                        </form>
                        <div class="different_login">
                            <span> hoặc</span>
                        </div>
                        {{-- <ul class="btn-login list_none text-center">
                            <li><a href="#" class="btn btn-facebook"><i class="ion-social-facebook"></i>Facebook</a></li>
                            <li><a href="#" class="btn btn-google"><i class="ion-social-googleplus"></i>Google</a></li>
                        </ul> --}}
                        <div class="form-note text-center">Chưa có tài khoản? <a href="{{asset('/register')}}">Tạo tài khoản</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
