<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\MovieRepositoryInterface;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;

class MovieController extends Controller
{
    use DispatchesJobs;

    protected $movieRepo;

    public function __construct(MovieRepositoryInterface $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }

    public function index() {
        return MovieResource::collection($this->movieRepo->index());
    }

    public function store(Request $request) {
        $movie = $this->movieRepo->store($request->all());
        return new MovieResource($movie);
    }

    public function show($id) {
        return new MovieResource($this->movieRepo->getById($id));
    }

    public function update(Request $request, $id) {
        $this->movieRepo->update($request->all(), $id);
        return response()->json(['message' => 'Updated successfully']);
    }

    public function destroy($id) {
        $this->movieRepo->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
