<?php

namespace Modules\pkgEvenement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Modules\PkgEvenement\Services\CommunauteService;

class CommunauteController extends Controller{

    protected $service;
    public function __construct(CommunauteService $Communauteservice)
    {
        // You can add middleware or other initializations here if needed
        $this->service = $Communauteservice;
    }

    // Define your methods for handling community-related requests here
    // For example:
    public function index()
    {
        // Logic to list communities
        return $this->service-> getAll(); // Assuming getAllCommunities is a method in the service
    }

    public function countCommunaute()
    {
        // Logic to count communities
        return $this->service->countCommunaute(); // Assuming countCommunaute is a method in the service
    }

}
