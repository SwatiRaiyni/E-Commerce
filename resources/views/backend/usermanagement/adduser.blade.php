@extends('layouts.backend_layouts.layouts')
@section('content')
<div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">User Management</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add User</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-card>
                        <x-slot name="logo">
                            <a href="#">
                                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                            </a>
                        </x-slot>
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                     <form  action="/admin/createnewuser" method="POST" encType="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user" value="1">

                        <!-- Name -->
                        <div>
                            <x-label for="firstname" :value="__('FirstName')" />
                            <x-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="lastname" :value="__('LastName')" />
                            <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus />
                        </div>

                        <!-- DOB -->
                        <div class="mt-4">
                            <x-label for="dob" :value="__('DoB')" />
                            <x-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required />
                        </div>

                        <!--profile picture -->
                        <div class="mt-4">
                            <x-label for="image"  :value="__('Select Profile')" />
                            <x-input type="file" id="image" name="image" class=" block mt-1 w-full" :value="old('image')" required />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        </div>

                        <!--select status -->
                        <div class="mt-4">
                            <x-label for="checkactive" :value="__('Status')" />
                            <select name="checkactive" id="" required :value="old('checkactive')" class="form-select block mt-1 w-full checkactive" aria-label="Default select example">
                                <option value="1" >Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="checktype" :value="__('Type')" />

                            <select name="checktype" id="type_sel" required onchange="roleselect();" class="form-select block mt-1 w-full" aria-label="Default select example">
                                <option value="">select</option>
                                <option value="1">Front User</option>
                                <option value="2">Backend User</option>
                            </select>
                        </div>




                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />
                            <x-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button  class="butsave" class="ml-4">
                                {{ __('Add') }}
                            </x-button>
                            <a type="button" href="/" class="btn btn-danger ml-4">Cancel</a>
                        </div>
                    </form>
                </x-auth-card>
</div>
</div>
</div>
</div>
</x-app-layout>

<script>

function roleselect(){
    var type_sel = $("#type_sel").val();
    var language = window.location.pathname.substring(1,3);
    $.ajax({
    url:"/"+language+"/addnewuser",
    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
    type: 'GET',
    dataType:'json',
    data :{
      "_token": "{{ csrf_token() }}",
      "type_sel" : type_sel,
    },
    success:function(data){
       console.log(data);

        var count = Object.keys(data).length;
        $('#rolepush').empty();

        for(let i=0;i < count; i++){
            var id = data[i].id;
            var name = data[i].display_name;
            $("#rolepush").append(
                 `<option value="${id}">${name}</option>`
            );
        }

    }
});
}
</script>

</div>

@endsection
