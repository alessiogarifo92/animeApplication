<?php

namespace App\Http\Controllers\Anime;

use App\Http\Controllers\Controller;
use App\Models\Comment\Comment;
use App\Models\Episode\Episode;
use App\Models\Following\Following;
use App\Models\Show\Show;
use App\Models\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimeController extends Controller
{

    public function animeDetails($id)
    {

        $show = Show::find($id);

        $randomShows = Show::select()->orderBy('id', 'desc')->take('5')->where('id', '!=', $id)->get();

        $comments = Comment::select()->orderBy('created_at', 'asc')->where('show_id', $id)->take(8)->get();

        $numberComments = Comment::where('show_id', $id)->count();

        $viewsShows = View::where('show_id', $id)->count();

        if (isset(Auth::user()->id)) {

            //validating follow
            $following = Following::where('show_id', $id)->where('user_id', Auth::user()->id)->count();

            //validating views 
            $validateViews = View::where('show_id', $id)->where('user_id', Auth::user()->id)->count();

            if ($validateViews == 0) {

                $views = View::create([
                    "show_id" => $id,
                    "user_id" => Auth::user()->id,
                ]);
            }
        } else {
            return view('shows.anime-details', compact('show', 'randomShows', 'comments', 'viewsShows', 'numberComments'));

        }

        return view('shows.anime-details', compact('show', 'randomShows', 'comments', 'following', 'viewsShows', 'numberComments'));
    }


    public function animePerCategory($category_name)
    {

        $animeList = Show::where('genre', $category_name)->get();

        $forYouShows = Show::select()->orderBy('name', 'asc')->take(4)->get();

        return view('shows.anime-categories', compact('animeList', 'category_name', 'forYouShows'));

    }

    public function storeComment(Request $request, $showId)
    {

        //validazione delle info del form 
        $validated = $request->validate([
            "comment" => "required",

        ]);


        $newComment = Comment::create([
            "show_id" => $showId,
            "user_name" => Auth::user()->name,
            "image" => Auth::user()->image,
            "comment" => $request->comment,
        ]);

        if ($newComment) {

            return redirect()->route('anime.details', $showId)->with(['comment' => 'New comment added!']);

        }
    }

    /**
     * Summary of follow
     * @param mixed $showId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow(Request $request, $showId)
    {

        $follow = Following::create([
            "show_id" => $showId,
            "user_id" => Auth::user()->id,
            "show_image" => $request->show_image,
            "show_name" => $request->show_name,
        ]);

        if ($follow) {

            return redirect()->route('anime.details', $showId)->with(['follow' => 'You started to follow this show!']);

        }
    }


    public function animeWatching($show_id, $episode_id)
    {

        $show = Show::find($show_id);

        $episode = Episode::where('episode_name', $episode_id)->where('show_id', $show_id)->first();

        $episodesInfo = Episode::select()->where('show_id', $show_id)->get();

        $comments = Comment::select()->orderBy('created_at', 'asc')->where('show_id', $show_id)->take(8)->get();

        return view('shows.anime-watching', compact('show', 'episode', 'episodesInfo', 'comments'));

    }


    public function searchShows(Request $request)
    {

        //con il get prendiamo il name dall'input che troviamo in request 
        $show = $request->get('show');

        $searches = Show::where('name', 'like', "%$show%")->orwhere('genre', 'like', "%$show%")->get();

        return view('shows.searches', compact('searches'));

    }



}