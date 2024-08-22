<!-- resources/views/login.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Login</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            
            <!-- Add CAPTCHA Image -->
            <div class="form-group">
                <label for="captcha">Captcha</label>
                <div>
                    <img src="{{ captcha_src('flat') }}" alt="captcha" class="captcha-img" data-refresh-config="default"/>
                    <button type="button" id="refreshCapta" class="btn btn-info btn-refresh">Refresh</button>
                </div>
            </div>

            <!-- CAPTCHA Input -->
            <div class="form-group">
                <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Enter Captcha" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
@endsection

<!-- Add JavaScript to refresh CAPTCHA -->
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var captchaInput = document.getElementById('refreshCapta');
        console.log(captchaInput);

        captchaInput.addEventListener('click', function () {
            // Reload the page when the captcha input field is focused
            location.reload();
        });
    });
</script>
    <script type="text/javascript">
        document.querySelector('.btn-refresh').addEventListener('click', function(){
            const captchaImage = document.querySelector('.captcha-img');
            const url = `/captcha/default?` + Math.random();
            captchaImage.src = url;
        });
    </script>
    
  
@endsection
