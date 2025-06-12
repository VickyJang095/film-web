<?php

namespace App\Interfaces;

interface MovieRepositoryInterface
{
    public function getAllMovies();
    public function getMovieById($id);
    public function createMovie(array $data);
    public function updateMovie($id, array $data);
    public function deleteMovie($id);
    public function index();
    public function store(array $data);
    public function getById($id);
    public function update(array $data, $id);
    public function delete($id);
}
