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
                <li class="breadcrumb-item active">Edit User</li>
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
                            {{-- @if (Auth::user()->hasRole('admin')) --}}
                            <form method="POST" action="/admin/edituser" encType="multipart/form-data">
                                {{-- @else
            <form method="POST" action="{{ route('editprofile') }}"  encType="multipart/form-data">
        @endif --}}
                                @csrf
                                <input type="hidden" name="id" id="userid" value="{{ $data['id'] }}">
                                {{-- <input type="hidden" name="user" value="{{$data['UserType']}}"> --}}
                                <!-- Name -->
                                <div>
                                    <x-label for="firstname" :value="__('FirstName')" />
                                    <x-input id="firstname" class="block mt-1 w-full" type="text" name="firstname"
                                        value="{{ $dataname[0] }}" required autofocus />
                                </div>

                                <div class="mt-4">
                                    <x-label for="lastname" :value="__('LastName')" />
                                    <x-input id="LastName" class="block mt-1 w-full" type="text" name="lastname"
                                        value="{{ $dataname[1] }}" required autofocus />
                                </div>

                                <!-- DOB -->
                                <div class="mt-4">
                                    <x-label for="dob" :value="__('DoB')" />
                                    <x-input id="dob" class="block mt-1 w-full" type="date" name="dob"
                                        value="{{ $data['DOB'] }}" required />
                                </div>

                                <!--profile picture -->
                                <div class="mt-4">
                                    <label>Select Profile</label>

                                    <input type="file" name="image" id="image" class=" block mt-1 w-full form-control">
                                    <input type="hidden" name="hidden_image" value="{{ $data['Profile'] }}"
                                        class="form-control">
                                    <img id="showImage" src="/storage/images/userprofile/{{ $data['Profile'] }}"
                                        width="100px" height="100px">
                                </div>

                                <!-- Email Address -->
                                {{-- <div class="mt-4">
            <x-label for="email" :value="__('Email')" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email"  value="{{$data['email']}}" required />
        </div> --}}

                                <!--select status -->

                                {{-- @if (Auth::user()->UserType == 2) --}}
                                {{-- @if (Auth::user()->hasRole('admin')) --}}
                                    @if (Auth::guard('admin')->user()->id != $data->id)
                                        <div class="mt-4">

                                            <x-label for="checkactive" :value="__('Status')" />
                                            <select name="checkactive" required :value="old('checkactive')"
                                                class="form-select block mt-1 w-full" aria-label="Default select example">
                                                @if ($data->IsApproved == 1)
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                @else
                                                    <option value="1">Active</option>
                                                    <option value="0" selected>Inactive</option>
                                                @endif
                                            </select>
                                        </div>
                                    @endif
                                {{-- @endif --}}

                                {{-- select role --}}

                                {{-- @if (Auth::user()->hasRole('admin')) --}}
                                    @if (Auth::guard('admin')->user()->id != $data->id)
                                        <div class="mt-4">

                                            <x-label for="checktype" :value="__('Status')" />
                                            <select name="checktype" id="type_sel" required :value="old('checktype')"
                                                onchange="roleselect()" class="form-select block mt-1 w-full"
                                                aria-label="Default select example">
                                                @if ($data->UserType == 1)
                                                    <option value="1" selected>Front User</option>
                                                    <option value="2">Backend User</option>
                                                @else
                                                    <option value="1">Front User</option>
                                                    <option value="2" selected>Backend User</option>
                                                @endif
                                            </select>
                                        </div>


                                    @endif
                                {{-- @endif --}}




                                {{-- @if (Auth::user()->hasRole('admin')) --}}
                                    @if (Auth::guard('admin')->user()->id != $data->id)
                                        <!-- Password -->
                                        <div class="mt-4">
                                            <x-label for="password" :value="__('Password')" />
                                            <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                                autocomplete="new-password" />
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mt-4">
                                            <x-label for="password_confirmation" :value="__('Confirm Password')" />
                                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                                name="password_confirmation" />
                                        </div>
                                    @endif
                                {{-- @endif --}}




                                <div class="flex items-center justify-end mt-4">

                                    <x-button class="ml-4">
                                        {{ __('Save') }}
                                    </x-button>

                            </form>


                            <a class="ml-4 btn btn-danger" href="/admin/usermangement">
                                {{ __('Cancel') }}
                            </a>



                        </x-auth-card>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#image").change(function(e) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $("#showImage").attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });
            });


          //  var language = window.location.pathname.substring(1,3);
    //         function roleselect() {
    //             var type_sel = $("#type_sel").val();
    //             var id = $("#userid").val();
    //             $.ajax({
    //                 url: '/'+language+'/editajax',
    //                 contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
    //                 type: 'GET',
    //                 dataType: 'json',
    //                 data: {
    //                     "_token": "{{ csrf_token() }}",
    //                     "type_sel": type_sel,
    //                     "id": id
    //                 },
    //                 success: function(data) {


    // $("#rolepush").html(data);
    //                     }

    //                // }
    //             });
    //         }
        </script>
    </x-app-layout>
</div>
@endsection
