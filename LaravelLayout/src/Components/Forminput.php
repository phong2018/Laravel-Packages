<?php

namespace Phonglg\LaravelLayout\Components;

use Illuminate\View\Component;

class Forminput extends Component
{
    public $name;
    public $label;
    public $type;
    public $class;
    public $value;
    public $classLabel;
    public $classInput;
    public $message;
    public $listSelect;
    public $required;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name='',$label='',$type='',$class='',$value='',$classLabel='',$classInput='',$message='',$required='')
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->class = $class;
        $this->value = $value;
        $this->classLabel = $classLabel;
        $this->classInput = $classInput;
        $this->message = $message; 
        $this->required = $required; 
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('laravellayout::components.formInput');
    }
}

