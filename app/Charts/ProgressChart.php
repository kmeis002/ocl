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

    	$scoreHistory = $user->score()->get();
    	$hintHistory = $user->hintsUsed()->get();
    	$totalHistory = $scoreHistory->concat($hintHistory);
    	$totalHistory = $totalHistory->sortBy('created_at');
    	$sorted = $totalHistory->values()->all();
    	$totalScore = array(0);

    	$sum = 0;
    	$count = 0;

    	foreach($timeline as $t){
    		if($count < count($sorted) && $sorted[$count]->created_at->format('Y-m-d H:i:s') === $t){
    			if($sorted[$count]->points){
	    			$sum = $sorted[$count]->points + $sum;
	    		}else{
	    			$sum = $sum-config('score.hint_points');
	    		}
	    		$count = $count+1;
    		}
    		array_push($totalScore, $sum);
    	} 
    	$this->dataset('Total Score', 'line', $totalScore)->color('rgba(0,150,0,1)')->backgroundcolor('rgba(0,255,0,0.25)');
	}

    private function getTimeline(){
    	$out = collect([]);
    	$user = Auth::user();

    	//user creation date
    	$out->push($user->created_at->format('Y-m-d H:i:s'));

    	//get user score dates:
    	$scores = $user->score()->get();
    	$hints = $user->hintsUsed()->get();
    	$history = $scores->concat($hints);

    	$history = $history->sortBy('created_at');

    	foreach($history as $h){
    		$out->push($h->created_at->format('Y-m-d H:i:s'));
    	}

    	//current date
    	$out->push(date('Y-m-d H:i:s'));
    	return $out;
    }


    private function formatTimeLine($timeline){
    	$out = array();

    	foreach($timeline as $t){
    		array_push($out, date('M-j-y', strtotime($t)));
    	}

    	return $out;
    }

}
