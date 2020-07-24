<?php

namespace App\Charts;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;


class ProgressChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->makeLabels();
        $this->labData();
        $this->b2rData();
        $this->ctfData();
        $this->totalData();
    }


    private function makeLabels(){
    	$user = Auth::user();
    	$timeline = $this->getTimeline();
    	$this->labels($this->formatTimeLine($timeline));
    }

    private function labData(){
    	$user = Auth::user();

    	$timeline = $this->getTimeLine();

    	$labHistory = $user->labScore();
    	
    	$labScore = array(0);
    	$sum = 0;
    	$count = 0;

    	foreach($timeline as $t){
    		if($count < count($labHistory) && $labHistory[$count]->created_at->format('Y-m-d H:i:s') === $t){
    			$sum = $labHistory[$count]->points + $sum;
    			$count = $count+1;
    		}
    		array_push($labScore, $sum);
    	}

    	$this->dataset('Lab Score', 'line', $labScore)->color('rgba(150,150,0,1)')->backgroundcolor('rgba(255,255,0,0.25)');
    }

    private function b2rData(){
    	$user = Auth::user();

    	$timeline = $this->getTimeLine();

    	$b2rHistory = $user->b2rScore();
    	
    	$b2rScore = array(0);
    	$sum = 0;
    	$count = 0;

    	foreach($timeline as $t){
    		if($count < count($b2rHistory) && $b2rHistory[$count]->created_at->format('Y-m-d H:i:s') === $t){
    			$sum = $b2rHistory[$count]->points + $sum;
    			$count = $count+1;
    		}
    		array_push($b2rScore, $sum);
    	}

    	$this->dataset('Boot2Root Score', 'line', $b2rScore)->color('rgba(0,150,150,1)')->backgroundcolor('rgba(0,255,255,0.25)');
    }

    private function ctfData(){
    	$user = Auth::user();

    	$timeline = $this->getTimeLine();

    	$ctfHistory = $user->ctfScore();
    	
    	$ctfScore = array(0);
    	$sum = 0;
    	$count = 0;

    	foreach($timeline as $t){
    		if($count < count($ctfHistory) && $ctfHistory[$count]->created_at->format('Y-m-d H:i:s') === $t){
    			$sum = $ctfHistory[$count]->points + $sum;
    			$count = $count+1;
    		}
    		array_push($ctfScore, $sum);
    	}

    	$this->dataset('CTF Score', 'line', $ctfScore)->color('rgba(150,0,150,1)')->backgroundcolor('rgba(255,0,255,0.25)');
    }


	private function totalData(){
    	$user = Auth::user();

    	$timeline = $this->getTimeLine();

    	$totalHistory = $user->score()->get();
    	
    	$totalScore = array(0);
    	$sum = 0;
    	$count = 0;

    	foreach($timeline as $t){
    		if($count < count($totalHistory) && $totalHistory[$count]->created_at->format('Y-m-d H:i:s') === $t){
    			$sum = $totalHistory[$count]->points + $sum;
    			$count = $count+1;
    		}
    		array_push($totalScore, $sum);
    	}

    	$this->dataset('Total Score', 'line', $totalScore)->color('rgba(0,150,0,1)')->backgroundcolor('rgba(0,255,0,0.25)');
	}

    private function getTimeline(){
    	$out = array();
    	$user = Auth::user();

    	//user creation date
    	array_push($out, $user->created_at->format('Y-m-d H:i:s'));

    	//get user score dates:
    	$scores = $user->score()->get();

    	foreach($scores as $s){
    		array_push($out, $s->created_at->format('Y-m-d H:i:s'));
    	}

    	//current date
    	array_push($out, date('Y-m-d H:i:s'));

    	

    	return $out;
    }





    private function formatTimeLine(Array $timeline){
    	$out = array();

    	foreach($timeline as $t){
    		array_push($out, date('M-j-y', strtotime($t)));
    	}

    	return $out;
    }

}
