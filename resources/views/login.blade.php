@extends('layout.app')

@section('title', 'Login')

@section('content')
    <div class="container">
        <div class="card mx-auto py-3" style="width: 30%;margin-top: 100px">
        
        <div class="card-body">
            <h3 class="card-title mb-3">Login</h3>
            <div class="mt-4">
                <form id="login-form">
                    @csrf
                    <div class="col mt-3">
                        <div class="mb-3 mt-3">
                            <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="Email" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Password" required>
                        </div>
                        <div class="text-end mt-4 d-grid gap-2">
                            <button class="btn btn-primary btn-sm" type="submit" id="login-btn">Login</button>
                        </div>
                    </div>
                </form>
                <br>
                <div class="text-center">
                    <p>Don't have an account? <a href="/register">Register here.</a></p>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    let form = document.getElementById('login-form');
    let loginBtn = document.getElementById('login-btn');

    form.addEventListener('submit', login);
    
    function login(e){
        e.stopPropagation();
        e.preventDefault();
        
        loginBtn.disabled = true;
        loginBtn.innerText = 'Logging you in...';

        let formValues = e.target;

        let dataToPass = {
            _token: formValues[0].value,
            email: formValues[1].value,
            password: formValues[2].value
        }

        $.ajax({
            type: 'POST',
            url: "{{ url('/auth/login') }}",
            data: dataToPass,
            success: function (response) {
                if (response.success) {
                    // Redirect to the dashboard on success
                    // window.location.href = response.redirect;
                    console.log(response);
                    Swal.fire({
                        title: '',
                        text: 'Successfully logged in',
                        icon: 'success',
                    })
                    loginBtn.disabled = false;
                    loginBtn.innerText = 'Login';

                    if (response.type === 'admin') {
                        
                        window.location.href = '{{ url("/accounts") }}'
                    }else{
                        window.location.href = '{{ url("/home") }}'
                    }


                } else {
                    // Display error message
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    })
                    loginBtn.disabled = false;
                    loginBtn.innerText = 'Login';

                }
            },
            error: function (error) {
               console.log('errrorrrrr', error);
                loginBtn.disabled = false;
                loginBtn.innerText = 'Login';
                Swal.fire({
                    title: 'Error',
                    text: error.responseJSON.message,
                    icon: 'error',
                })
            }
        });
    }
</script>
@endsection