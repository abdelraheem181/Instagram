<x-app-layout>
      <x-slot name="header">
  
      </x-slot>
  
      <div class="grid grid-cols-12 mt-7 gap-4">
          <div class="col-start-3 col-span-5">
  
              @forelse($posts as $post)
              <div class="flex flex-col border border-solid border-gray-300 mb-14 bg-white">
                  <div class="flex flex-row p-3 border-b border-solid border-gray-300 iteml-center">
                      <a href="/{{$post->user->username}}">
                        <img src="{{$post->user->profile_photo_url}}" alt="{{$post->user->username}}" class="rounded-full h-12 w-12 mr-3" />
                      </a>
                      <a href="/{{$post->user->username}}" class="hover:underline">{{$post->user->username}}</a>
                  </div>
                  <div>
                      <a href="/posts/{{$post->id}}">
                          <img src="{{asset('storage/'. $post->image_path)}}" alt="" class="w-full">
                      </a>
                  </div>
                  <div class="flex flex-row iteml-center mt-2">
                        
                  </div>
                  <div class="border-b border-solid border-gray-200 pl-4 pb-1">
                      <div class="mr-7 mb-2">
                          <a href="/{{$post->user->username}}" class="font-bold text-base hover:underline">{{$post->user->username}}</a>
                          <span>{{$post->post_caption}}</span>
                      </div>
                      @foreach($post->comments as $comment)
                      @if($loop->iteration == 4)
                      @break
                      @endif
                      <div class="mr-7">
                          <a href="/{{$comment->user->username}}" class="font-bold hover:underline">
                              {{$comment->user->username}}
                          </a>
                          <span>{{$comment->comment}}</span>
                      </div>
                      @endforeach
                      @if($post->comments()->count() > 3)
                      <a href="/posts/{{$post->id}}" class="font-sm text-gray-700">{{__('View all')}} {{$post->comments()->count()}} {{__('Comments')}}</a>
                      @endif
                      <div class="text-gray-500 text-xs">
                          {{$post->created_at->format('M j o')}}
                      </div>
                  </div>
                  <div class="p-4">
                      <form action="/comments" method="POST" autocomplete="off">
                          @csrf
                          <div class="flex flex-row iteml-center justify-between">
                              <input type="text" name="comment" id="comment{{$post->id}}" placeholder="{{__('Add Comment')}}"  class="w-full outline-none border-none py-1 px-2" />
                              <input type="hidden" name="post_id" value="{{$post->id}}" />
                              <button type="submit" class="text-blue-500 hover:text-blue-700 font-semibold ml-2">{{__('Post')}}</button>
                          </div>
                      </form>
                  </div>
              </div>
              @empty
              <div class="m-10">
                  <p class="font-semibold">{{__('Start Your Journey, Follow Your Friends!')}}</p>
              </div>
              @endforelse
              <div class="col-span-3 mt-10">
                {{$posts->links()}}
             </div>
          </div>
          <div class="col-start-8 col-span-3 ml-4">
              <div class="flex flex-row iteml-center">
                  <a href="/{{$profile->username}}">
                      <img src="{{$profile->profile_photo_url}}" alt="avatar" class="rounded-full h-12 w-12 mr-3">
                  </a>
                  <div class="flex flex-col">
                      <a href="/{{$profile->username}}" class="text-base hover:underline">{{$profile->username}}</a>
                      <h3 class="text-sm text-gray-400">{{$profile->bio}}</h3>
                  </div>
              </div>
  
              <h3 class="mb-4 mt-4 text-gray-500 font-semibold">{{__('People You Follow: ')}}</h3>
              @forelse($iFollow as $follow)
              <div class="flex flex-col mb-3">
                  <div class="flex flex-row justify-between">
                      <div class="flex flex-row">
                          <a href="/{{$follow->username}}">
                              <img src="{{ $follow->profile_photo_url}}" alt="avatar" class="rounded-full w-10 h-10 mr-3">
                          </a>
                          <div class="flex flex-col self-center">
                              <a href="/{{$follow->username}}" class="text-base hover:underline">{{$follow->username}}</a>
                              <h3 class="text-sm text-gray-500 truncate" style="max-width: 25ch;">{{$follow->bio}}</h3>
                          </div>
                      </div>
                      @livewire('follow-button', ['profile_id'=> $follow->id], key($follow->username))
                  </div>
              </div>
              @empty
              <div class="my-10">
                  <p class="font-semibold">{{__('Nothing to show right now!')}}</p>
              </div>
              @endforelse
  
              <h3 class="mb-4 mt-4 text-gray-500 font-semibold">{{__('People You May Like To Follow: ')}}</h3>
              @forelse($toFollow as $follow)
              <div class="flex flex-col mb-3">
                  <div class="flex flex-row justify-between">
                      <div class="flex flex-row">
                          <a href="/{{$follow->username}}">
                              <img src="{{$follow->profile_photo_url}}" alt="avatar" class="rounded-full w-10 h-10 mr-3">
                          </a>
                          <div class="flex flex-col self-center">
                              <a href="/{{$follow->username}}" class="text-base hover:underline">{{$follow->username}}</a>
                              <h3 class="text-sm text-gray-500 truncate" style="max-width: 25ch;">{{$follow->bio}}</h3>
                          </div>
                      </div>
                      @livewire('follow-button', ['profile_id'=> $follow->id], key($follow->username))
                  </div>
              </div>
              @empty
              <div class="my-10">
                  <p class="font-semibold">{{__('Nothing to show right now!')}}</p>
              </div>
              @endforelse
  
          </div>
      </div>
  </x-app-layout>