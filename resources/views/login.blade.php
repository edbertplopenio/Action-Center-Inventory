@extends('layout')
@section('title', 'Login')
@section('content')
<div class="flex min-h-screen justify-center items-center px-6">
  <div class="lg:w-2/3 h-screen hidden lg:block">
    <img class="w-full h-full object-cover" src="{{ asset('images/home.jpg') }}" alt="Background Image">
  </div>
  <div class="lg:w-2/5 flex justify-center items-center">
    <div class="w-full max-w-md">
      <div class="text-center">
        <img class="mx-auto h-16 w-16" src="{{ asset('images/bsulogo.png') }}" alt="Logo">
        <h2 class="mt-4 text-lg font-semibold text-red-600">Sign in to your account</h2>
      </div>
      
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      <form class="space-y-3 flex flex-col items-center" action="{{ route('login.post') }}" method="POST">
        @csrf
        <!-- Email Field -->
        <div class="flex flex-col w-3/4">
          <label for="email" class="text-xs font-medium text-gray-900 mb-1">Email address</label>
          <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md border border-gray-300 px-3 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
        </div>

        <!-- Password Field -->
        <div class="flex flex-col w-3/4">
          <label for="password" class="text-xs font-medium text-gray-900 mb-1">Password</label>
          <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md border border-gray-300 px-3 py-1 text-xs text-gray-900 focus:ring-2 focus:ring-red-600">
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center w-3/4">
          <input type="checkbox" id="remember" name="remember" class="h-3 w-3 rounded border-gray-300 text-red-600 focus:ring-red-500">
          <label for="remember" class="ml-2 text-xs text-gray-900">Remember me</label>
        </div>

        <!-- Submit Button -->
        <div class="w-3/4">
          <button type="submit" class="w-full flex justify-center rounded-md bg-blue-500 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-600 focus:ring-2 focus:ring-red-600">
            Sign in
          </button>
        </div>
      </form>
      
      <p class="mt-4 text-center text-xs text-gray-500">
        Not a member? <a href="{{ route('registration') }}" class="font-semibold text-blue-500 hover:text-blue-600">Create an account</a>
      </p>
    </div>
  </div>
</div>

@if (session('status') == 'success')
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: 'Login successful!',
      showConfirmButton: false,
      timer: 1500
    });
  </script>
@endif

@if (session('status') == 'error')
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Oops...'
      text: 'Invalid credentials!',
      showConfirmButton: false,
      timer: 1500
    });
  </script>
@endif
@endsection