<?php

declare(strict_types=1);

namespace App\Http\Fractal;


use League\Fractal\Manager;
use Symfony\Component\HttpFoundation\Request;

trait FractalTrait
{
    /**
     * @var Manager
     */
    private $fractalManager;

    protected function fractal(Request $request) : Manager
    {
        if ($request->query->has('include')) {
            $this->fractalManager->parseIncludes($request->query->get('include'));
        }

        return $this->fractalManager;
    }

    public function setFractalManager(Manager $manager) : void
    {
        $this->fractalManager = $manager;
    }
}