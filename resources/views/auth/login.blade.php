@extends('layouts.app')

@section('content')
    <div class="container w-full flex flex-wrap mx-auto px-2 pt-8">
        <section class="flex items-center justify-center mt-8 mx-auto">
            <div class="w-full sm:w-96 mx-4">
                <img src="/images/logo.png" class="h-24 mx-auto" alt="{{ config('app.name') }}">

                <div class="bg-white shadow-md border rounded px-8 pt-6 pb-8 mt-8">
                    <form action="/login" method="POST" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" autofocus required autocomplete="email">
                            @error('email')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div><!-- email -->
                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Password') }}</label>
                            <input type="password" id="password" name="password" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" autofocus required autocomplete="email">
                            @error('password')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div><!-- password -->
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Login') }}
                            </button>
                            <a href="#" class="ml-5 inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                {{ __('Forgot your password?') }}
                            </a>
                        </div>
                    </form>
                </div>
                <p class="text-center text-sm text-gray-500 mt-8">{{ config('app.name') }} &copy; {{ now()->format('Y') }}</p>
            </div>
        </section>
    </div><!-- .container -->
@endsection
