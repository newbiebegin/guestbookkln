<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Message extends Component
{
	public $isFullSize;
	
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isFullSize = false)
    {
        //
		$this->isFullSize = $isFullSize;
		
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.message');
    }
}
