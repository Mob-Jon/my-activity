@extends('layout.app')

@section('title', 'Register')

@section('content')
    <div class="container">
        <div class="card mx-auto py-3" style="width: 30%;margin-top: 100px">
        
        <div class="card-body">
            <h3 class="card-title mb-3">Register</h3>
            <div class="mt-4">
                <form id="register-form">
                    @csrf
                    <div class="col mt-3">
                        <div class="mb-3 mt-3">
                            <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Name" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <input type="text" name="phone_number" id="number" class="form-control form-control-sm" placeholder="Phone number" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="Email" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Password" required>
                        </div>
                        <div class="text-end mt-4 d-grid gap-2">
                            <button class="btn btn-primary btn-sm" type="submit" id="register-btn">Register</button>
                        </div>
                    </div>
                </form>
                <br>
                <div class="text-center">
                    <p>Already have an account? <a href="/login">Login here.</a></p>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    let form = document.getElementById('register-form');
    let registerBtn = document.getElementById('register-btn');

    form.addEventListener('submit', register);
    
    function register(e){
        e.stopPropagation();
        e.preventDefault();
        
        registerBtn.disabled = true;
        registerBtn.innerText = 'Registering...';

        let formValues = e.target;
        console.log(e);

        let dataToPass = {
            _token: formValues[0].value,
            name: formValues[1].value,
            phone_number: formValues[2].value,
            email: formValues[3].value,
            password: formValues[4].value
        }

        $.ajax({
            type: 'POST',
            url: "{{ url('/register') }}",
            data: dataToPass,
            success: function (response) {
                if (response.success) {
                    // Redirect to the dashboard on success
                    // window.location.href = response.redirect;
                    console.log(response);
                    Swal.fire({
                        title: '',
                        text: 'Successfully registered account',
                        icon: 'success',
                    })
                    registerBtn.disabled = false;
                    registerBtn.innerText = 'Register';

                    window.location.href = '{{ url("/login") }}'

                } else {
                    // Display error message
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    })
                    registerBtn.disabled = false;
                    registerBtn.innerText = 'Register';

                }
            },
            error: function (error) {
               console.log('errrorrrrr', error);
                registerBtn.disabled = false;
                registerBtn.innerText = 'Register';
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