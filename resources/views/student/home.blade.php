@extends('layouts.student')

@section('nav')
@include('student.nav.nav')
@endsection

@section('content')

<div class="container top-border"  id="vantajs">
    <pre class='text-center'><p class="ascii text-center my-5">
                                                                                                                                                                                                                                          
    ,o888888o.     8 888888888o   8 8888888888   b.             8               ,o888888o.  `8.`8888.      ,8' 8 888888888o   8 8888888888   8 888888888o.             8 8888                  .8.          8 888888888o      d888888o.   
 . 8888     `88.   8 8888    `88. 8 8888         888o.          8              8888     `88. `8.`8888.    ,8'  8 8888    `88. 8 8888         8 8888    `88.            8 8888                 .888.         8 8888    `88.  .`8888:' `88. 
,8 8888       `8b  8 8888     `88 8 8888         Y88888o.       8           ,8 8888       `8. `8.`8888.  ,8'   8 8888     `88 8 8888         8 8888     `88            8 8888                :88888.        8 8888     `88  8.`8888.   Y8 
88 8888        `8b 8 8888     ,88 8 8888         .`Y888888o.    8           88 8888            `8.`8888.,8'    8 8888     ,88 8 8888         8 8888     ,88            8 8888               . `88888.       8 8888     ,88  `8.`8888.     
88 8888         88 8 8888.   ,88' 8 888888888888 8o. `Y888888o. 8           88 8888             `8.`88888'     8 8888.   ,88' 8 888888888888 8 8888.   ,88'            8 8888              .8. `88888.      8 8888.   ,88'   `8.`8888.    
88 8888         88 8 888888888P'  8 8888         8`Y8o. `Y88888o8           88 8888              `8. 8888      8 8888888888   8 8888         8 888888888P'             8 8888             .8`8. `88888.     8 8888888888      `8.`8888.   
88 8888        ,8P 8 8888         8 8888         8   `Y8o. `Y8888           88 8888               `8 8888      8 8888    `88. 8 8888         8 8888`8b                 8 8888            .8' `8. `88888.    8 8888    `88.     `8.`8888.  
`8 8888       ,8P  8 8888         8 8888         8      `Y8o. `Y8           `8 8888       .8'      8 8888      8 8888      88 8 8888         8 8888 `8b.               8 8888           .8'   `8. `88888.   8 8888      88 8b   `8.`8888. 
 ` 8888     ,88'   8 8888         8 8888         8         `Y8o.`              8888     ,88'       8 8888      8 8888    ,88' 8 8888         8 8888   `8b.             8 8888          .888888888. `88888.  8 8888    ,88' `8b.  ;8.`8888 
    `8888888P'     8 8888         8 888888888888 8            `Yo               `8888888P'         8 8888      8 888888888P   8 888888888888 8 8888     `88.           8 888888888888 .8'       `8. `88888. 8 888888888P    `Y8888P ,88P' 
</p></pre>
</div>

<div class="container main-bg">
    <div class="container py-5 selector-grid">
        <div class="row w-100">
            <div class="col my-3">
                <a href="/student/list/resources/lab">
                    <div class="card bg-primary-trans overlay">
                        <i class="fas fa-flask fa-7x card-img-top text-center my-5"></i>
                        <div class="card-body"><p class="text-center">Lab Machines</p></div>
                    </div>
                </a>
            </div>
            <div class="col my-3">
                <a href="/student/list/resources/b2r">
                    <div class="card bg-primary-trans">
                        <i class="fas fa-hashtag fa-7x card-img-top text-center my-5"></i>
                        <div class="card-body"><p class="text-center">Boot2Root Machines</p></div>
                    </div>
                </a>
            </div>
            <div class="col my-3">
                <a href="/student/list/resources/ctf">
                    <div class="card bg-primary-trans">
                        <i class="fas fa-flag fa-7x card-img-top text-center my-5"></i>
                        <div class="card-body"><p class="text-center">Capture the Flags</p></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row w-100">
            <div class="col my-3">
                <div class="card bg-primary-trans">
                    <i class="fas fa-map fa-7x card-img-top text-center my-5"></i>
                    <div class="card-body"><p class="text-center">Guides</p></div>
                </div>
            </div>
            <div class="col my-3">
                <a href="/student/dashboard">
                    <div class="card bg-primary-trans">
                        <i class="fas fa-tachometer-alt fa-7x card-img-top text-center my-5"></i>
                        <div class="card-body"><p class="text-center">Dashboard</p></div>
                    </div>
                </a>
            </div>
            <div class="col my-3">
                <a href="/student/list/references">
                    <div class="card bg-primary-trans">
                        <i class="fas fa-book fa-7x card-img-top text-center my-5"></i>
                        <div class="card-body"><p class="text-center">Quick References</p></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
