<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Episode\Episode;
use App\Models\Show\Show;
use File;
use Hash;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Redirect;

class AdminsController extends Controller
{
    public function viewLogin()
    {
        return view("admins.login");
    }

    public function checkLogin(Request $request)
    {
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect()->route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    public function index()
    {

        $shows = Show::select()->count();
        $episodes = Episode::select()->count();
        $admins = Admin::select()->count();
        $categories = Category::select()->count();

        return view("admins.index", compact("shows", "episodes", "admins", "categories"));
    }

    public function allAdmins()
    {

        $admins = Admin::select()->orderBy('id', 'asc')->get();

        return view("admins.alladmins", compact("admins"));
    }

    public function createAdmins()
    {

        return view("admins.createadmins");
    }

    public function storeAdmin(Request $request)
    {

        $storeAdmins = Admin::create([
            "email" => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password),
        ]);

        if ($storeAdmins) {
            return Redirect::route('admins.all')->with(['success' => 'Admin created successfully!']);
        }

    }

    public function allShows()
    {

        $allShows = Show::select()->orderBy('id', 'asc')->get();

        return view("admins.allshows", compact("allShows"));
    }

    public function createShow()
    {

        $categories = Category::select()->get();

        return view("admins.createshow", compact('categories'));
    }

    public function storeShow(Request $request)
    {

        Request()->validate([
            "name" => "required | max:40",
            "image" => "required | max:600",
            "description" => "required",
            "type" => "required | max:40",
            "studios" => "required | max:40",
            "date_aired" => "required | max:40",
            "status" => "required | max:40",
            "genre" => "required | max:40",
            "duration" => "required | max:40",
            "quality" => "required | max:40",
        ]);

        $destinationPath = 'assets/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        $storeShows = Show::create([
            "name" => $request->name,
            "image" => $myimage,
            "description" => $request->description,
            "type" => $request->type,
            "studios" => $request->studios,
            "date_aired" => $request->date_aired,
            "status" => $request->status,
            "genre" => $request->genre,
            "duration" => $request->duration,
            "quality" => $request->quality,
        ]);

        if ($storeShows) {
            return Redirect::route('shows.all')->with(['success' => 'Show added successfully!']);
        }

    }

    public function deleteShow($show_id)
    {


        $show = Show::find($show_id);
        if (File::exists(public_path('assets/' . $show->image))) {
            File::delete(public_path('assets/' . $show->image));
        } else {
            //dd('File does not exists.');
        }
        $show->delete();

        if ($show) {
            return Redirect::route('shows.all')->with(['delete' => 'Show has been deleted!']);

        }
    }

    public function allGenres()
    {

        $allGenres = Category::select()->orderBy('id', 'asc')->get();

        return view("admins.allgenres", compact("allGenres"));
    }


    public function createGenre()
    {

        return view("admins.creategenre");
    }

    public function storeGenre(Request $request)
    {

        Request()->validate([
            "name" => "required | max:40",
        ]);

        $categories = Category::where('name', $request->name)->count();
        if($categories == 0){

            $storeGenre = Category::create($request->all());

            if($storeGenre){

                return Redirect::route('genres.all')->with(['success' => 'Genre added successfully!']);
            }
        }else{
            return Redirect::route('genres.create')->with(['failed' => 'Genre already exists!']);
        }
    }

    public function deleteGenre($genre_id)
    {


        $genre = Category::find($genre_id);
        if($genre->delete()){
            return Redirect::route('genres.all')->with(['delete' => 'Genre has been deleted!']);
        }else{
            return Redirect::route('genres.all')->with(['failed'=> 'Genre has not been deleted, try again in a while']);
        }
    }



    public function allEpisodes()
    {

        $allEpisodes = Episode::select()->orderBy('id', 'asc')->get();

        return view("admins.allepisodes", compact("allEpisodes"));
    }


    public function createEpisode()
    {

        $shows = Show::all();

        return view("admins.createepisode", compact('shows'));
    }

    public function storeEpisode(Request $request)
    {

        Request()->validate([
            "episode_name" => "required | max:40",
            "thumbnail" => "required | max:600",
            "video" => "required | max:600",
            "show_id" => "required | max:40",
        ]);

        $destinationPath = 'assets/thumbnails/';
        $mythumbnails = $request->thumbnail->getClientOriginalName();
        $request->thumbnail->move(public_path($destinationPath), $mythumbnails);
       
        $destinationPathVideo = 'assets/videos/';
        $myvideo = $request->video->getClientOriginalName();
        $request->video->move(public_path($destinationPathVideo), $myvideo);

        $storeEpisode = Episode::create([
            "episode_name" => $request->name,
            "thumbnail" => $mythumbnails,
            "video" => $myvideo,
            "show_id" => $request->show_id,
        ]);

        if ($storeEpisode) {
            return Redirect::route('episodes.all')->with(['success' => 'Episode added successfully!']);
        }

    }

    public function deleteEpisode($id)
    {


        $episode = Episode::find($id);
        if (File::exists(public_path('assets/videos/' . $episode->video))) {
            File::delete(public_path('assets/videos/' . $episode->video));
        } else {
            //dd('File does not exists.');
        }
        $episode->delete();

        if ($episode) {
            return Redirect::route('episodes.all')->with(['delete' => 'Episode has been deleted!']);

        }
    }
}