<form action="{{route('user.registiration')}}" method="post" enctype="multipart/form-data">
    @csrf
<section className="login column col-12 overflow-hidden position-relative">
        <div className="inp input1 col-11 col-lg-3 col-md-6 col-sm-11">
          <h2 className="w-100">Sign Up</h2>
        </div>
        <div className="inp input2 col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " name="name" type="text" placeholder="Name" value="{{ old('name') }}" />
          @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </div>
        <div className="inp input2 col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " type="email"name="email" placeholder="Email"  value="{{ old('email') }}"/>
          @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>
        <div className="inp input3 col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " id="password"  type="password" name="password" placeholder="password"value="{{ old('password') }}" />
          @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </div>
        <div className="inp  input3  col-11 col-lg-3 col-md-6 col-sm-11">
          <input className="col-12 " type="password" id="password" name="re_password" placeholder="Re-enter Password"value="{{ old('Re_enterPassword') }}" />
          @error('Re_enterPassword')
        <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </div>
        <input type="file" name="photo">
        <div className="inp input5 col-11 col-lg-3 col-md-6 col-sm-11">
          <button type="submit">sumbit</button>
        </div>
        
</form>

<a href="{{route('loginform.user')}}">login</a>