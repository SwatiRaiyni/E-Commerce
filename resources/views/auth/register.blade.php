<x-guest-layout>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" encType="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="firstname" :value="__('FirstName')" />
                <x-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="lastname" :value="__('LastName')" />
                <x-input id="LastName" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus />
            </div>

            <!-- Number -->
            <div class="mt-4">
                <x-label for="number" :value="__('Number')" />
                <x-input id="number" class="block mt-1 w-full" type="tel" name="number" :value="old('number')" required />
            </div>

             <!-- DOB -->
             <div class="mt-4">
                <x-label for="dob" :value="__('DoB')" />
                <x-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required />
            </div>

            <!--profile picture -->
            <div class="mt-4">
                <x-label for="image"  :value="__('Select Profile')" />
                <x-input type="file" name="image" class=" block mt-1 w-full" :value="old('image')" required />
            </div>


            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
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


            {{-- <div class="form-group{{ $errors->has('CaptchaCode') ? ' has-error' : '' }}">
                <x-label class="col-md-4 control-label"/>Captcha

                  <div class="col-md-6">
                    {!! captcha_img('flat') !!}
                  <x-input class="form-control" type="text" id="CaptchaCode" name="CaptchaCode"/>

                   @if ($errors->has('CaptchaCode'))
                      <span class="help-block">
                   <strong>{{ $errors->first('CaptchaCode') }}</strong>
                     </span>
                  @endif

                </div>
           </div> --}}

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
