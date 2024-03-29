<div>
    <input wire:model="seach" wire:keydown.debounce.1000ms="findProfile('{{$seach}}')"
     type="text" placeholder="sreach" class="border border-gary-300 border-solid text-center">

     @if($results != null)
     <ul class="absolute mt-2 w-auto bg-white p-1 shadow-lg border border-gray-500 border-solid z-10">
        @foreach($results as $profile)
        <li class="flex flex-row iteml-center justify-between my-1">
            <a href="/{{$profile['username']}}" class="font-bold text-blue-500 hover:underline">
                <img src="{{$profile['profile_photo_url'] }}" alt="{{$profile['username']}}" 
                class="rounded-full h-10 w-10 mr-24">
            </a>
            <span>
                <a href="/{{$profile['username']}}" class="font-blod text-blue-500 hover:underline">
                {{$profile['username']}}</a>
            </span>
        </li>
        @if(!$loop->last)
        <hr class="h-2">
        @endif
        @endforeach
     </ul>
     @endif
</div>
