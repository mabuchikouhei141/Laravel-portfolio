<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Education;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::where('featured', true)->take(3)->get();
        $skills = Skill::all();
        
        return view('portfolio.index', compact('featuredProjects', 'skills'));
    }
    
    public function about()
    {
    // カテゴリー別にスキルをグループ化
    	$skillsByCategory = Skill::orderBy('level', 'desc')
        	->get()
        	->groupBy('category');
    
    	$experiences = Experience::orderBy('start_date', 'desc')->get();
    	$education = Education::orderBy('start_date', 'desc')->get();
    
    	return view('portfolio.about', compact('skillsByCategory', 'experiences', 'education'));
    }
}
