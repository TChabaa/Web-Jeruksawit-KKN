<?php

namespace App\View\Components\Partials\Frontend;

use Illuminate\View\Component;

class SuratCard extends Component
{
    /**
     * The card title.
     *
     * @var string
     */
    public $title;

    /**
     * The card description.
     *
     * @var string|null
     */
    public $description;

    /**
     * The URL for the card action.
     *
     * @var string|null
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @param  string  $title
     * @param  string|null  $description
     * @param  string|null  $url
     * @return void
     */
    public function __construct($title, $description = null, $url = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.partials.frontend.surat-card');
    }
}
