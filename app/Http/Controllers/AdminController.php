<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index() : View
    {
        return view("admin.stats");
    }
    public function stats (Request $request)
    {
        $startOfDay = Carbon::now()->subWeek()->startOfWeek()->startOfDay();
        $endOfDay = Carbon::now()->subWeek()->startOfWeek()->endOfDay();
        for ($i = 0; $i < 7; $i++) {
            $barChart[] = count(User::whereBetween("created_at", [$startOfDay, $endOfDay])->get()->toArray());
            $startOfDay->next("day");
            $endOfDay->next("day");
        }

        $dateFrom = Carbon::parse($request->dateFrom);
        $dateTo = Carbon::parse($request->dateTo);
        $pieChart[] = count(Post::whereBetween("created_at", [$dateFrom, $dateTo])->get()->toArray());
        $pieChart[] = count(Comment::whereBetween("created_at", [$dateFrom, $dateTo])->get()->toArray());

        return response()->json(["pieChart" => $pieChart, "barChart" => $barChart]);
    }
}
