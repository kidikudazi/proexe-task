<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use External\Bar\Movies\MovieService as BarMovieService;
use External\Foo\Movies\MovieService as FooMovieService;
use External\Baz\Movies\MovieService as BazMovieService;

class MovieController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getTitles(Request $request, BarMovieService $barMovieService, FooMovieService $fooMovieService, BazMovieService $bazMovieService): JsonResponse
    {
        // TODO
        // Set initial state
        $state = 0;
        $retry = 0;

        while($state == 0) {
            try {
                $barTitles = ($barMovieService->getTitles())['titles'];
                $fooTitles = $fooMovieService->getTitles();
                $bazTitles = ($bazMovieService->getTitles())['titles'];

                // Pluck only title
                $barTitles = collect($barTitles)->pluck('title');

                $data = array_merge($barTitles->all(), $fooTitles, $bazTitles);
                return response()->json($data);
            }  catch (\Exception $e) {
                if ($retry == 5)  return response()->json(['status' => 'failed']);

                $state = 0;
                $retry++;
            }
        }
    }
}
