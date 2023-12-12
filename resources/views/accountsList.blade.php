@extends('layout.app')

@section('title', 'Home')

@section('nav')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container p-1">
        <h5 class="navbar-brand">My Laravel App</h5>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/accounts">Account Lists</a>
                </li>
            </ul>
        </div>
        <button class="btn btn-primary btn-sm" type="button" id="logout-btn">Logout</button>
    </div>
</nav>
@endsection

@section('content')
    <div class="container" style="margin-top: 90px">
        <table class="table table-hover">
            <caption>List of accounts</caption>
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Email</th>
                @if (session()->get('type') === "admin")
                    <th scope="col">Actions</th>
                @endif
              </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->email }}</td>
                        @if (session()->get('type') === "admin")
                            <td>
                                <button class="btn btn-sm btn-info" id="edit-btn" onclick="edit({{ $user->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger" id="delete-btn" onclick="deleteAccount()">Delete</button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
          </table>
    </div>
  
  <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            {{-- <div class="modal-dialog modal-dialog-centered"> --}}
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control form-control-sm" required name="id" id="id-input" hidden>
                <div class="my-2">
                    <label for="name" style="font-weight: 500">Name</label>
                    <input type="text" class="form-control form-control-sm" required name="name" id="name-input">
                </div>
                <div class="my-2">
                    <label for="name" style="font-weight: 500">Phone Number</label>
                    <input type="text" class="form-control form-control-sm" required name="name" id="number-input">
                </div>
                <div class="my-2">
                    <label for="email" style="font-weight: 500">Email</label>
                    <input type="text" class="form-control form-control-sm" required name="email" id="email-input">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel-btn">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="editAccount()" id="edit-account-btn">Edit</button>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    let logoutBtn = document.getElementById('logout-btn');
    let editBtn = document.getElementById('edit-btn');
    let deleteBtn = document.getElementById('delete-btn');
    let cancelBtn = document.getElementById('cancel-btn');
    let editAccountBtn = document.getElementById('edit-account-btn');

    let nameInpt = document.getElementById('name-input');
    let emailInpt = document.getElementById('email-input');
    let idInpt = document.getElementById('id-input');
    let numberInpt = document.getElementById('number-input');

    logoutBtn.addEventListener('click', logout);

    let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {});
    
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

    function getAccountById(userId){
        
        $.ajax({
            type: 'POST',
            url: "{{ url('/get/account') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id': userId
            },
            success: function (response) {
                if (response.success) {
                    myModal.show()
                    let userInfo = response.userInfo[0];

                    nameInpt.value = userInfo.name.toUpperCase();
                    emailInpt.value = userInfo.email.toUpperCase();
                    numberInpt.value = userInfo.phone_number;
                    idInpt.value = userInfo.id;

                } else {
                    // Display error message
                    Swal.fire({
                        title: 'Error',
                        text: error.responseJSON.message,
                        icon: 'error',
                    })

                }
            },
            error: function (error) {
                Swal.fire({
                    title: 'Error',
                    text: error.responseJSON.message,
                    icon: 'error',
                })
            }
        });
    }

    function edit(id) {

        getAccountById(id)

    }

    function editAccount() {
        editAccountBtn.disabled = true;
        cancelBtn.disabled = true;
        editAccountBtn.innerText = 'Updating...';
        
        let userId = idInpt.value;
        let phone_number = numberInpt.value;
        let email = emailInpt.value.toLowerCase();
        let name = nameInpt.value.toLowerCase();

        $.ajax({
            type: 'PUT',
            url: "{{ url('/update/account') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id': userId,
                phone_number,
                email,
                name,
            },
            success: function (response) {
                if (response.success) {

                    editAccountBtn.disabled = false;
                    cancelBtn.disabled = false;
                    editAccountBtn.innerText = 'Edit';
                    myModal.hide()

                    Swal.fire({
                        title: '',
                        text: response.message,
                        icon: 'success',
                    })


                } else {
                    editAccountBtn.disabled = false;
                    cancelBtn.disabled = false;
                    editAccountBtn.innerText = 'Edit';
                    
                    myModal.hide()
                    // Display error message
                    Swal.fire({
                        title: 'Error',
                        text: error.responseJSON.message,
                        icon: 'error',
                    })

                }
            },
            error: function (error) {
                editAccountBtn.disabled = false;
                cancelBtn.disabled = false;
                editAccountBtn.innerText = 'Edit';

                myModal.hide()

                Swal.fire({
                    title: 'Error',
                    text: error.responseJSON.message,
                    icon: 'error',
                })
            }
        });

    }

    function deleteAccount() {
        Swal.fire({
            title: 'Confirmation',
            text: 'Are you sure you want to delete account?',
            icon: 'warning',
        })
    }


</script>
@endsection