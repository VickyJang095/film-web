<style>
    .container{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 75%;
        height: 550px;
        background: url('/images/background.jpg') no-repeat;
        background-size: cover;
        background-position: center;
        border-radius: 20px;
        margin-top: 20px;
    }   
    
    .container .content {
        position: absolute;
        top: 0;
        left: 0;
        width: 50%;
        height: 100%;
        padding: 70px;
        color: #e4e4e4;
        display: flex;
        flex-direction: column;
        justify-content: flex-start; 
    }

    .container .logreg-box {
        position: absolute;
        top: 0;
        right: 0;
        width: calc(100% - 58%);
        height: 100%;
    }

    .container .logo {
        font-size: 30px;
    }

    .content h2 {
        font-size: 30px;
        margin-top: -20px;
    }

    .content .title {
        margin-bottom: 200px; 
    }

    .text-sci h2 {
        font-size: 40px;
        line-height: 1;
    }

    .text-sci h2 span {
        font-size: 25px; 
    }

    .text-sci p {
        font-size: 16px;
        margin: 20px 0;
    }

    .social-icons a i{
        font-size: 22px;
        color: #e4e4e4;
        margin-right: 10px;
        transition: .5s ease;
    }

    .social-icons a:hover i {
        transform: scale(1.2);
    }

    .logreg-box .form-box {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        background: transparent;
        backdrop-filter: blur(20px);
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        color: #e4e4e4;
    }

    .form-box h2 {
        font-size: 32px;
        text-align: center;
    }

    .form-box .input-box {
        position: relative;
        width: 340px;
        height: 50px;
        border-bottom: 2px solid #e4e4e4;
        margin: 30px 0;
    }

    .input-box input {
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        margin-top: 5px;
        font-size: 18px;
        color: #e4e4e4;
        font-weight: 300;
    }

    .input-box label {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translate(-5%);
        font-size: 18px;
        font-weight: 300;
        pointer-events: none;
        transition: .5s ease;
    }

    .input-box input:focus~label,
    .input-box input:valid~label {
        top: -5px;
    }

    .input-box .icon {
        position: absolute;
        right: 0;
        top: 13px;
        font-size: 19px;
    }

    .form-box .remember-forgot {
        font-size: 14.5px;
        font-weight: 300;
        margin: -15px 0 15px;
        display: flex;
        justify-content: space-between;
    }

    .remember-forgot label input {
        accent-color: #e4e4e4;
        margin-right: 3px;
    }

    .remember-forgot a {
        color: #e4e4e4;
        text-decoration: none;
    }

    .remember-forgot a:hover {
        text-decoration: underline;
    }

    .btn {
        width: 100%;
        height: 45px;
        background: linear-gradient(90deg, #f94ca4, #f14668);
        border-radius: 20px;
        color:#e4e4e4;
        border: none;
        outline: none;
        font-weight: 300;
        box-shadow: 0 0 10px rgba(0, 0, 0, .5);
    }
    
    .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(249, 76, 164, 0.5);
        color: white;
    }

    .form-box .login-register {
        font-size: 14.5px;
        text-align: center;
        font-weight: 300;
        margin-top: 25px;
    }

    .login-register p a {
        color: #e4e4e4;
        font-weight: 400;
        text-decoration: none;
    }
    .login-register p a:hover { 
        text-decoration: underline;
    }
</style>

<x-guest-layout>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="content">
            <h2 class="title"><i class='bx bx-play-circle' class="logo"></i> Film Web</h2>

            <div class="text-sci">
                <h2>Confirm Password<br><span>Secure Access</span></h2>
                <p>This is a secure area of the application. Please confirm your password before continuing.</p>

                <div class="social-icons">
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                </div>
            </div>
        </div>

        <div class="logreg-box">
            <div class="form-box confirm">
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <h2>Confirm Password</h2>

                    <div class="input-box">
                        <span class="icon"><i class="bx bxs-lock-alt"></i></span>
                        <input type="password" name="password" required autocomplete="current-password">
                        <label>Password</label>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn rounded-4">Confirm</button>

                    <div class="login-register mt-4">
                        <p><a href="{{ route('password.request') }}">Forgot your password?</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
