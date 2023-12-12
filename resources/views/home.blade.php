@extends('layout.app')

@section('title', 'Welcome to My Laravel App')

@section('nav')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container p-1">
        <h5>My Laravel App</h5>
        <button class="btn btn-primary btn-sm" type="button" id="logout-btn">Logout</button>
    </div>
</nav>
@endsection

@section('content')
    <div class="container">
        <div class="card mx-auto" style="width: 60%;margin-top: 100px">
        <div class="card-body">
            <h3 class="card-title mb-3">Welcome to my Laravel App</h3>
            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Curabitur venenatis massa in sapien fringilla hendrerit in vel risus. Sed quis lorem dolor. 
                Praesent nisi ex, tempus sit amet velit at, sagittis hendrerit arcu. Donec viverra, ligula sed dapibus tempus, risus lectus mollis erat, 
                eu ultricies sem tellus sit amet dui.
            </p>
        </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    let logoutBtn = document.getElementById('logout-btn');

    logoutBtn.addEventListener('click', logout);

    function logout(e){
        e.stopPropagation();
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: "{{ url('/logout') }}",
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    // Redirect to the dashboard on success
                    // window.location.href = response.redirect;
                    console.log(response);
                    Swal.fire({
                        title: '',
                        text: 'Successfully logged out',
                        icon: 'success',
                    })

                    window.location.href = '{{ url("/login") }}'

                } else {
                    // Display error message
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    })

                }
            },
            error: function (error) {
               console.log('errrorrrrr', error);
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