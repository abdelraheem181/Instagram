<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class Search extends Component
{
  private $profiles = null;
  public $seach = null;
  public $results = null;

  public function findProfile($seach)
  {
    if ($seach != null)
     {
      $this->profiles = 
      User::where('username', 'LIKE', '%'.$seach.'%')->where('id','<>', auth()->user()->id)
      ->take(5)->get();
     }
     else
      {
        $this->profiles = null;
        $this->results = null; 
      }
    
    if($this->profiles != null)
    {
        $fields = array();
        $filtered = array();
        foreach($this->profiles as $profile)
          {
          $fields['username'] = $profile->username;
          $fields['profile_photo_url'] = $profile->profile_photo_url;
          $filtered[] = $fields;
          }
          $this->results = $filtered ;
    }
  }

    public function render()
    {
        return view('livewire.search');
    }
}
