<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use View; //se si usa view::make('xx') Facade

class PageController extends Controller
{
    protected $data = [
        [
            'name' => 'Francesca',
            'lastname' => 'Dallaserra'
        ],
        [
            'name' => 'James',
            'lastname' => 'Bond'
        ],
        [
            'name' => 'Harry',
            'lastname' => 'Potter'
        ]
    ];


//questo metodo mappera' la view 'about'
    public function about()
    {
        return view('about');
        
        //$view = app('view');
        //return $view->make('about');
        
        //return view::make('about');
    }
    
    public function blog()
    {
        return view('blog',
            [
                'img_url' => 'http://lorempixel.com/400/200',
                'img_title' => 'Immagine inclusa',
                'slot' => ''
            ]);
    }
    
    public function staff()
    {
        //passare dati alla view 
        //(metodo migliore se ci sono piu' dati)
        /*return view('staff', 
                [
                    'title'=>'Our staff', 
                    'staff'=> $this->data
                ]
        );*/
        
        //passare dati alla view - 
        //(metodo migliore se c'e' un solo dato)
        /*return view('staff')
            ->with('title', 'Our staff')
            ->with('staff', $this->data);
        */
        
        //passare dati alla view - con Eloquent 
        //(metodo migliore se c'e' un solo dato)
        /*return view('staff')
            ->withTitle('Our staff')
            ->withStaff($this->data);
        */
        
        //passare dati alla view - Compact 
        //(metodo migliore se ci sono variabili locali)
        $staff = $this->data;
        $title = 'Our staff';
        return view('staffb', compact('title','staff'));
        
        
    }
}
