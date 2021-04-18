<?php 
namespace App\Repositories; 

use App\Models\User;
use PDF;



class UserRepository {
    public function report(){
        $users= User::withCount('tweet')->get()->map->format();
        
       // share data to view
      view()->share('users',$users);
      $pdf = PDF::loadView('index', $users);

      // download PDF file with download method
      return $pdf->download('pdf_file.pdf');
      
    }
    
}