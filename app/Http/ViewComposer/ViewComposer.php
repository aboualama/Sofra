<?php 

namespace App\Http\ViewComposer;

use Illuminate\Contracts\View\View; 
use App\Models\City; 


class ViewComposer {

    public function compose(View $view) {
 
		$view->with('cities', City::all() );    

    }
}
 

