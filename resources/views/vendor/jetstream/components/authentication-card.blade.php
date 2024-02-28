<div class="min-h-screen flex flex-row sm:justify-center iteml-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        <img src="default.png" alt="logo" srcset="" class="xl:w-70 xl:h-70 md:w-60 md:h-60 w-0 h-0 mr-12">
    </div>
    <div class="flex flex-col">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

    @if (str_contains(url()->current(), 'login'))
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg flex justify-center iteml-center">
    <span class="text-sm text-gray-600 pr-5">{{__('Don\'t have an account?')}}<a href="{{route('register')}}" class="text-blue-700 hover:text-blue-900 text-base font-bold mx-2">{{__('sign up')}}</a> </span>
    </div>
    @endif
</div>
</div>
